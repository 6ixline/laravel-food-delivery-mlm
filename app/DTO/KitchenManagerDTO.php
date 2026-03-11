<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class KitchenManagerDTO
{

    public ?int $managerid;
    public ?String $name;
    public ?String $mobile;
    public ?String $email;
    public ?String $remarks;
    public ?String $status;
   

    public function __construct(Request $request){

        try {
            
            $this->managerid = $request->managerid;
            $this->name = $request->name;
            $this->mobile = $request->mobile;
            $this->email = $request->email;
            $this->remarks = $request->remarks;
            $this->status = $request->status;

        } catch (Exception $e) {

            throw new Exception("Error processing request: " . $e->getMessage());
        
        }catch (Throwable $t) { // Catch any other types of errors
        
            throw new Exception("Unexpected error: " . $t->getMessage());
        
        }

    }

}