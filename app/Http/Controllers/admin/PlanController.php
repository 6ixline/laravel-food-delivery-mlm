<?php

namespace App\Http\Controllers\admin;

use App\DTO\PlanUpdateDTO;
use App\Http\Controllers\Controller;
use App\Services\PlanSettingService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    private PlanSettingService $planSettingService;

    public function __construct(PlanSettingService $planSettingService)
    {
        $this->planSettingService = $planSettingService;
    }
    //
    public function updatePlan(Request $request){

        // Validate the incoming request data
        try {
            $this->validateRegisterRequest($request);
            if ($request->password !== $request->confirm_password) {
                return redirect()->route("admin.plan", ['view' => 'form', 'mode' => $request->mode, 'planid'=> $request->planid])
                    ->withErrors(['error' => 'Password and confirm password do not match.'])
                    ->withInput();
            }
        } catch (Exception $e) {
            return redirect()->route("admin.plan", ['view' => 'form', 'mode' => $request->mode, 'planid'=> $request->planid])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        try {

            // Create DTO and update plan
            $requestDTO = new PlanUpdateDTO($request);
            $this->planSettingService->updatePlan($request, $requestDTO);

           
        } catch (QueryException $e) {
            $message = "Error! While Updating the plan. Please Try again.";
            if ($e->errorInfo[0] === '23000') {
                if (strpos($e->getMessage(), '1062') !== false) {
                    $message = 'Duplicate entry.';
                }
                if (strpos($e->getMessage(), '1452') !== false) {
                    $message = 'Foreign key constraint fails.';
                }
            }
            return redirect()->route("admin.plan", ['view' => 'form', 'mode' => $request->mode, 'planid'=> $request->planid])
                ->withErrors(['error' => $message])
                ->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.plan", ['view' => 'form', 'mode' => $request->mode, 'planid'=> $request->planid])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route("admin.plan", ['view' => 'form', 'mode' => $request->mode, 'planid'=> $request->planid])
            ->with('success', 'Plan Setting updated successfully!');
    }

    public function validateRegisterRequest($request){
        return  $request->validate([
            'planid' => 'required|string|max:255',
            'tds' => 'required|numeric',
            'activation_reward_point' => 'required|numeric',
            'direct_referral_per' => 'required|numeric',
            'minimum_order'=> 'required|numeric',
        ]);
    }
}
