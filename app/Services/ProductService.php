<?php

namespace App\Services;

use App\DTO\ProductDTO;
use App\Models\Kitchen;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductIngredient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;


class ProductService{
    // protected ProductVariantService $productVariantService;

    // public function __construct(ProductVariantService $productVariantService)
    // {
    //     $this->productVariantService = $productVariantService;
    // }

    private ProductIngredientService $productIngredientService;

    public function __construct(ProductIngredientService $productIngredientService)
    {
        $this->productIngredientService = $productIngredientService;
    }

    public function createProduct(Request $request, ProductDTO $requestDTO){
        try {
            if ($request->hasFile('imgName')) {
                $file = $request->file('imgName');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $requestDTO->imgName = $filename;
            }

            $product = Product::create([
                'name' => $requestDTO->name,
                'kitchen_id' => $requestDTO->kitchen_id,
                'category_id' => $requestDTO->category_id,
                'ingredients' => $requestDTO->ingredients,
                'pricing_mode' => $requestDTO->pricing_mode,
                'mrp' => $requestDTO->mrp,
                'price' => $requestDTO->price,
                'business_volume' => $requestDTO->business_volume,
                'description'=> $requestDTO->description,
                'isShowOnHome'=> $requestDTO->isShowOnHome == "on" ? 1 : 0,
                'imgName' => $requestDTO->imgName,
                'status'=> $requestDTO->status ? $requestDTO->status : "active"
            ]);

          
           

            if($requestDTO->pricing_mode == "qty"){
                foreach ($requestDTO->productIngredient as $ingredientDTO) {
                    $ingredientDTO->product_id = $product->id;

                    $this->productIngredientService->createProductIngredient($request, $ingredientDTO);
                }
            }

            // if($requestDTO->pricing_mode == "variant"){
            //     foreach ($requestDTO->productVariants as $variantDTO) {
            //         $variantDTO->product_id = $product->id;
            //         $this->productVariantService->createProductVariant($request, $variantDTO);
            //     }
            // }

            return $product;

        } catch (Exception $e) {
            throw $e;
        }

    }

    public function updateProduct(Request $request, ProductDTO $requestDTO){
        try {
            if ($request->hasFile('imgName')) {
                $file = $request->file('imgName');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);
                $requestDTO->imgName = $filename;
            }else{
                $requestDTO->imgName = $request->old_imgName;
            }

            $product = Product::where('id', $requestDTO->productid)->firstOrFail();
            $updateData = [
                'name' => $requestDTO->name,
                'kitchen_id' => $requestDTO->kitchen_id,
                'category_id' => $requestDTO->category_id,
                'kitchen_id' => $requestDTO->kitchen_id,
                'description' => $requestDTO->description,
                'ingredients' => $requestDTO->ingredients,
                'pricing_mode' => $requestDTO->pricing_mode,
                'mrp' => $requestDTO->mrp,
                'price' => $requestDTO->price,
                'business_volume' => $requestDTO->business_volume,
                'isShowOnHome'=> $requestDTO->isShowOnHome == "on" ? 1 : 0, 
                'imgName' => $requestDTO->imgName,
                'status' => $requestDTO->status ?? $product->status
            ];

            $product->update($updateData);

            // Handling the product variant update and delete here



            $existingIngredientIds = ProductIngredient::where('product_id', $product->id)->pluck('id')->toArray();          
            $requestIngredientIds = array_column($requestDTO->productIngredient, 'product_ingredient_id');
            $ingredientIdsToRemove = array_diff($existingIngredientIds, $requestIngredientIds);

            foreach ($ingredientIdsToRemove as $ingredientId) {
                $this->productIngredientService->deleteProductIngredient($ingredientId);
            }
            
            foreach ($requestDTO->productIngredient as $ingredientDTO) {
                
                $ingredientDTO->product_id = $product->id;

                if (isset($ingredientDTO->product_ingredient_id)) {
                    $this->productIngredientService->updateProductIngredient($request, $ingredientDTO);
                } else {
                    $this->productIngredientService->createProductIngredient($request, $ingredientDTO);
                }
            }



            // $existingVariantIds = ProductVariant::where('product_id', $product->id)->pluck('id')->toArray();
            // $requestVariantIds = array_column($requestDTO->productVariants, 'variantid');
            // $variantIdsToRemove = array_diff($existingVariantIds, $requestVariantIds);

            // foreach ($variantIdsToRemove as $variantId) {
            //     $this->productVariantService->deleteProductVariant($variantId);
            // }
            // foreach ($requestDTO->productVariants as $variantDTO) {
            //     $variantDTO->product_id = $product->id;
            //     if (isset($variantDTO->variantid)) {
            //         $this->productVariantService->updateProductVariant($request, $variantDTO);
            //     } else {
            //         $this->productVariantService->createProductVariant($request, $variantDTO);
            //     }
            // }




            return $product->fresh();
            
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function bulkDeleteProductByIds($productIds = [])
    {
        try {
            if (is_array($productIds) && count($productIds) > 0) {
                Product::whereIn('id', $productIds)->delete();
            } else {
                throw new Exception('No Record selected for deletion.');
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function deleteProduct($id){
        try {
            $product = Product::find($id);
            if (!$product) {
                throw new Exception('Record not found.');
            }
            $product->delete();
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function getProduct(
        string $q = '', 
        int $limit = 20, 
        string $include = '', 
        ?string $catid = null,
        ?int $offset = 0,
        ?string $pincode = ""
    ) {
        try {
            $query = Product::query();
    
            // Apply search scope
            if (!empty($q)) {
                $query->searchTerm($q);
            }
    
            // Define allowed fields and virtual (accessor) fields
            $selectedFields = ['id', 'name', 'description', 'pricing_mode', 'ingredients', 'imgName', 'price', 'image_url'];
            $virtualFields = ['image_url'];
    
            // Ensure 'id' is always selected
            if (!in_array('id', $selectedFields)) {
                $selectedFields[] = 'id';
            }
    
            // Get actual DB columns (exclude accessors)
            $dbFields = array_diff($selectedFields, $virtualFields);
    
            // Build the select with conditional pricing
            $query->addSelect([
                ...array_diff($dbFields, ['price', 'ingredients']),
                DB::raw("
                    CASE 
                        WHEN pricing_mode = 'qty' THEN sk_products.price
                        ELSE (
                            SELECT MIN(price) 
                            FROM sk_product_variants 
                            WHERE sk_product_variants.product_id = sk_products.id
                        )
                    END as price
                "),
                DB::raw("(
                    SELECT GROUP_CONCAT(DISTINCT si.title ORDER BY si.title SEPARATOR ', ')
                    FROM sk_product_ingredients spi
                    JOIN sk_ingredients si ON si.id = spi.ingredients_id
                    WHERE spi.product_id = sk_products.id
                ) as ingredients")
            ]);
    
            // Include related models if requested and valid for pricing_mode
            if ($include === 'variants') {
                $query->with(['variants' => function ($q) {
                    $q->orderBy('price');
                }]);
            } elseif ($include === 'cheapest_variant') {
                $query->with(['cheapestVariant' => function ($q) {
                    $q->orderBy('price')->limit(1);
                }]);
            }
    
            // Filter by category
            if ($catid) {
                $query->where('category_id', $catid);
            }
    
            // Filter by kitchen via pincode
            if ($pincode) {
                $kitchenIds = DB::table('sk_kitchen')
                    ->join('sk_pincode_master', 'sk_kitchen.primary_pincode_id', '=', 'sk_pincode_master.id')
                    ->where('sk_pincode_master.pincode', $pincode)
                    ->pluck('sk_kitchen.id');
    
                $query->whereIn('kitchen_id', $kitchenIds);
            }
    
            // Only exclude products without variants if pricing_mode is 'variant'
            $query->where(function ($q) {
                $q->where('pricing_mode', 'qty')
                  ->orWhereExists(function ($q2) {
                      $q2->select(DB::raw(1))
                         ->from('sk_product_variants')
                         ->whereColumn('sk_product_variants.product_id', 'sk_products.id');
                  });
            });
    
            // Fetch results with pagination
            $products = $query
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->makeHidden('imgName');
    
            // Append virtual fields
            foreach ($virtualFields as $field) {
                if (in_array($field, $selectedFields)) {
                    $products->each->append($field);
                }
            }
    
            return $products->toArray();
        } catch (Throwable $th) {
            return $th;
        }
    }
    
    
}