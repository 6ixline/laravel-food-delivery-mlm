<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class PlanUpdateDTO
{

    public ?float $planid;
    public ?float $tds;
    public ?float $activation_reward_point;
    public ?float $direct_referral_per;
    public ?float $minimum_order;

    public function __construct(Request $request){
        try {
            $this->planid = $request->planid;
            $this->tds = $request->tds;
            $this->activation_reward_point = $request->activation_reward_point;
            $this->direct_referral_per = $request->direct_referral_per;
            $this->minimum_order = $request->minimum_order;
        } catch (Exception $e) {
            throw new Exception("Error processing request: " . $e->getMessage());
        }catch (Throwable $t) { // Catch any other types of errors
            throw new Exception("Unexpected error: " . $t->getMessage());
        }
    }

}