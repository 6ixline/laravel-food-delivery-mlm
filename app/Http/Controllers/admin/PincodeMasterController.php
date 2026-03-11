<?php

namespace App\Http\Controllers\admin;

use App\DTO\BaseResponseDTO;
use App\DTO\PincodeMasterDTO;
use App\Http\Controllers\Controller;
use App\Models\PincodeMaster;
use App\Services\PincodeMasterService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;

class PincodeMasterController extends Controller
{
    //
    private PincodeMasterService $pincodeMasterService;

    public function __construct(PincodeMasterService $pincodeMasterService)
    {
        $this->pincodeMasterService = $pincodeMasterService;
    }
    //

    public function store(Request $request)
    {
        // Validate the incoming request data
        try{
            $this->validatePincodeMasterRequest($request);
        }catch(Exception $e){
            return redirect()->route("admin.pincodeMaster", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }
        
        try {
            // Attempt to create a new Performance Bonus
            $requestDTO = new PincodeMasterDTO($request);
            $this->pincodeMasterService->createPincodeMaster($request, $requestDTO);

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
            return redirect()->route("admin.pincodeMaster", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $message])->withInput();
        } catch (Exception $e) {
            // Check for specific SQLSTATE error codes
            return redirect()->route("admin.pincodeMaster", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.pincodeMaster", ['view' => 'list'])->with('success', 'Pincode Added successfully!');
    }

    public function updatePincodeMaster(Request $request){
        // Validate the incoming request data
        try {
            $this->validatePincodeMasterRequest($request);
        } catch (Exception $e) {
            return redirect()->route("admin.pincodeMaster", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        try {

            // Create DTO and update Performace Bonus
            $requestDTO = new PincodeMasterDTO($request);
            $this->pincodeMasterService->updatePincodeMaster($request, $requestDTO);

        } catch (QueryException $e) {
            $message = "Error! While Updating the . Please Try again.";
            if ($e->errorInfo[0] === '23000') {
                if (strpos($e->getMessage(), '1062') !== false) {
                    $message = 'Duplicate entry.';
                }
                if (strpos($e->getMessage(), '1452') !== false) {
                    $message = 'Foreign key constraint fails.';
                }
            }
            return redirect()->route("admin.pincodeMaster", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $message])
                ->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.pincodeMaster", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route("admin.pincodeMaster", ['view' => 'list'])
            ->with('success', 'Pincode updated successfully!');
    }

    public function pincodeMasterActions(Request $request){
        if($request->bulk_actions == "delete"){
            try{
                $this->pincodeMasterService->bulkDeletePincodeMasterByIds($request->input('del_items'));
                return redirect()->route("admin.pincodeMaster", ['view' => 'list'])
                ->with('success', 'Selected Pincode deleted successfully!');
            } catch (Throwable $e) {
                return redirect()->route("admin.pincodeMaster", ['view' => 'list'])
                ->with(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        
        }else{
            $query = PincodeMaster::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $pincodeMasterRows = $query->orderBy('id', 'desc')->get();

            return view("admin.pincodeMaster.pincode-master-list", ['pincodeMasterRows' => $pincodeMasterRows, "datefrom"=> $request->datefrom, "dateto"=> $request->dateto]);
        }

    }

    public function getPincode(Request $request){
        try{
            $validated = $request->validate([
                'q' => "string|nullable",
                'per_page'=> "string|nullable",
                'offset'=> "string|nullable"
            ]);
            $q = $validated['q'] ?? "";
            $per_page = $validated['per_page'] ?? "10";
            $offset = $validated['offset'] ?? "0";
            $pincodes = $this->pincodeMasterService->getPincode($q, $per_page, $offset);
            $response = new BaseResponseDTO('success', 'Pincode fetched successfully!', $pincodes);
            return response()->json($response, 200);
        }catch(Throwable $th){
            $response = new BaseResponseDTO('error', $th->getMessage());
            return response()->json($response, 400);
        }
    }


    public function validatePincodeMasterRequest($request){
        return  $request->validate([
            'pincode' => 'required|string|max:255',
            'area' => 'string',
            'city' => 'string',
            'state' => 'string',
            'country' => 'string',
        ]);
    }
}
