<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerDashboardService{

    public function getDashBoardStats(String $pincode){

        try{
            // Subquery: Get min price per category for given pincode, considering pricing_mode
            $minPriceSub = DB::table('sk_products as p2')
            ->join('sk_kitchen as k2', 'p2.kitchen_id', '=', 'k2.id')
            ->join('sk_pincode_master as pin2', 'k2.primary_pincode_id', '=', 'pin2.id')
            ->leftJoin('sk_product_variants as v2', function($join) {
                $join->on('v2.product_id', '=', 'p2.id');
            })
            ->where('pin2.pincode', $pincode)
            ->select(
                'p2.category_id',
                DB::raw('MIN(
                    CASE 
                        WHEN p2.pricing_mode = "qty" THEN p2.price
                        ELSE v2.price
                    END
                ) as min_price')
            )
            ->groupBy('p2.category_id');

            // Main query: Fetch product/variant info based on min price per category
            $categoryWiseMinProducts = DB::table('sk_products as p')
            ->join('sk_category as c', 'p.category_id', '=', 'c.id')
            ->join('sk_kitchen as k', 'p.kitchen_id', '=', 'k.id')
            ->join('sk_pincode_master as pin', 'k.primary_pincode_id', '=', 'pin.id')
            ->leftJoin('sk_product_variants as v1', function($join) {
                $join->on('v1.product_id', '=', 'p.id');
            })
            ->joinSub($minPriceSub, 'mp', function ($join) {
                $join->on('p.category_id', '=', 'mp.category_id')
                    ->on(DB::raw('
                        CASE 
                            WHEN p.pricing_mode = "qty" THEN p.price
                            ELSE v1.price
                        END
                    '), '=', 'mp.min_price');
            })
            ->where('pin.pincode', $pincode)
            ->select(
                DB::raw('
                    CASE 
                        WHEN p.pricing_mode = "qty" THEN p.price
                        ELSE v1.price
                    END as min_price
                '),
                DB::raw('
                    CASE 
                        WHEN p.pricing_mode = "qty" THEN p.mrp
                        ELSE v1.mrp
                    END as min_mrp
                '),
                'c.title as category_name',
                'c.id as categoryid'
            )
            ->get();


            $query = Product::query()
                ->where("isShowOnHome", true)
                ->orderBy('created_at');

            // Filter by pincode (kitchen)
            if ($pincode) {
                $kitchenIds = DB::table('sk_kitchen')
                    ->join('sk_pincode_master', 'sk_kitchen.primary_pincode_id', '=', 'sk_pincode_master.id')
                    ->where('sk_pincode_master.pincode', $pincode)
                    ->pluck('sk_kitchen.id');

                $query->whereIn('kitchen_id', $kitchenIds);
            }

            // Eager load variants (for pricing_mode = 'variant')
            $query->with(['variants' => fn($q) => $q->orderBy('price')]);

            // Select essential product fields
            $homePageProduct = $query->get([
                'id', 'name', 'imgName', 'pricing_mode', 'price', 'mrp', 'ingredients'
            ])->append('image_url')->makeHidden('imgName');

            // Transform output with calculated fields
            $homePageProduct->transform(function ($product) {
                $cheapestVariant = $product->variants->first();

                return [
                    'productid'     => $product->id,
                    'name'          => $product->name,
                    'ingredients'   => $product->ingredients,
                    'image_url'     => $product->image_url,
                    'final_price'   => $product->pricing_mode === 'qty' 
                                        ? $product->price 
                                        : ($cheapestVariant->price ?? null),
                    'final_mrp'     => $product->pricing_mode === 'qty' 
                                        ? $product->mrp 
                                        : ($cheapestVariant->mrp ?? null),
                    'variants'      => $product->variants,
                ];
            });

            // dd($query->toSql());

            return ["catBasedPrice" => $categoryWiseMinProducts, 'homePageProduct'=> $homePageProduct];

        }catch(Throwable $th){
            return $th;
        }
        
    }

}