<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceBonus extends Model
{
    use HasFactory;

    protected $table = "mlm_performance_bonus";

    protected $fillable = [
        "title",
        "bv_range_start",
        "bv_range_end",
        "incentive",
        "monthly_self_bv",
        'remarks',
        'status'
    ];

}
