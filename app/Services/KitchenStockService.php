<?php

namespace App\Services;

use App\DTO\KitchenStockDTO;
use App\Models\Category;
use App\Models\KitchenStock;
use Exception;
use Illuminate\Http\Request;


class KitchenStockService{

    public function createKitchenStock(Request $request ,KitchenStockDTO $requestDTO){
        
        try {

            $kitchenStock = KitchenStock::create([
                'ingredients_id' => $requestDTO->ingredients_id,
                'qty' => $requestDTO->qty,
                'kitchen_id' => $requestDTO->kitchen_id,
                'status'=> $requestDTO->status ? $requestDTO->status : "active"
            ]);

            return $kitchenStock;

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updateKitchenStock(Request $request , KitchenStockDTO $requestDTO) {
        try {
            $kitchenStock = KitchenStock::where('id', $requestDTO->id )->firstOrFail();
            $updateData = [
                'ingredients_id' => $requestDTO->ingredients_id,
                'qty' => $requestDTO->qty,
                'kitchen_id' => $requestDTO->kitchen_id, 
                'status'=> $requestDTO->status
            ];

            $kitchenStock->update($updateData);

            return $kitchenStock->fresh();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function bulkDeleteKitchenStockByIds($kitchenIds = [])
    {
        try {
            if (is_array($kitchenIds) && count($kitchenIds) > 0) {
                KitchenStock::whereIn('id', $kitchenIds)->delete();
            } else {
                throw new Exception('No Record selected for deletion.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteKitchen($id){
        try {
            $kitchen = KitchenStock::find($id);
            if (!$kitchen) {
                throw new Exception('Record not found.');
            }
            $kitchen->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}