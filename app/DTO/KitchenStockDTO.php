<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class KitchenStockDTO
{

    public ?int $id;
    public ?String $ingredients_id;
    public ?int $qty;
    public ?int $kitchen_id;
    public ?String $status;
   

    public function __construct(Request $request){

        try {
            
            $this->id = $request->id;
            $this->ingredients_id = $request->ingredients_id;
            $this->qty = $request->qty;
            $this->kitchen_id = $request->kitchen_id;
            $this->status = $request->status;

        } catch (Exception $e) {

            throw new Exception("Error processing request: " . $e->getMessage());
        
        }catch (Throwable $t) { // Catch any other types of errors
        
            throw new Exception("Unexpected error: " . $t->getMessage());
        
        }

    }

}