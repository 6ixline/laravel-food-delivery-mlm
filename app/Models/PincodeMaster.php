<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PincodeMaster extends Model
{
    use HasFactory;
    protected $table = 'sk_pincode_master';

    protected $fillable = [
        'pincode',
        'area',
        'city',
        'state',
        'country',
        'remarks',
        'status'
    ];

    public function scopeSearchTerm($query, string $term)
    {
        $term = trim($term);
        return $query->where(function ($q) use ($term) {
            $q->where('pincode', 'LIKE', "%{$term}%");
        });
    }
}
