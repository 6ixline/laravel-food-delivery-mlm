<?php

namespace App\Http\Controllers\admin;

use App\DTO\MemberRequestDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member; // Make sure to import your Member model
use App\Services\MemberService;
use Exception;
use Illuminate\Database\QueryException;
use Throwable;

class MemberController extends Controller
{

    private MemberService $memberservice;

    public function __construct(MemberService $memberservice)
    {
        $this->memberservice = $memberservice;
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        try{
            $this->validateRegisterRequest($request);
        }catch(Exception $e){
            return redirect()->route("admin.members", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }
        
        try {
            // Attempt to create a new user
            $requestDTO = new MemberRequestDTO($request);
            $this->memberservice->createMember($request, $requestDTO);

        } catch (QueryException $e) {
            $message = "";
            if ($e->errorInfo[0] === '23000') { // General SQLSTATE code for integrity constraint violation
                if (strpos($e->getMessage(), '1062') !== false) { // MySQL unique constraint violation
                    $message = 'Duplicate entry.';
                }
                if (strpos($e->getMessage(), '1452') !== false) { // MySQL foreign key constraint violation
                    $message = 'Foreign key constraint fails.';
                }
            }
            if($e->errorInfo[0] === '01000'){
                $message = 'Please give a valid status value';
            }
            return redirect()->route("admin.members", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $message])->withInput();
        } catch (Exception $e) {
            // Check for specific SQLSTATE error codes
            return redirect()->route("admin.members", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.members", ['view' => 'list'])->with('success', 'Member registered successfully!');
    }

    public function updateMember(Request $request){
        // Validate the incoming request data
        try {
            $this->validateRegisterRequest($request);
            if ($request->password !== $request->confirm_password) {
                return redirect()->route("admin.members", ['view' => 'form', 'mode' => $request->mode, 'regid'=> $request->regid])
                    ->withErrors(['error' => 'Password and confirm password do not match.'])
                    ->withInput();
            }
        } catch (Exception $e) {
            return redirect()->route("admin.members", ['view' => 'form', 'mode' => $request->mode, 'regid'=> $request->regid])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        try {

            // Create DTO and update member
            $requestDTO = new MemberRequestDTO($request);
            $this->memberservice->updateMember($request, $requestDTO);

        } catch (QueryException $e) {
            $message = "Error! While Updating the member. Please Try again.";
            if ($e->errorInfo[0] === '23000') {
                if (strpos($e->getMessage(), '1062') !== false) {
                    $message = 'Duplicate entry.';
                }
                if (strpos($e->getMessage(), '1452') !== false) {
                    $message = 'Foreign key constraint fails.';
                }
            }
            return redirect()->route("admin.members", ['view' => 'form', 'mode' => $request->mode, 'regid'=> $request->regid])
                ->withErrors(['error' => $message])
                ->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.members", ['view' => 'form', 'mode' => $request->mode, 'regid'=> $request->regid])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route("admin.members", ['view' => 'list'])
            ->with('success', 'Member updated successfully!');
    }

    public function deleteMember(Request $request){
        dd($request);
        try {
            $this->memberservice->deleteMember($request->input('id'));
            return redirect()->route("admin.members", ['view' => 'list'])
            ->with('success', 'Member Deleted successfully!');
        } catch (Throwable $e) {
            return redirect()->route("admin.members", ['view' => 'list'])
                ->with('error', 'Error deleting member: ' . $e->getMessage());
        }
    }

    public function memberActions(Request $request){
        if($request->bulk_actions == "delete"){
            try{
                $this->memberservice->bulkDeleteMemberByIds($request->input('del_items'));
                return redirect()->route("admin.members", ['view' => 'list'])
                ->with('success', 'Selected members deleted successfully!');
            } catch (Throwable $e) {
                return redirect()->route("admin.members", ['view' => 'list'])
                ->with(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        
        }else if(isset($request->excel)){
            $query = Member::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $members = $query->orderBy('created_at', 'desc')->get();

            if (count($members) == 0) {
                return redirect()->route("admin.members", ['view' => 'list'])
                    ->with('error', 'No Records found!');
            }


            return view('admin.members.export-excel', compact('members'));
        }else{
            $query = Member::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $members = $query->orderBy('created_at', 'desc')->get();

            return view("admin.members.register-list", ['registerRows' => $members, "datefrom"=> $request->datefrom, "dateto"=> $request->dateto]);
        }

    }


    public function memberGenealogy(Request $request){
        try {
            $id = $request->regid;
            $member = Member::find($id);
            if (!$member) {
                return redirect()->route("admin.members", ['view' => 'list'])
                    ->with(['error' => 'Member not found.']);
            }

            return view("admin.members.genealogy", ['registerRow' => $member]);
        } catch (Exception $e) {
            return redirect()->route("admin.members", ['view' => 'list'])
                ->with(['error' => 'Error fetching member: ' . $e->getMessage()]);
        }
        
    }


    public function fetchMember(Request $request)
    {

        $membershipId = $request->input('sponsor_id');
        $member = Member::where('membership_id', $membershipId)->first();

        if ($member) {
            return response()->json($member);
        } else {
            return response()->json('no', 404);
        }
    }


    public function validateRegisterRequest($request){
        return  $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:10',
            'gender'=> 'nullable|string',
            'father_name'=> 'nullable|string',
            'mobile'=> 'required|string',
            "mobile_alt"=> "nullable|string",
            "aadhaar_no"=> "nullable|string",
            "pancard_no"=> "nullable|string",
        ]);
    }
}
