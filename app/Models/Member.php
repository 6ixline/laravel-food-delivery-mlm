<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'sk_registrations';
    
    protected $fillable = [
        'membership_id',
        'membership_id_value',
        'sponsor_id',
        'sponsor_name',
        'planid',
        'rewardid',
        'name',
        'father_name',
        'username',
        'relation_name',
        'date_of_birth',
        'gender',
        'email',
        'password',
        'password_text',
        'mobile',
        'mobile_alter',
        'address',
        'pincode',
        'nominee_name',
        'kycdoc',
        'panImage',
        'bankdoc',
        'nominee_relation',
        'nominee_age',
        'bank_name',
        'branch_name',
        'account_number',
        'ifsc_code',
        'account_name',
        'pan_card',
        'aadhar_card',
        'imgName',
        'remarks',
        'isVerified',
        'status'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getImageUrlAttribute()
    {
        return url("uploads/" . $this->imgName);
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
