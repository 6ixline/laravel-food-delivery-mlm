<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Kitchen;
use App\Models\KitchenManager;
use App\Models\Member;
use App\Models\PerformanceBonus;
use App\Models\PincodeMaster;
use App\Models\PlanSetting;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductIngredient;
use App\Models\Ingredient;

use App\Models\KitchenStock;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $totalMembers = Member::count();
        $totalKitchenManager = KitchenManager::count();
        $totalKitchen = Kitchen::count();
        $totalPincode = PincodeMaster::count();
        return view("admin.home", ['totalMembers' => $totalMembers, 'totalKitchenManager'=> $totalKitchenManager, 'totalKitchen'=> $totalKitchen, 'totalPincode'=> $totalPincode]);
    }
    public function members(Request $request){

        $view = $request->view;
        $mode = $request->mode;
        $regid = $request->regid;
        switch ($view) {
            case 'list':
                $members = Member::orderBy('created_at', 'desc')->get();
                return view("admin.members.register-list", ['registerRows' => $members]);
            case 'form':
                if($mode == "edit"){
                $member = Member::where('id', $regid)->first();
                if (!$member) {
                    return redirect()->route("admin.members", ['view' => 'list'])->with('error', 'Something went wrong.');
                }
                return view("admin.members.register-form", ['mode' => $mode, "registerRow"=> $member]);
                }
                return view("admin.members.register-form", ['mode' => $mode, "registerRow"=> []]);
            default:
                $members = Member::orderBy('created_at', 'desc')->get();
                return view("admin.members.register-list", ['registerRows' => $members]);
        }
    }
    public function plan(Request $request){

        $view = $request->view;
        $mode = $request->mode;
        $planid = $request->planid;
        switch ($view) {
            case 'form':
                if($mode == "edit"){
                    $plan = PlanSetting::where('id', $planid)->first();
                    if (!$plan) {
                        $totalMembers = Member::count();
                        return view("admin.home", ['totalMembers' => $totalMembers]);
                    }
                    return view("admin.plan.plan-form", ['mode' => $mode, "planRow"=> $plan]);
                }
                return view("admin.plan.plan-form", ['mode' => $mode, "registerRow"=> []]);
            default:
                return view("admin.plan.plan-form", ['mode' => $mode, "registerRow"=> []]);
        }
    }

    public function performanceBonus(Request $request){

        $view = $request->view;
        $mode = $request->mode;
        $pid = $request->pid;
        switch ($view) {
            case 'list':
                $performanceBonusRows = PerformanceBonus::orderBy('id', 'desc')->get();
                return view("admin.performanceBonus.performance-bonus-list", ['performanceBonusRows' => $performanceBonusRows]);
            case 'form':
                if($mode == "edit"){
                $performanceBonusRow = PerformanceBonus::find($pid);
                if (!$performanceBonusRow) {
                    return redirect()->route("admin.performanceBonus", ['view' => 'list'])->with('error', 'Something went wrong.');
                }
                return view("admin.performanceBonus.performance-bonus-form", ['mode' => $mode, "performanceBonusRow"=> $performanceBonusRow]);
                }
                return view("admin.performanceBonus.performance-bonus-form", ['mode' => $mode, "performanceBonusRow"=> []]);
            default:
                $performanceBonusRows = PerformanceBonus::orderBy('id', 'desc')->get();
                return view("admin.performanceBonus.performance-bonus-list", ['performanceBonusRows' => $performanceBonusRows]);
        }
    }

    public function pincodeMaster(Request $request){

        $view = $request->view;
        $mode = $request->mode;
        $pinid = $request->pinid;
        switch ($view) {
            case 'list':
                $pincodeMasterRows = PincodeMaster::orderBy('id', 'desc')->get();
                return view("admin.pincodeMaster.pincode-master-list", ['pincodeMasterRows' => $pincodeMasterRows]);
            case 'form':
                if($mode == "edit"){
                $pincodeMasterRow = PincodeMaster::find($pinid);
                if (!$pincodeMasterRow) {
                    return redirect()->route("admin.pincodeMaster", ['view' => 'list'])->with('error', 'Something went wrong.');
                }
                return view("admin.pincodeMaster.pincode-master-form", ['mode' => $mode, "pincodeMasterRow"=> $pincodeMasterRow]);
                }
                return view("admin.pincodeMaster.pincode-master-form", ['mode' => $mode, "pincodeMasterRow"=> []]);
            default:
                $pincodeMasterRows = PincodeMaster::orderBy('id', 'desc')->get();
                return view("admin.pincodeMaster.pincode-master-list", ['pincodeMasterRows' => $pincodeMasterRows]);
        }
    }

    public function kitchenManager(Request $request){

        $view = $request->view;
        $mode = $request->mode;
        $managerid = $request->managerid;
        switch ($view) {
            case 'list':
                $kitchenManagerRows = KitchenManager::orderBy('id', 'desc')->get();
                return view("admin.kitchenManager.kitchen-manager-list", ['kitchenManagerRows' => $kitchenManagerRows]);
            case 'form':
                if($mode == "edit"){
                    $kitchenManagerRow = KitchenManager::find($managerid);
                    if (!$kitchenManagerRow) {
                        return redirect()->route("admin.kitchenManager", ['view' => 'list'])->with('error', 'Something went wrong.');
                    }
                    return view("admin.kitchenManager.kitchen-manager-form", ['mode' => $mode, "kitchenManagerRow"=> $kitchenManagerRow]);
                }
                return view("admin.kitchenManager.kitchen-manager-form", ['mode' => $mode, "kitchenManagerRow"=> []]);
            default:
                $kitchenManagerRows = KitchenManager::orderBy('id', 'desc')->get();
                return view("admin.kitchenManager.kitchen-manager-list", ['kitchenManagerRows' => $kitchenManagerRows]);
        }
    }

    public function kitchen(Request $request){

        $view = $request->view;
        $mode = $request->mode;
        $kitchenid = $request->kitchenid;
        switch ($view) {
            case 'list':
                $kitchenRows = Kitchen::with(['primaryPincode' => function($query) {
                    $query->select('id', 'pincode');
                }, 'manager' => function($query) {
                    $query->select('id', 'name');
                }])->orderBy('id', 'desc')->get();
                return view("admin.kitchen.kitchen-list", ['kitchenRows' => $kitchenRows]);
            case 'form':
                $allPincodes = PincodeMaster::orderBy('pincode', 'asc')->pluck('pincode', 'id');
                $allManagers = KitchenManager::orderBy('name', 'asc')->pluck('name', 'id');
                if($mode == "edit"){
                    $kitchenRow = Kitchen::find($kitchenid);
                    if (!$kitchenRow) {
                        return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Something went wrong.');
                    }
                    return view("admin.kitchen.kitchen-form", ['mode' => $mode, "kitchenRow"=> $kitchenRow, 'allPincodes'=> $allPincodes, 'allManagers'=> $allManagers]);
                }
                return view("admin.kitchen.kitchen-form", ['mode' => $mode, "kitchenRow"=> [], 'allPincodes'=> $allPincodes, 'allManagers'=> $allManagers]);
            default:
                $kitchenRows = Kitchen::orderBy('id', 'desc')->get();
                return view("admin.kitchen.kitchen-list", ['kitchenRows' => $kitchenRows]);
        }
    }

    public function category(Request $request){

        $view = $request->view;
        $mode = $request->mode;
        $categoryid = $request->categoryid;

        // Kitchen Details
        $kitchen_id = $request->kitchen_id;
        if (empty($kitchen_id)) {
            return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Error! Please Try again.');
        }
        $kitchen = Kitchen::find($kitchen_id)->select(['name', 'id'])->first();
        if (!$kitchen) {
            return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Kitchen not found.');
        }

        switch ($view) {
            case 'list':
                $categoryRows = Category::where('kitchen_id', $kitchen_id)->orderBy('id', 'desc')->get();
                return view("admin.category.category-list", ['categoryRows' => $categoryRows, 'kitchen'=> $kitchen]);
            case 'form':
                if($mode == "edit"){
                    $categoryRow = Category::find($categoryid);
                    if (!$categoryRow) {
                        return redirect()->route("admin.category", ['view' => 'list', 'kitchen_id'=> $kitchen_id])->with('error', 'Something went wrong.');
                    }
                    return view("admin.category.category-form", ['mode' => $mode, "categoryRow"=> $categoryRow, 'kitchen_id'=> $kitchen_id]);
                }
                return view("admin.category.category-form", ['mode' => $mode, "categoryRow"=> [], 'kitchen_id'=> $kitchen_id]);
            default:
                $categoryRows = Category::where('kitchen_id', $kitchen_id)->orderBy('id', 'desc')->get();
                return view("admin.category.category-list", ['categoryRows' => $categoryRows, 'kitchen'=> $kitchen]);
        }

    }

    public function product(Request $request){

        $view = $request->view;
        $mode = $request->mode;
        $productid = $request->productid;

        // Kitchen Details
        $kitchen_id = $request->kitchen_id;
        if (empty($kitchen_id)) {
            return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Error! Please Try again.');
        }

        $kitchen = Kitchen::select(['id', 'name'])->find($kitchen_id);

        if (!$kitchen) {
            return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Kitchen not found.');
        }

        switch ($view) {
            case 'list':
                $productRows = Product::where("kitchen_id", $kitchen_id)->with(['category' => function($query) {
                    $query->select('id', 'title');
                }])->orderBy('id', 'desc')->get();
                return view("admin.product.product-list", ['productRows' => $productRows, 'kitchen'=> $kitchen]);
            case 'form':

                $ingredients = Ingredient::orderBy('id', 'desc')->get();



                $allCategory = Category::where('kitchen_id', $kitchen_id)->orderBy('title', 'asc')->pluck('title', 'id');
                $productRow = [];
                // $productVariants = [];
                $productIngredientRows = [];
                if($mode == "edit"){
                    $productRow = Product::find($productid);
                   $productIngredientRows = ProductIngredient::where('product_id', $productRow->id)->whereNull('product_variant_id')->get();
                    // $productVariants = ProductVariant::where('product_id', $productRow->id)->get();

                    if (!$productRow) {
                        return redirect()->route("admin.product", ['view' => 'list', 'kitchen_id'=> $kitchen_id])->with('error', 'Something went wrong.');
                    }
                }
                return view("admin.product.product-form", ['mode' => $mode, "productRow"=> $productRow, 'kitchen_id'=> $kitchen_id,  'allCategory'=> $allCategory, 'productIngredientRows'=> $productIngredientRows, 'ingredients' => $ingredients ]);
            default:
                $productRows = Product::where('kitchen_id', $kitchen_id)->orderBy('id', 'desc')->get();
                return view("admin.product.product-list", ['productRows' => $productRows, 'kitchen'=> $kitchen]);
        }

    }

    public function productVariant(Request $request){

        $view = $request->view;
        $mode = $request->mode;
        $productid = $request->productid;
        // Kitchen Details
        $kitchen_id = $request->kitchen_id;


        if (empty($kitchen_id)) {
            return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Error! Please Try again.');
        }
     
        $kitchen = Kitchen::select(['id', 'name'])->find($kitchen_id);

        if (!$kitchen) {
            return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Kitchen not found.');
        }


        if (empty($productid)) {
           
            return redirect()->route("admin.product", ['view' => 'list', 'kitchen_id'=> $kitchen_id])->with('error', 'Something went wrong.');
        }

       $productRow = Product::where('kitchen_id', $kitchen_id)->where('id', $productid)->select(['id'])->first();
        if (!$productRow) {
            return redirect()->route("admin.product", ['view' => 'list', 'kitchen_id'=> $kitchen_id])->with('error', 'Kitchen not found.');
       
        }



        $productRow = [];
        $productVariants = [];

    
        switch ($view) {
            case 'list':
            
                
                $productVariants = ProductVariant::where('product_id', $productid)->orderBy('id', 'desc')->get();
                return view("admin.productVariant.product-variant-list", ['productVariants' => $productVariants , 'productid'=>$productid,  'kitchen_id' => $kitchen_id ]);


            case 'form':

                $ingredients = Ingredient::orderBy('id', 'desc')->get();

                $productVariantsRow = [];
                $productIngredientRows = [];

                if($mode == "edit"){

                    $productVariantsId = $request->id;

                    if (empty($productid) || !$productVariantsId ) {
                        return redirect()->route("admin.productVariant", ['view' => 'list', 'kitchen_id'=> $kitchen_id,'productid'=>$productid])->with('error', 'Something went wrong.');
                    }
                    

                    $productVariantsRow = ProductVariant::find( $productVariantsId );
                    $productIngredientRows= ProductIngredient::where('product_variant_id', $productVariantsRow->id)->get();

                    if (!$productVariantsRow) {
                        return redirect()->route("admin.productVariant", ['view' => 'list', 'kitchen_id'=> $kitchen_id,'productid'=>$productid])->with('error', 'Something went wrong.');
                    }
                }

                return view("admin.productVariant.product-variant-form", ['mode' => $mode, "productVariantsRow"=> $productVariantsRow,  "productIngredientRows"=> $productIngredientRows, 'kitchen_id'=> $kitchen_id, 'ingredients'=> $ingredients]);
          
            default:

                $productVariants = ProductVariant::where('product_id', $productRow->id)->orderBy('id', 'desc')->get();
                return view("admin.productVariant.product-variant-list", ['productVariants' => $productVariants]);

        }

    }

    public function kitchenStock(Request $request){

        $view = $request->view;
        $mode = $request->mode;
      

        $kitchenid = $request->kitchen_id;


     
        if (empty($kitchenid)) {
            return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Error! Please Try again.');
        }
        $kitchen = Kitchen::find($kitchenid);

       
        if (!$kitchen) {
            return redirect()->route("admin.kitchen", ['view' => 'list'])->with('error', 'Kitchen not found.');
        }


        switch ($view) {
            case 'list':

                $KitchenStockRows = KitchenStock::with('ingredient:id,title,unit')->where('kitchen_id', $kitchenid)->orderBy('id', 'desc')->get();

                return view("admin.kitchenStock.kitchen-stock-list", ['kitchenStockRows' => $KitchenStockRows , 'kitchen' => $kitchen]);
                
            case 'form':
                
               

                $IngredientRows = Ingredient::orderBy('id', 'desc')->get();
 
                if($mode == "edit"){
                    $kitchenStockId = $request->id;
                   
                    $KitchenStockRow = KitchenStock::with('ingredient:id,title,unit')->find($kitchenStockId);

                  

                    if (!$KitchenStockRow) {
                        return redirect()->route("admin.kitchenStock", ['view' => 'list' ])->with('error', 'Something went wrong.');
                    }
                    return view("admin.kitchenStock.kitchen-stock-form", ['mode' => $mode, "KitchenStockRow"=> $KitchenStockRow, 'IngredientRows' =>$IngredientRows  ]);
                }
                return view("admin.kitchenStock.kitchen-stock-form", ['mode' => $mode, "KitchenStockRow"=> [] , 'IngredientRows' =>$IngredientRows]);

            default:
            
                $kitchenStockRows = KitchenStock::with('ingredient:id,title,unit')->orderBy('id', 'desc')->get();
                return view("admin.kitchenStock.kitchen-stock-list", ['kitchenStockRows' => $kitchenStockRows , 'kitchen' => $kitchen]);
        }
    }


    public function ingredient(Request $request){

        $view = $request->view;
        $mode = $request->mode;
      

        switch ($view) {
            case 'list':

                $IngredientRows = Ingredient::orderBy('id', 'desc')->get();
                return view("admin.ingredient.ingredient-list", ['ingredientRows' =>  $IngredientRows]);
                
            case 'form':
                
                if($mode == "edit"){
                    $ingredientId = $request->id;
                   
                    $IngredientRow = Ingredient::find($ingredientId );

                    if (!$IngredientRow) {
                        return redirect()->route("admin.ingredient", ['view' => 'list' ])->with('error', 'Something went wrong.');
                    }
                    return view("admin.ingredient.ingredient-form", ['mode' => $mode, "ingredientRow"=> $IngredientRow ]);
                }
                return view("admin.ingredient.ingredient-form", ['mode' => $mode, "ingredientRow"=> []]);

            default:
            
                $IngredientRows = KitchenStock::orderBy('id', 'desc')->get();
                return view("admin.ingredient.ingredient-list", ['ingredientRows' => $IngredientRows]);
        }
    }



    
}