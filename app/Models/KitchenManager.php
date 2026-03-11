<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenManager extends Model
{
    use HasFactory;
    protected $table = 'sk_kitchen_manager';

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'remarks',
        'status'
    ];
}
