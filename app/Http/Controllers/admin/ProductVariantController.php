<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\ProductVariantService;
use Exception;
use Throwable;
use App\DTO\ProductVariantDTO;
use Illuminate\Database\QueryException;

class ProductVariantController extends Controller
{

    private ProductVariantService $productVariantService;

    public function __construct(ProductVariantService $productVariantService) {
        $this->productVariantService = $productVariantService;
    }

    public function store( Request $request){

       
      
        try {
           $this->validateProductVariantRequest($request);
        } catch(Exception $e){

            return redirect()->route("admin.productVariant", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id,'productid'=> $request->productid ])->withErrors(['error' => $e->getMessage()])->withInput();
       
        }



        try {

           $requestDTO = new ProductVariantDTO($request);

       
           $this->productVariantService->createProductVariant($request,$requestDTO);

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
            return redirect()->route("admin.productVariant", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id,'productid'=> $request->productid])->withErrors(['error' => $message])->withInput();

        }catch (Exception $e) {
            // Check for specific SQLSTATE error codes
            return redirect()->route("admin.productVariant", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id ,'productid'=> $request->productid])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.productVariant", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id ,'productid'=> $request->productid])->with('success', 'Product Added successfully!');



    }


    public function updateProductVariant(Request $request){

   

        try {
            $this->validateProductVariantRequest($request);
        }catch(Exception $e){

            return redirect()->route("admin.productVariant", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id,'productid'=> $request->productid, 'id' => $request->variantid ])->withErrors(['error' => $e->getMessage()])->withInput();
       
        }


          
       

        try {

           $requestDTO = new ProductVariantDTO($request);

            
           $this->productVariantService->updateProductVariant($request,$requestDTO);
          
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
            return redirect()->route("admin.productVariant", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id,'productid'=> $request->productid , 'id' => $request->variantid])->withErrors(['error' => $message])->withInput();

        }catch (Exception $e) {
            // Check for specific SQLSTATE error codes
            return redirect()->route("admin.productVariant", ['view' => 'form', 'mode'=> $request->mode, 'kitchen_id'=> $request->kitchen_id ,'productid'=> $request->productid, 'id' => $request->variantid])->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()->route("admin.productVariant", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id ,'productid'=> $request->productid])->with('success', 'Product Added successfully!');

    }


    public function productVariantActions(Request $request){
         

        if($request->bulk_actions == "delete"){
            try{
                $this->productVariantService->bulkDeleteProductIngredientByIds($request->input('del_items'));
                
                return redirect()->route("admin.productVariant", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id, 'productid'=> $request->productid])
                ->with('success', 'Selected Product Variant deleted successfully!');
            } catch (Throwable $e) {
                return redirect()->route("admin.productVariant", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id ,'productid'=> $request->productid])
                ->with(['error' => 'An error occurred: ' . $e->getMessage()]);
            }
        
        }else{
            $query = ProductVariant::query();

            if ($request->filled('datefrom')) {
                $query->whereDate('created_at', '>=', $request->datefrom);
            }

            if ($request->filled('dateto')) {
                $query->whereDate('created_at', '<=', $request->dateto);
            }

            $productVariantRows = $query->orderBy('id', 'desc')->get();

            $productRow = Product::find($request->productid)->first();
            if (!$productRow) {
                return redirect()->route("admin.product", ['view' => 'list', 'kitchen_id'=> $request->kitchen_id])->with('error', 'Product not found.');
            }


            return view("admin.productVariant.product-variant-list", ['productVariants' => $productVariantRows , "datefrom"=> $request->datefrom, "dateto"=> $request->dateto, 'productid'=>$request->productid,  'kitchen_id' => $request->kitchwen_id ]);

        }

    

    }




    public function validateProductVariantRequest($request){

        return $request->validate([
            'title' => 'required|string|max:255',
            'mrp' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'business_volume' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:active,inactive', // optional: use enum validation
            'productid' => 'required|exists:sk_products,id', 
        ]);

    }
    
}