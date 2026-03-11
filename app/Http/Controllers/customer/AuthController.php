<?php

namespace App\Http\Controllers\customer;

use App\DTO\BaseResponseDTO;
use App\DTO\MemberRequestDTO;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\PerformanceBonus;
use App\Models\UserOtp;
use App\Services\MemberService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    private MemberService $memberservice;

    public function __construct(MemberService $memberservice)
    {
        $this->memberservice = $memberservice;
    }

    public function registerCustomer(Request $request){
        try {
            //code...
            $this->validateRegisterRequest($request);
        } catch (Throwable $e) {
            //throw $th;
            $response = new BaseResponseDTO("error", $e->getMessage());
            return response()->json($response, 400);
        }

        try {
            // Attempt to create a new user
            $requestDTO = new MemberRequestDTO($request);
            $member = $this->memberservice->createMember($request, $requestDTO);
            $data['mobile'] = $member->mobile;

            // Generate OTP here and Save in UserOtp Table and Send to the User

            $otpCode = rand(1000, 9999);
            UserOtp::create([
                'memberid' => $member->id,
                'otp' => $otpCode,
                'role'=> "customer",
                'exp_time'=> now()->addMinutes(10),
            ]);
            $response = new BaseResponseDTO("success", "Register Successfully!", $data);

        } catch (QueryException $e) {
            $message = $e->getMessage();
            if ($e->errorInfo[0] === '23000') { // General SQLSTATE code for integrity constraint violation
                if (strpos($e->getMessage(), '1062') !== false) { // MySQL unique constraint violation
                    $message = 'Mobile Number Already in use.';
                }
                if (strpos($e->getMessage(), '1452') !== false) { // MySQL foreign key constraint violation
                    $message = 'Something went wrong!';
                }
            }
            if($e->errorInfo[0] === '01000'){
                $message = 'Something went wrong!';
            }
            $response = new BaseResponseDTO("error", $message);
            return response()->json($response, 400);
        } catch (Throwable $e) {
            // Check for specific SQLSTATE error codes
            $response = new BaseResponseDTO("error", $e->getMessage());
            return response()->json($response, 400);
        }

        return response()->json($response, 200);
        
    }
   
    public function login(Request $request){
        try {
            $validated = $request->validate([
                "mobile"=> "required|min:10"
            ]);
        } catch (Throwable $th) {
            $response = new BaseResponseDTO("error", $th->getMessage());
            return response()->json($response, 400);
        }
        
        try {
            $member = Member::where('mobile', $validated['mobile'])
                    ->first();

            if($member !== null){
                $otpCode = UserOtp::where("memberid", $member->id)
                            ->where('exp_time', '>', now())
                            ->first();
                if($otpCode != null){
                    $otpCode->exp_time = now()->addMinutes(10);
                    $otpCode->save();
                }else{
                    $otpCode = rand(1000, 9999);
                    UserOtp::create([
                        'memberid' => $member->id,
                        'otp' => $otpCode,
                        'role'=> "customer",
                        'exp_time'=> now()->addMinutes(10),
                    ]);
                }
                $data['mobile'] = $member->mobile;
                $response = new BaseResponseDTO("success", "OTP Sent Successfully!", $data);
                               
                return response()->json($response);
            }else{
                $response = new BaseResponseDTO("error", "No User Found!");
                return response()->json($response, 400); 
            }

        } catch (Throwable $th) {
            $response = new BaseResponseDTO("error", $th->getMessage());
            return response()->json($response, 400);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            $response = new BaseResponseDTO("error", "Token not provided.");
            return response()->json($response, 400);
        }

        try {
            // Invalidate the token
            JWTAuth::setToken($token);
            JWTAuth::invalidate($token);
            $response = new BaseResponseDTO("success", 'Successfully logged out.');
            return response()->json($response, 200);

        } catch (JWTException $e) {
            $response = new BaseResponseDTO("error", 'Failed to log out.');
            return response()->json($response, 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        try{
            $validated = $request->validate([
                'mobile' => 'required',
                'otp_code' => 'required|numeric|digits:4',
            ]);

            $user = Member::where("mobile", $validated['mobile'])->first();

            if($user == null){
                $response = new BaseResponseDTO('error', "User Not Found!");
                return response()->json($response, 400);
            }


            $user->isVerified = true;
            $user->save();
            
            $otpRecord = UserOtp::where('memberid', $user->id)
                                ->where('otp', $validated['otp_code'])
                                ->where('exp_time', '>', now())
                                ->first();
        
            if (!$otpRecord) {
                $response = new BaseResponseDTO("error", "Invalid or expired OTP");
                return response()->json($response, 400);
            }
            
            $performaceBonusData = PerformanceBonus::find($user->rewardid);
            $performanceRank = "";
            if($performaceBonusData){
                $performanceRank = $performaceBonusData->title;
            }
        
            // Generate JWT
            $token = auth("member")->login($user);  // Assuming you're using JWT Auth package
        
            $response = new BaseResponseDTO("success", "Verification Successful!", ["token"=> $token, 'userInfo'=>["name"=> $user->name, "email"=> $user->email, "mobile"=> $user->mobile, 'mid'=> $user->membership_id, 'sponsorid'=> $user->sponsor_id, 'img_url'=> $user->imgName ? $user->image_url : "", 'performanceRank'=> $performanceRank]]);
            return response()->json($response, 200);
        }catch(Throwable $e){
            $response = new BaseResponseDTO("error", $e->getMessage());
            return response()->json($response, 400);
        }
       
    }

    public function resendOtp(Request $request){
        try{
            $validated = $request->validate([
                "mobile"=> "required|min:10"
            ]);
        }catch(Throwable $e){
            $response = new BaseResponseDTO("error", $e->getMessage());
            return response()->json($response, 400);
        }

        try {
            $member = Member::where('mobile', $validated['mobile'])
                    ->first();

            if($member !== null){
                $otpCode = UserOtp::where("memberid", $member->id)
                            ->where('exp_time', '>', now())
                            ->first();
                if($otpCode != null){
                    $otpCode->exp_time = now()->addMinutes(10);
                    $otpCode->save();
                }else{
                    $otpCode = rand(1000, 9999);
                    UserOtp::create([
                        'memberid' => $member->id,
                        'otp' => $otpCode,
                        'role'=> "customer",
                        'exp_time'=> now()->addMinutes(10),
                    ]);
                }
                $data['mobile'] = $member->mobile;
                $response = new BaseResponseDTO("success", "OTP Sent Successfully!", $data);
                               
                return response()->json($response);
            }else{
                $response = new BaseResponseDTO("error", "No User Found!");
                return response()->json($response, 400); 
            }

        } catch (Throwable $th) {
            $response = new BaseResponseDTO("error", $th->getMessage());
            return response()->json($response, 400);
        }
    }


    private function validateRegisterRequest(Request $request){
        return $request->validate([
            "name"=> "string|required",
            "email"=> "nullable|email",
            "mobile"=> "required|min:10",
            "sponsor_id" => "string|required"
        ]);
    }

}