<?php

namespace App\Services;
use App\Models\Ingredient;
use Exception;
use Illuminate\Http\Request;
use App\DTO\IngredientDTO;

class IngredientService{

    public function createIngredient(Request $request ,IngredientDTO $requestDTO){
        
        try {

            $ingredient = Ingredient::create([
                'title' => $requestDTO->title,
                'unit' => $requestDTO->unit,
                'status'=> $requestDTO->status ? $requestDTO->status : "active"
            ]);

            return  $ingredient;

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updateIngredient(Request $request , IngredientDTO $requestDTO) {
        try {
            $ingredient = Ingredient::where('id', $requestDTO->id )->firstOrFail();
            $updateData = [
                'title' => $requestDTO->title,
                'unit' => $requestDTO->unit,
                'status'=> $requestDTO->status
            ];

            $ingredient->update($updateData);

            return $ingredient->fresh();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function bulkDeleteIngredientByIds($ingredientIds = [])
    {
        try {
            if (is_array($ingredientIds) && count($ingredientIds) > 0) {
                Ingredient::whereIn('id', $ingredientIds)->delete();
            } else {
                throw new Exception('No Record selected for deletion.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteIngredient($id){
        try {
            $ingredient = Ingredient::find($id);
            if (!$ingredient) {
                throw new Exception('Record not found.');
            }
            $ingredient->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}