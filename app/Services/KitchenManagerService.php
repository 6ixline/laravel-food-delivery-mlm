<?php

namespace App\Services;

use App\DTO\KitchenManagerDTO;
use App\Models\KitchenManager;
use Exception;
use Illuminate\Http\Request;


class KitchenManagerService{
    public function createKitchenManager(Request $request, KitchenManagerDTO $requestDTO){
        
        try {
            $kitchenManger = KitchenManager::create([
                'name' => $requestDTO->name,
                'mobile' => $requestDTO->mobile,
                'email' => $requestDTO->email,
                'remarks' => $requestDTO->remarks,
                'status'=> $requestDTO->status ? $requestDTO->status : "active"
            ]);

            return $kitchenManger;

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updateKitchenManager(Request $request, KitchenManagerDTO $requestDTO){
        try {

            $kitchenManger = KitchenManager::where('id', $requestDTO->managerid)->firstOrFail();
            $updateData = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'remarks' => $request->remarks,
                'status' => $requestDTO->status ?? $kitchenManger->status
            ];

            $kitchenManger->update($updateData);

            return $kitchenManger->fresh();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function bulkDeleteKitchenManagerByIds($kitchenMangerIds = [])
    {
        try {
            if (is_array($kitchenMangerIds) && count($kitchenMangerIds) > 0) {
                KitchenManager::whereIn('id', $kitchenMangerIds)->delete();
            } else {
                throw new Exception('No Record selected for deletion.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteKitchenManager($id){
        try {
            $kitchenManger = KitchenManager::find($id);
            if (!$kitchenManger) {
                throw new Exception('Record not found.');
            }
            $kitchenManger->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}