<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kitchen;
use App\Models\Ingredient;
class KitchenStock extends Model
{
    use HasFactory;

    protected $table = 'sk_kitchen_stocks';

    protected $fillable = [
        'ingredients_id',
        'qty',
        'kitchen_id',
        'status'
    ];

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class, 'kitchen_id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredients_id');
    }
}
