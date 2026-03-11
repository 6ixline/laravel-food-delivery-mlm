<?php

namespace App\Services;

use App\DTO\PlanUpdateDTO;
use App\Models\PlanSetting;
use Exception;
use Illuminate\Http\Request;

class PlanSettingService{
   
    public function updatePlan(Request $request, PlanUpdateDTO $requestDTO){
        try {
           
            $plan = PlanSetting::where('id', $requestDTO->planid)->firstOrFail();
            $updateData = [
                'tds' => $requestDTO->tds,
                'activation_reward_point' => $requestDTO->activation_reward_point,
                'direct_referral_per' => $requestDTO->direct_referral_per,
                'minimum_order' => $requestDTO->minimum_order
            ];
            $plan->update($updateData);

            return $plan->fresh();
        } catch (Exception $e) {
            throw $e;
        }
    }

}