<?php

namespace App\Services;

use App\DTO\KitchenDTO;
use App\Models\Category;
use App\Models\Kitchen;
use Exception;
use Illuminate\Http\Request;


class KitchenService{

    public function createKitchen(Request $request, KitchenDTO $requestDTO){
        
        try {
            $kitchen = Kitchen::create([
                'name' => $requestDTO->name,
                'address' => $requestDTO->address,
                'primary_pincode_id' => $requestDTO->primary_pincode_id,
                'kitchen_manager_id' => $requestDTO->kitchen_manager_id,
                'remarks' => $requestDTO->remarks,
                'status'=> $requestDTO->status ? $requestDTO->status : "active"
            ]);

            $categories = ["Starters", "Drinks", "Main Course", "Side Dishes", "Desserts", "Snacks", "Chinese food"];

            foreach($categories as $category){
                Category::create([
                    'title' => $category,
                    'kitchen_id' => $kitchen->id,
                ]);
            }

            return $kitchen;

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updateKitchen(Request $request, KitchenDTO $requestDTO){
        try {
            $kitchen = Kitchen::where('id', $requestDTO->kitchenid)->firstOrFail();
            $updateData = [
                'name' => $requestDTO->name,
                'address' => $requestDTO->address,
                'primary_pincode_id' => $requestDTO->primary_pincode_id,
                'kitchen_manager_id' => $requestDTO->kitchen_manager_id,
                'remarks' => $requestDTO->remarks,
                'status' => $requestDTO->status ?? $kitchen->status
            ];

            $kitchen->update($updateData);

            return $kitchen->fresh();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function bulkDeleteKitchenByIds($kitchenIds = [])
    {
        try {
            if (is_array($kitchenIds) && count($kitchenIds) > 0) {
                Kitchen::whereIn('id', $kitchenIds)->delete();
            } else {
                throw new Exception('No Record selected for deletion.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteKitchen($id){
        try {
            $kitchen = Kitchen::find($id);
            if (!$kitchen) {
                throw new Exception('Record not found.');
            }
            $kitchen->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}