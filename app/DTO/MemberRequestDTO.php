<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class MemberRequestDTO
{

    public ?string $membership_id;
    public ?string $membership_id_value;
    public ?string $sponsor_id;
    public ?string $sponsor_name;
    public ?string $planid;
    public ?string $rewardid;
    public string $name;
    public ?string $father_name;
    public ?string $username;
    public ?string $relation_name;
    public ?string $date_of_birth;
    public ?string $gender;
    public string $email;
    public ?string $password;
    public ?string $password_text;
    public string $mobile;
    public ?string $mobile_alter;
    public ?string $address;
    public ?string $pincode;
    public ?string $nominee_name;
    public ?string $kycdoc;
    public ?string $panImage;
    public ?string $bankdoc;
    public ?string $nominee_relation;
    public ?string $nominee_age;
    public ?string $bank_name;
    public ?string $branch_name;
    public ?string $account_number;
    public ?string $ifsc_code;
    public ?string $account_name;
    public ?string $pan_card;
    public ?string $aadhar_card;
    public ?string $imgName;
    public ?string $remarks;
    public ?string $status;
   

    public function __construct(Request $request){
        try {
            $this->membership_id = $request->membership_id;
            $this->membership_id_value = $request->membership_id_value;
            $this->sponsor_id = $request->sponsor_id;
            $this->sponsor_name = $request->sponsor_name;
            $this->planid = $request->planid;
            $this->rewardid = $request->rewardid;
            $this->name = $request->name;
            $this->father_name = $request->father_name;
            $this->username = $request->username;
            $this->relation_name = $request->relation_name;
            $this->date_of_birth = date("Y-m-d", strtotime($request->date_of_birth));
            $this->gender = $request->gender;
            $this->email = $request->email;
            $this->password = $request->password;
            $this->mobile = $request->mobile;
            $this->mobile_alter = $request->mobile_alter;
            $this->address = $request->address;
            $this->pincode = $request->pincode;
            $this->nominee_name = $request->nominee_name;
            $this->kycdoc = '';
            $this->bankdoc = '';
            $this->panImage = '';
            $this->nominee_relation = $request->nominee_relation;
            $this->nominee_age = $request->nominee_age;
            $this->bank_name = $request->bank_name;
            $this->branch_name = $request->branch_name;
            $this->account_number = $request->account_number;
            $this->ifsc_code = $request->ifsc_code;
            $this->account_name = $request->account_name;
            $this->pan_card = $request->pan_card;
            $this->aadhar_card = $request->aadhar_card;
            $this->imgName = '';
            $this->remarks = $request->remarks;
            $this->status = $request->status;
        } catch (Exception $e) {
            throw new Exception("Error processing request: " . $e->getMessage());
        }catch (Throwable $t) { // Catch any other types of errors
            throw new Exception("Unexpected error: " . $t->getMessage());
        }
    }

}