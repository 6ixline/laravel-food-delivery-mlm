<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use App\DTO\ProductIngredientDTO;
use Throwable;

class ProductVariantDTO
{

    public ?int $variantid;
    public ?int $product_id;
    public ?String $title;
    public ?int $qty;
    public ?String $unit;
    public ?float $mrp;
    public ?float $price;
    public ?float $business_volume;
    public ?String $status;
    public ?array $productIngredient;

    public function __construct(Request $request){

        try {
            
            $this->variantid = $request->variantid;
            $this->productid = $request->productid;
            $this->title = $request->title;
            // $this->qty = $request['qty'];
            // $this->unit = $request['unit'];
            $this->mrp = $request->mrp;
            $this->price = $request->price;
            $this->business_volume = $request->business_volume;
            $this->status = $request->status;
            $this->productIngredient = [];

            $this->setProductIngredient($request);


        } catch (Exception $e) {

            throw new Exception("Error processing request: " . $e->getMessage());
        
        }catch (Throwable $t) { // Catch any other types of errors
        
            throw new Exception("Unexpected error: " . $t->getMessage());
        
        }

    }

     public function setProductIngredient(Request $request): void {
        for($i = 0; $i < count($request->items_name); $i++)
        {
            $variant = [
                "product_ingredient_id"=>  isset($request->product_ingredient_id[$i]) ? $request->product_ingredient_id[$i] : null,
                "items_name"=> $request->items_name[$i], 
                "variant_id"=> null,
                "product_id"=> null,
                "unit"=> $request->unit[$i], 
                "qty"=> $request->qty[$i], 
               
            ];
            array_push($this->productIngredient, new ProductIngredientDTO($variant));
        }
    }

}