<?php

namespace App\Services;

use App\DTO\PerformanceBonusDTO;
use App\Models\PerformanceBonus;
use Exception;
use Illuminate\Http\Request;


class PerformanceBonusService{
    public function createPerformanceBonus(Request $request, PerformanceBonusDTO $requestDTO){
        
        try {
            $performanceBonus = PerformanceBonus::create([
                'title' => $request->title,
                'bv_range_start' => $request->bv_range_start,
                'bv_range_end' => $request->bv_range_end,
                'incentive' => $request->incentive,
                'monthly_self_bv' => $request->monthly_self_bv,
                'remarks' => $requestDTO->remarks,
                'status'=> $requestDTO->status ? $requestDTO->status : "active"
            ]);

            return $performanceBonus;

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updatePerformanceBonus(Request $request, PerformanceBonusDTO $requestDTO){
        try {

            $performanceBonus = PerformanceBonus::where('id', $requestDTO->pid)->firstOrFail();
            $updateData = [
                'title' => $request->title,
                'bv_range_start' => $request->bv_range_start,
                'bv_range_end' => $request->bv_range_end,
                'incentive' => $request->incentive,
                'monthly_self_bv' => $request->monthly_self_bv,
                'remarks' => $requestDTO->remarks,
                'status' => $requestDTO->status ?? $performanceBonus->status
            ];

            $performanceBonus->update($updateData);

            return $performanceBonus->fresh();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function bulkDeletePerformanceBonusByIds($performanceBonusIds = [])
    {
        try {
            if (is_array($performanceBonusIds) && count($performanceBonusIds) > 0) {
                PerformanceBonus::whereIn('id', $performanceBonusIds)->delete();
            } else {
                throw new Exception('No Record selected for deletion.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deletePerformanceBonus($id){
        try {
            $performanceBonus = PerformanceBonus::find($id);
            if (!$performanceBonus) {
                throw new Exception('Record not found.');
            }
            $performanceBonus->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}