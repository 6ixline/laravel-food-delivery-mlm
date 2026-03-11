<?php

namespace App\Services;

use App\DTO\ProductVariantDTO;
use App\Models\ProductVariant;
use App\Models\ProductIngredient;
use Exception;
use Illuminate\Http\Request;
use App\Services\ProductIngredientService;


class ProductVariantService{

    private ProductIngredientService $productIngredientService;

    public function __construct(ProductIngredientService $productIngredientService)
    {
        $this->productIngredientService = $productIngredientService;
    }



    public function createProductVariant(Request $request, ProductVariantDTO $requestDTO){
        
        try {


         
            $productVariant = ProductVariant::create([
                'product_id' => $requestDTO->productid,
                'title'=> $requestDTO->title,
                // 'qty' => $requestDTO->qty,
                // 'unit' => $requestDTO->unit,
                'mrp' => $requestDTO->mrp,
                'price' => $requestDTO->price,
                'business_volume' => $requestDTO->business_volume,
                'status'=> $requestDTO->status,
            ]);

        

            foreach ($requestDTO->productIngredient as $ingredientDTO) {
                    $ingredientDTO->variant_id = $productVariant->id;
                    $ingredientDTO->product_id = $requestDTO->productid;
                    $this->productIngredientService->createProductIngredient($request, $ingredientDTO);
            }

            return $productVariant;

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updateProductVariant(Request $request, ProductVariantDTO $requestDTO){
        try {

            $productVariant = ProductVariant::where('id', $requestDTO->variantid)->firstOrFail();
            $updateData = [
                'product_id' => $requestDTO->productid,
                'title'=> $requestDTO->title,
                // 'qty' => $requestDTO->qty,
                // 'unit' => $requestDTO->unit,
                'mrp' => $requestDTO->mrp,
                'price' => $requestDTO->price,
                'business_volume' => $requestDTO->business_volume,
                'status'=> $requestDTO->status,
            ];

            $productVariant->update($updateData);

            


            $existingIngredientIds = ProductIngredient::where('product_variant_id', $productVariant->id)->pluck('id')->toArray();          
            $requestIngredientIds = array_column($requestDTO->productIngredient, 'product_ingredient_id');
            $ingredientIdsToRemove = array_diff($existingIngredientIds, $requestIngredientIds);

            foreach ($ingredientIdsToRemove as $ingredientId) {
                $this->productIngredientService->deleteProductIngredient($ingredientId);
            }

            foreach ($requestDTO->productIngredient as $ingredientDTO) {
                $ingredientDTO->variant_id = $productVariant->id;
                $ingredientDTO->product_id = $requestDTO->productid;

                 


                if (isset($ingredientDTO->product_ingredient_id)) {
                    $this->productIngredientService->updateProductIngredient($request, $ingredientDTO);
                } else {
                    $this->productIngredientService->createProductIngredient($request, $ingredientDTO);
                }
            }

            // echo "<pre>";
            //  print_r( $requestDTO->productIngredient );
            // exit;
      

            return $productVariant->fresh();
            
        } catch (Exception $e) {
            throw $e;
        }
    }

     public function bulkDeleteProductIngredientByIds($productVariantIds = [])
    {
        try {
            if (is_array($productVariantIds) && count($productVariantIds) > 0) {
                ProductVariant::whereIn('id', $productVariantIds)->delete();
            } else {
                throw new Exception('No Record selected for deletion.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }



    public function deleteProductVariant($id){
        try {
            $productVariant = ProductVariant::find($id);
            if (!$productVariant) {
                throw new Exception('Variant Not Found');
            }
            $productVariant->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}