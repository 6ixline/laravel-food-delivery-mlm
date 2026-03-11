<?php

namespace App\Services;

use App\DTO\ProductIngredientDTO;
use App\Models\ProductIngredient;
use Exception;
use Illuminate\Http\Request;


class ProductIngredientService{
    public function createProductIngredient(Request $request, ProductIngredientDTO $requestDTO){
        
        try {

           
            $productIngredient = ProductIngredient::create([
                'product_id' => $requestDTO->product_id,
                'product_variant_id'=> $requestDTO->variant_id,
                'ingredients_id' => $requestDTO->items_name,
                'qty' => $requestDTO->qty,
                'unit' => $requestDTO->unit
            ]);

           

            return $productIngredient;

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updateProductIngredient(Request $request, ProductIngredientDTO $requestDTO){
        try {

            $productIngredient = ProductIngredient::where('id', $requestDTO->product_ingredient_id)->firstOrFail();
            $updateData = [
                'product_id' => $requestDTO->product_id,
                'product_variant_id'=> $requestDTO->variant_id,
                'ingredients_id' => $requestDTO->items_name,
                'qty' => $requestDTO->qty,
                'unit' => $requestDTO->unit
            ];

            $productIngredient->update($updateData);

            return $productIngredient->fresh();
            
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteProductIngredient($id){
        try {
            $productIngredient = ProductIngredient::find($id);
            if (!$productIngredient) {
                throw new Exception('Variant Not Found');
            }
            $productIngredient->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}