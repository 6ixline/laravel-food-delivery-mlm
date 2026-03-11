<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\DTO\KitchenStockDTO;
use App\Models\Kitchen;
use App\Models\KitchenStock;
use App\Services\KitchenStockService;
use Exception;
use Illuminate\Database\QueryException;
use Throwable;

class KitchenStockController extends Controller
{
    private KitchenStockService $KitchenStockService;

    public function __construct(KitchenStockService $KitchenStockService)
    {
        $this->KitchenStockService = $KitchenStockService;
    }
    //

    public function store(Request $request)
    {
        // Validate the incoming request data
        try{
            
            $this->validateKitchenRequest($request);

            
            $exists = KitchenStock::where('ingredients_id', $request->ingredients_id)
                     ->where('kitchen_id', $request->kitchen_id)
                     ->exists();

            if ($exists) {
                return redirect()->route('admin.kitchenStock', [
                        'view' => 'form',
                        'mode' => $request->mode,
                        'kitchen_id' => $request->kitchen_id
                    ])
                    ->withErrors(['error' => 'The item you selected already exists in this kitchen!'])
                    ->withInput();
            }
   

        }catch(Exception $e){
            return redirect()->route("admin.kitchenStock", ['view' => 'form','mode'=> $request->mode,'kitchen_id' => $request->kitchen_id])->withErrors(['error' => $e->getMessage()])->withInput();
        }
        
        try {

           
            $requestDTO  = new KitchenStockDTO($request);

            $this->KitchenStockService->createKitchenStock($request , $requestDTO);



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
            return redirect()->route("admin.kitchenStock", ['view' => 'form', 'mode'=> $request->mode ,'kitchen_id' => $request->kitchen_id ])->withErrors(['error' => $message])->withInput();
        } catch (Exception $e) {
            // Check for specific SQLSTATE error codes
            return redirect()->route("admin.kitchenStock", ['view' => 'form', 'mode'=> $request->mode ,'kitchen_id' => $request->kitchen_id ])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.kitchenStock", ['view' => 'list','kitchen_id' => $request->kitchen_id ])->with('success', 'Kitchen Stock Added successfully!');
    }

    public function updateKitchenStock(Request $request){
        // Validate the incoming request data
       
        try {
             

            $this->validateKitchenRequest($request);

            $exists = KitchenStock::where('ingredients_id', $request->ingredients_id)
            ->where('kitchen_id', $request->kitchen_id)
            ->where('id', '!=', $request->id)  // Exclude this id
            ->exists();

          
            if ($exists) {
                return redirect()->route('admin.kitchenStock', [
                        'view' => 'form',
                        'mode' => $request->mode,
                        'kitchen_id' => $request->kitchen_id,
                        'id' => $request->id
                    ])
                    ->withErrors(['error' => 'The item you selected already exists in this kitchen!'])
                    ->withInput();
            }

        } catch (Exception $e) {
            return redirect()->route("admin.kitchenStock", ['view' => 'form', 'mode' => $request->mode , 'id' => $request->id, 'kitchen_id' => $request->kitchen_id ])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
        

        try {
           
            
            $requestDTO  = new KitchenStockDTO($request);
            $this->KitchenStockService->updateKitchenStock($request , $requestDTO);

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
            return redirect()->route("admin.kitchenStock", ['view' => 'form', 'mode' => $request->mode ,'id' => $request->id, 'kitchen_id' => $request->kitchen_id ])
                ->withErrors(['error' => $message])
                ->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.kitchenStock", ['view' => 'form', 'mode' => $request->mode , 'id' => $request->id, 'kitchen_id' => $request->kitchen_id ])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route("admin.kitchenStock", ['view' => 'list' , 'kitchen_id' => $request->kitchen_id])
            ->with('success', 'Kitchen Stock updated successfully!');
    }


    public function kitchenStockActions(Request $request){

    
        if($request->bulk_actions == "delete"){
            try{
                $this->KitchenStockService->bulkDeleteKitchenStockByIds($request->input('del_items'));
                return redirect()->route("admin.kitchenStock", ['view' => 'list', 'kitchen_id' => $request->kitchen_id])
                ->with('success', 'Selected Kitchen Stock deleted successfully!');
            } catch (Throwable $e) {
                return redirect()->route("admin.kitchenStock", ['view' => 'list' , 'kitchen_id' => $request->kitchen_id])
                ->with(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        
        }else{
            $query = KitchenStock::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $kitchenStockRows = $query->orderBy('id', 'desc')->get();

          
            $kitchen = Kitchen::find($request->kitchen_id)->first();
            if (!$kitchen) {
                return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Kitchen not found.');
            }

        
            return view("admin.kitchenStock.kitchen-stock-list", [ 'kitchen' => $kitchen,'kitchenStockRows' => $kitchenStockRows, 'kitchen_id' =>  $request->kitchenid,  "datefrom"=> $request->datefrom, "dateto"=> $request->dateto]);
        }

    }


    public function validateKitchenRequest($request){
        return  $request->validate([
            'ingredients_id' => 'required|numeric',
            'qty' => 'required|string|max:255',
            'kitchen_id' => 'nullable|numeric',
            'status' => 'nullable|string',
        ]);
    }


    
}

