<?php

namespace App\Http\Controllers\admin;

use App\DTO\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Kitchen;
use App\Services\CategoryService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    //

    public function store(Request $request)
    {
        // Validate the incoming request data
        try{
            $this->validateCategoryRequest($request);
        }catch(Exception $e){
            return redirect()->route("admin.category", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id])->withErrors(['error' => $e->getMessage()])->withInput();
        }
        
        try {
            // Attempt to create a new Category
            $requestDTO = new CategoryDTO($request);
            $this->categoryService->createCategory($request, $requestDTO);

        } catch (QueryException $e) {
            $message = "Something went Wrong!";
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
            return redirect()->route("admin.category", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id])->withErrors(['error' => $message])->withInput();
        } catch (Exception $e) {
            // Check for specific SQLSTATE error codes
            return redirect()->route("admin.category", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.category", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id])->with('success', 'Category Added successfully!');
    }

    public function updateCategory(Request $request){
        // Validate the incoming request data
        try {
            $this->validateCategoryRequest($request);
        } catch (Exception $e) {
            return redirect()->route("admin.category", ['view' => 'form', 'mode' => $request->mode, 'kitchen_id'=> $request->kitchen_id])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        try {

            // Create DTO and update Category
            $requestDTO = new CategoryDTO($request);
            $this->categoryService->updateCategory($request, $requestDTO);

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
            return redirect()->route("admin.category", ['view' => 'form', 'mode' => $request->mode, 'kitchen_id'=> $request->kitchen_id])
                ->withErrors(['error' => $message])
                ->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.category", ['view' => 'form', 'mode' => $request->mode, 'kitchen_id'=> $request->kitchen_id])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route("admin.category", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id])
            ->with('success', 'Category updated successfully!');
    }


    public function categoryActions(Request $request){
        if($request->bulk_actions == "delete"){
            try{
                $this->categoryService->bulkDeleteCategoryByIds($request->input('del_items'));
                return redirect()->route("admin.category", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id])
                ->with('success', 'Selected Category deleted successfully!');
            } catch (Throwable $e) {
                return redirect()->route("admin.category", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id])
                ->with(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        
        }else{
            $query = Category::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $categoryRows = $query->orderBy('id', 'desc')->get();

            $kitchen = Kitchen::find($request->kitchen_id)->select(['name', 'id'])->first();
            if (!$kitchen) {
                return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Kitchen not found.');
            }

            return view("admin.category.category-list", ['categoryRows' => $categoryRows, "datefrom"=> $request->datefrom, "dateto"=> $request->dateto, 'kitchen_id'=> $request->kitchen_id, 'kitchen'=> $kitchen]);
        }

    }


    public function validateCategoryRequest($request){
        return  $request->validate([
            'title' => 'required|string|max:255',
            'kitchen_id' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
    }
}
