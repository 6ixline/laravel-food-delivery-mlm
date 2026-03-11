<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSetting extends Model
{
    use HasFactory;
    protected $table = 'mlm_plans';
    
    protected $fillable = [
        'title',
        'tds',
        'activation_reward_point',
        'direct_referral_per',
        'minimum_order',
        'remarks',
        'status'
    ];
}
