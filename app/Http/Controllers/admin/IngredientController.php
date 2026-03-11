<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DTO\IngredientDTO;
use App\Models\Ingredient;
use App\Services\IngredientService;
use Exception;

class IngredientController extends Controller
{

    private IngredientService $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }


     public function store(Request $request)
    {
        // Validate the incoming request data
        try{
            $this->validateIngredientRequest($request);
        }catch(Exception $e){
            return redirect()->route("admin.ingredient", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }
        
        try {
          
            $requestDTO = new IngredientDTO($request);

            $this->ingredientService->createIngredient($request, $requestDTO);

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
            return redirect()->route("admin.ingredient", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $message])->withInput();
        } catch (Exception $e) {
            // Check for specific SQLSTATE error codes
            return redirect()->route("admin.ingredient", ['view' => 'form', 'mode'=> $request->mode])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.ingredient", ['view' => 'list'])->with('success', 'Ingredient Added successfully!');
    }

    public function updateIngredient(Request $request){
        // Validate the incoming request data
        try {
            $this->validateIngredientRequest($request);
        } catch (Exception $e) {
            return redirect()->route("admin.ingredient", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        try {

            // Create DTO and update Kitchen
            $requestDTO = new IngredientDTO($request);
            $this->ingredientService->updateIngredient($request, $requestDTO);

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
            return redirect()->route("admin.ingredient", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $message])
                ->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.ingredient", ['view' => 'form', 'mode' => $request->mode])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route("admin.ingredient", ['view' => 'list'])
            ->with('success', 'Ingredient updated successfully!');
    }


    public function ingredientActions(Request $request){
        if($request->bulk_actions == "delete"){
            try{
                $this->ingredientService->bulkDeleteIngredientByIds($request->input('del_items'));
                return redirect()->route("admin.ingredient", ['view' => 'list'])
                ->with('success', 'Selected Ingredient deleted successfully!');
            } catch (Throwable $e) {
                return redirect()->route("admin.ingredient", ['view' => 'list'])
                ->with(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        
        }else{
            $query = Ingredient::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $ingredientRows = $query->orderBy('id', 'desc')->get();

            return view("admin.ingredient.ingredient-list", ['ingredientRows' => $ingredientRows, "datefrom"=> $request->datefrom, "dateto"=> $request->dateto]);
        }

    }


    public function validateIngredientRequest($request){
        return  $request->validate([
            'title' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'status' => 'nullable|string',
        ]);
    }
    
}
