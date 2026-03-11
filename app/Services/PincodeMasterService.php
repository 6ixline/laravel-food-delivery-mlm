<?php

namespace App\Services;

use App\DTO\PincodeMasterDTO;
use App\Models\PincodeMaster;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class PincodeMasterService{
    public function createPincodeMaster(Request $request, PincodeMasterDTO $requestDTO){
        
        try {
            $pincodeMaster = PincodeMaster::create([
                'pincode' => $requestDTO->pincode,
                'area' => $requestDTO->area,
                'city' => $requestDTO->city,
                'state' => $requestDTO->state,
                'country' => $requestDTO->country,
                'remarks' => $requestDTO->remarks,
                'status'=> $requestDTO->status ? $requestDTO->status : "active"
            ]);

            return $pincodeMaster;

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updatePincodeMaster(Request $request, PincodeMasterDTO $requestDTO){
        try {

            $pincodeMaster = PincodeMaster::where('id', $requestDTO->pinid)->firstOrFail();
            $updateData = [
                'pincode' => $request->pincode,
                'area' => $request->area,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'remarks' => $request->remarks,
                'status' => $requestDTO->status ?? $pincodeMaster->status
            ];

            $pincodeMaster->update($updateData);

            return $pincodeMaster->fresh();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function bulkDeletePincodeMasterByIds($pincodeMasterIds = [])
    {
        try {
            if (is_array($pincodeMasterIds) && count($pincodeMasterIds) > 0) {
                PincodeMaster::whereIn('id', $pincodeMasterIds)->delete();
            } else {
                throw new Exception('No Record selected for deletion.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deletePincodeMaster($id){
        try {
            $pincodeMaster = PincodeMaster::find($id);
            if (!$pincodeMaster) {
                throw new Exception('Record not found.');
            }
            $pincodeMaster->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getPincode(
        string $q = '', 
        int $limit = 20, 
        int $offset = 0
    ){
        try{

            $query = PincodeMaster::query();
              // Apply search scope
            if (!empty($q)) {
                $query->searchTerm($q);
            }
            $pincodes = $query
                        ->select(['id', 'pincode', 'area', 'city', 'state', 'country'])
                        ->orderBy('pincode')
                        ->limit($limit)
                        ->offset($offset)
                        ->get();

            return $pincodes->toArray();
        }catch(Throwable $th){
            return $th;
        }
    }
    
}