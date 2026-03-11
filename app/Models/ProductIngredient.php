<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\product;

class ProductIngredient extends Model
{
    use HasFactory;

    protected $table = "sk_product_ingredients";

    protected $fillable = [
         
        'product_id',
        'product_variant_id',
        'ingredients_id',
        'qty',
        'unit'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variants()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function ingredient_items()
    {
        return $this->belongsTo(Ingredient::class, 'ingredients_id');
    }
    
}
