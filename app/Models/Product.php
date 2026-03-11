<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'sk_products';

    protected $fillable = [
        'name',
        'category_id',
        'kitchen_id',
        'pricing_mode',
        'mrp',
        'price',
        'business_volume',
        'ingredients',
        'description',
        'isShowOnHome',
        'imgName',
        'status'
    ];

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class, 'kitchen_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->select(['id', 'product_id', 'title', 'price', 'mrp']);
    }

    public function getImageUrlAttribute()
    {
        return url("uploads/" . $this->imgName);
    }

    public function cheapestVariant()
    {
        return $this->hasOne(ProductVariant::class)
            ->orderBy('price')
            ->select(['id', 'product_id', 'title', 'price', 'mrp']);
    }

    public function scopeSearchTerm($query, string $term)
    {
        $term = trim($term);
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('description', 'LIKE', "%{$term}%")
              ->orWhere('ingredients', 'LIKE', "%{$term}%");
        });
    }
}
