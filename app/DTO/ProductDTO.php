<?php

namespace App\DTO;

use Exception;
use Illuminate\Http\Request;
use Throwable;
use App\DTO\ProductVariantDTO;
use App\DTO\ProductIngredientDTO;


class ProductDTO
{

    public ?int $productid;
    public ?String $name;
    public ?int $kitchen_id;
    public ?int $category_id;
    public ?String $pricing_mode;
    public ?float $mrp;
    public ?float $price;
    public ?float $business_volume;
    public ?string $imgName;
    public ?String $description;
    public ?String $ingredients;
    public ?String $isShowOnHome;
    public ?String $status;
    public ?array $productVariants;

    public function __construct(Request $request){
        try {
            $this->productid = $request->productid;
            $this->name = $request->name;
            $this->kitchen_id = $request->kitchen_id;
            $this->category_id = $request->category_id;
            $this->pricing_mode = $request->pricing_mode;
            $this->mrp = $request->pricing_mode == "qty" ? $request->product_mrp : 0;
            $this->price = $request->pricing_mode == "qty" ? $request->product_price : 0;
            $this->business_volume = $request->pricing_mode == "qty" ? $request->product_business_volume : 0;
            $this->imgName = '';
            $this->description = $request->description;
            $this->ingredients = $request->ingredients;
            $this->isShowOnHome = $request->isShowOnHome;
            $this->status = $request->status;
            $this->productIngredient = [];

           
            if($request->pricing_mode == "qty"){
                 $this->setProductIngredient($request);
            }
            // $this->productVariants = [];
            // if($request->pricing_mode == "variant"){
            //     $this->setProductVariants($request);
            // }

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

    // public function setProductVariants(Request $request): void {
    //     for($i = 0; $i < count($request->title); $i++)
    //     {
    //         $variant = [
    //             "title"=> $request->title[$i], 
    //             // "qty"=> $request->qty[$i], 
    //             "product_id"=> null,
    //             "variantid"=> isset($request->variantid[$i]) ? $request->variantid[$i] : null, 
    //             // "unit"=> $request->unit[$i], 
    //             "mrp"=> $request->mrp[$i], 
    //             "price"=> $request->price[$i],
    //             "business_volume"=> $request->business_volume[$i]
    //         ];
    //         array_push($this->productVariants, new ProductVariantDTO($variant));
    //     }
    // }

   

}