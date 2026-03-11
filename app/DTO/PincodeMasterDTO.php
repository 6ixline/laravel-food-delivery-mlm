<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class PincodeMasterDTO
{

    public ?int $pinid;
    public ?String $pincode;
    public ?String $area;
    public ?String $city;
    public ?String $state;
    public ?String $country;
    public ?String $remarks;
    public ?String $status;
   

    public function __construct(Request $request){

        try {
            
            $this->pinid = $request->pinid;
            $this->pincode = $request->pincode;
            $this->area = $request->area;
            $this->city = $request->city;
            $this->state = $request->state;
            $this->country = $request->country;
            $this->remarks = $request->remarks;
            $this->status = $request->status;

        } catch (Exception $e) {

            throw new Exception("Error processing request: " . $e->getMessage());
        
        }catch (Throwable $t) { // Catch any other types of errors
        
            throw new Exception("Unexpected error: " . $t->getMessage());
        
        }

    }

}