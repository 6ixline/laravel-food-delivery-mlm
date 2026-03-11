<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class KitchenDTO
{

    public ?int $kitchenid;
    public ?String $name;
    public ?String $address;
    public ?int $primary_pincode_id;
    public ?int $kitchen_manager_id;
    public ?String $remarks;
    public ?String $status;
   

    public function __construct(Request $request){

        try {
            
            $this->kitchenid = $request->kitchenid;
            $this->name = $request->name;
            $this->address = $request->address;
            $this->primary_pincode_id = $request->primary_pincode_id;
            $this->kitchen_manager_id = $request->kitchen_manager_id;
            $this->remarks = $request->remarks;
            $this->status = $request->status;

        } catch (Exception $e) {

            throw new Exception("Error processing request: " . $e->getMessage());
        
        }catch (Throwable $t) { // Catch any other types of errors
        
            throw new Exception("Unexpected error: " . $t->getMessage());
        
        }

    }

}