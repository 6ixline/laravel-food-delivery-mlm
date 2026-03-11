<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    use HasFactory;
    protected $table = 'sk_kitchen';

    protected $fillable = [
        'name',
        'address',
        'primary_pincode_id',
        'kitchen_manager_id',
        'remarks',
        'status'
    ];
    public function primaryPincode()
    {
        return $this->belongsTo(PincodeMaster::class, 'primary_pincode_id');
    }

    public function manager()
    {
        return $this->belongsTo(KitchenManager::class, 'kitchen_manager_id');
    }
}
