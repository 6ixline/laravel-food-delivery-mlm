<?php

namespace App\Http\Controllers\admin;

use App\DTO\KitchenDTO;
use App\Http\Controllers\Controller;
use App\Models\Kitchen;
use App\Services\KitchenService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;

class KitchenController extends Controller
{
    private KitchenService $kitchenService;

    public function __construct(KitchenService $kitchenService)
    {
        $this->kitchenService = $kitchenService;
    }
    //

    public function store(Request $request)
    {
        // Validate the incoming request data
        try{
            $this->validateKitchenRequest($request);
        }catch(Exception $e){
            return redirect()->route("admin.kitchen", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }
        
        try {
          
            $requestDTO = new KitchenDTO($request);

            $this->kitchenService->createKitchen($request, $requestDTO);

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
            return redirect()->route("admin.kitchen", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $message])->withInput();
        } catch (Exception $e) {
            // Check for specific SQLSTATE error codes
            return redirect()->route("admin.kitchen", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.kitchen", ['view' => 'list'])->with('success', 'Kitchen Added successfully!');
    }

    public function updateKitchen(Request $request){
        // Validate the incoming request data
        try {
            $this->validateKitchenRequest($request);
        } catch (Exception $e) {
            return redirect()->route("admin.kitchen", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        try {

            // Create DTO and update Kitchen
            $requestDTO = new KitchenDTO($request);
            $this->kitchenService->updateKitchen($request, $requestDTO);

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
            return redirect()->route("admin.kitchen", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $message])
                ->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.kitchen", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route("admin.kitchen", ['view' => 'list'])
            ->with('success', 'Kitchen updated successfully!');
    }


    public function kitchenActions(Request $request){
        if($request->bulk_actions == "delete"){
            try{
                $this->kitchenService->bulkDeleteKitchenByIds($request->input('del_items'));
                return redirect()->route("admin.kitchen", ['view' => 'list'])
                ->with('success', 'Selected Kitchen deleted successfully!');
            } catch (Throwable $e) {
                return redirect()->route("admin.kitchen", ['view' => 'list'])
                ->with(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        
        }else{
            $query = Kitchen::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $kitchenRows = $query->orderBy('id', 'desc')->get();

            return view("admin.kitchen.kitchen-list", ['kitchenRows' => $kitchenRows, "datefrom"=> $request->datefrom, "dateto"=> $request->dateto]);
        }

    }


    public function validateKitchenRequest($request){
        return  $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'primary_pincode_id' => 'nullable|numeric',
            'kitchen_manager_id' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
    }
}
