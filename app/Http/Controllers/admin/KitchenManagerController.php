<?php

namespace App\Http\Controllers\admin;

use App\DTO\KitchenManagerDTO;
use App\Http\Controllers\Controller;
use App\Models\KitchenManager;
use App\Services\KitchenManagerService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;

class KitchenManagerController extends Controller
{
    //
    private KitchenManagerService $kitchenManagerService;

    public function __construct(KitchenManagerService $kitchenManagerService)
    {
        $this->kitchenManagerService = $kitchenManagerService;
    }
    //

    public function store(Request $request)
    {
        // Validate the incoming request data
        try{
            $this->validateKitchenManagerRequest($request);
        }catch(Exception $e){
            return redirect()->route("admin.kitchenManager", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }
        
        try {
            // Attempt to create a new Performance Bonus
            $requestDTO = new KitchenManagerDTO($request);
            $this->kitchenManagerService->createKitchenManager($request, $requestDTO);

        } catch (QueryException $e) {
            $message = "Error! while added manager";
            if ($e->errorInfo[0] === '23000') { // General SQLSTATE code for integrity constraint violation
                if (strpos($e->getMessage(), '1062') !== false) { // MySQL unique constraint violation
                    $message = 'This Mobile Number is already in use.';
                }
            }
            if($e->errorInfo[0] === '01000'){
                $message = 'Please give a valid status value';
            }
            return redirect()->route("admin.kitchenManager", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $message])->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.kitchenManager", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.kitchenManager", ['view' => 'list'])->with('success', 'Kitchen Manager Added successfully!');
    }

    public function updateKitchenManger(Request $request){
        // Validate the incoming request data
        try {
            $this->validateKitchenManagerRequest($request);
        } catch (Exception $e) {
            return redirect()->route("admin.kitchenManager", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        try {

            // Create DTO and update Kitchen Manager
            $requestDTO = new KitchenManagerDTO($request);
            $this->kitchenManagerService->updateKitchenManager($request, $requestDTO);

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
            return redirect()->route("admin.kitchenManager", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $message])
                ->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.kitchenManager", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route("admin.kitchenManager", ['view' => 'list'])
            ->with('success', 'Kitchen Manager updated successfully!');
    }

    public function kitchenManagerActions(Request $request){
        if($request->bulk_actions == "delete"){
            try{
                $this->kitchenManagerService->bulkDeleteKitchenManagerByIds($request->input('del_items'));
                return redirect()->route("admin.kitchenManager", ['view' => 'list'])
                ->with('success', 'Selected Kitchen Manager deleted successfully!');
            } catch (Throwable $e) {
                return redirect()->route("admin.kitchenManager", ['view' => 'list'])
                ->with(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        
        }else{
            $query = KitchenManager::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $kitchenManagerRows = $query->orderBy('id', 'desc')->get();

            return view("admin.kitchenManager.kitchen-manager-list", ['kitchenManagerRows' => $kitchenManagerRows, "datefrom"=> $request->datefrom, "dateto"=> $request->dateto]);
        }

    }


    public function validateKitchenManagerRequest($request){
        return  $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:10',
        ]);
    }
}
