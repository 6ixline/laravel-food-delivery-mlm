<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $table = "sk_product_variants";

    protected $fillable = [
        'product_id',
        'title',
        'qty',
        'unit',
        'mrp',
        'price',
        'business_volume',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function ingredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }
}