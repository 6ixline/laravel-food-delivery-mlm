<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;

class ProductIngredientDTO
{
    public ?int $product_ingredient_id;
    public ?int $product_id;
    public ?int $variant_id;
    public ?int $items_name;
    public ?String $unit;
    public ?int $qty;
 
   

    public function __construct(array $request){

        try {
            $this->product_ingredient_id = $request['product_ingredient_id'];
            $this->product_id = $request['product_id'];
            $this->variant_id = $request['variant_id'];
            $this->items_name = $request['items_name'];
            $this->unit = $request['unit'];
            $this->qty = $request['qty'];

        } catch (Exception $e) {

            throw new Exception("Error processing request: " . $e->getMessage());
        
        }catch (Throwable $t) { // Catch any other types of errors
        
            throw new Exception("Unexpected error: " . $t->getMessage());
        
        }

    }

}