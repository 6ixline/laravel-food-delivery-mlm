<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'sk_category';
    
    protected $fillable = [
        'title',
        'remarks',
        'kitchen_id',
        'imgName',
        'status'
    ];

    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class, 'kitchen_id');
    }

}
