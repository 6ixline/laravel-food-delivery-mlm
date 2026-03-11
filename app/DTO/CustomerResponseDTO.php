<?php

namespace App\DTO;

use App\Models\Member;

class CustomerResponseDTO
{
    public int $id;
    public string $name;
    public string $email;
    public string $mobile;
    public ?string $status;

    public function __construct(Member $member){
        $this->id = $member->id;
        $this->name = $member->name;
        $this->email = $member->email;
        $this->mobile = $member->mobile;
        $this->status = $member->status;
    }

    public function toArray() :array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "mobile"=> $this->mobile,
            "status"=> $this->status
        ];     
    }
}