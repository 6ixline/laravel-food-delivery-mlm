<?php

namespace App\Http\Controllers\admin;

use App\DTO\BaseResponseDTO;
use App\DTO\ProductDTO;
use App\Http\Controllers\Controller;
use App\Models\Kitchen;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    //

    public function store(Request $request)
    {
        // Validate the incoming request data
        try{
            $this->validateProductRequest($request);
        }catch(Exception $e){
            return redirect()->route("admin.product", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id])->withErrors(['error' => $e->getMessage()])->withInput();
        }
        
        try {
            // Attempt to create a new Product
            $requestDTO = new ProductDTO($request);
            $this->productService->createProduct($request, $requestDTO);

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
            return redirect()->route("admin.product", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id])->withErrors(['error' => $message])->withInput();
        } catch (Exception $e) {
            // Check for specific SQLSTATE error codes
            return redirect()->route("admin.product", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.product", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id])->with('success', 'Product Added successfully!');
    }

    public function updateProduct(Request $request){


        // Validate the incoming request data
        try {
            $this->validateProductRequest($request);
        } catch (Exception $e) {
            return redirect()->route("admin.product", ['view' => 'form', 'mode' => $request->mode, 'kitchen_id'=> $request->kitchen_id])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

       

        try {

            // Create DTO and update Product
            $requestDTO = new ProductDTO($request);
            $this->productService->updateProduct($request, $requestDTO);

        } catch (QueryException $e) {
            $message = "Error! While Updating the . Please Try again.";
            if ($e && $e->errorInfo && $e->errorInfo[0] === '23000') {
                if (strpos($e->getMessage(), '1062') !== false) {
                    $message = 'Duplicate entry.';
                }
                if (strpos($e->getMessage(), '1452') !== false) {
                    $message = 'Foreign key constraint fails.';
                }
            }
            return redirect()->route("admin.product", ['view' => 'form', 'mode' => $request->mode, 'kitchen_id'=> $request->kitchen_id, 'productid' => $request->productid])
                ->withErrors(['error' => $message])
                ->withInput();
        } catch (Exception $e) {
            return redirect()->route("admin.product", ['view' => 'form', 'mode' => $request->mode, 'kitchen_id'=> $request->kitchen_id, 'productid' => $request->productid])
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }

        return redirect()->route("admin.product", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id])
            ->with('success', 'Product updated successfully!');
    }


    public function productActions(Request $request){
        if($request->bulk_actions == "delete"){
            try{
                $this->productService->bulkDeleteProductByIds($request->input('del_items'));
                return redirect()->route("admin.product", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id])
                ->with('success', 'Selected Product deleted successfully!');
            } catch (Throwable $e) {
                return redirect()->route("admin.product", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id])
                ->with(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        
        }else{
            $query = Product::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $productRows = $query->orderBy('id', 'desc')->get();

            $kitchen = Kitchen::find($request->kitchen_id)->select(['name', 'id'])->first();
            if (!$kitchen) {
                return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Kitchen not found.');
            }

            return view("admin.product.product-list", ['productRows' => $productRows, "datefrom"=> $request->datefrom, "dateto"=> $request->dateto, 'kitchen_id'=> $request->kitchen_id, 'kitchen'=> $kitchen]);
        }

    }

    public function getProduct(Request $request)
    {
        try{
            $validated = $request->validate([
                "q"=> "nullable|string",
                "per_page" => "String",
                'includes' => 'nullable|string', 
                'offset' =>  "String",
                'catid'=> "Integer",
                'pincode'=> "String"
            ]);
            $per_page = $validated['per_page'] ?? "10";
            $includes = $validated['includes'] ?? '';
            $q = $validated['q'] ?? '';
            $catid = $validated['catid'] ?? "";
            $offset = $validated['offset'] ?? 0;
            $pincode = $validated['pincode'] ?? "";
            $products = $this->productService->getProduct($q, $per_page, $includes, $catid, $offset, $pincode);

            $response = new BaseResponseDTO("success", "Product Fetched Successfully!", $products);
            return response()->json($response, 200);
            
        }catch(Throwable $th){
            $response = new BaseResponseDTO("error", $th->getMessage());
            return response()->json($response, 400);
        }
    }

    public function validateProductRequest($request){
        return  $request->validate([
            'name' => 'required|string|max:255',
            'kitchen_id' => 'nullable|numeric',
            'category_id' => 'nullable|numeric',
            'remarks' => 'nullable|string',
            'status' => 'nullable|string',
        ]);
    }
}
