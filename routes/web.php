<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\KitchenController;
use App\Http\Controllers\admin\KitchenManagerController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\MemberController;
use App\Http\Controllers\admin\PerformanceBonusController;
use App\Http\Controllers\admin\PincodeMasterController;
use App\Http\Controllers\admin\PlanController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\KitchenStockController;
use App\Http\Controllers\admin\IngredientController;
use App\Http\Controllers\admin\ProductVariantController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/privacy-policy', function () {
    return view('privacy-page');
});

Route::get('/terms-and-conditions', function () {
    return view('terms-and-conditions');
});

Route::prefix('admin')->group(function () {

    Route::group(["middleware" => "admin.guest"], function(){
        Route::get('/', [LoginController::class, "index"])->name("admin.login");
        Route::post('/logincheck', [LoginController::class, "authenticate"])->name("admin.authenticate");
    });

    Route::group(["middleware" => "admin.auth"], function(){
        Route::get("/home", [DashboardController::class, "index"])->name("admin.dashboard");
        Route::get("/logout", [LoginController::class, "logout"])->name("admin.logout");
        
        // Members
        Route::get("/members/{view}", [DashboardController::class, "members"])->name("admin.members");
        Route::get('/member/genealogy', [MemberController::class, 'memberGenealogy'])->name('members.genealogy');
        Route::post('/members/store', [MemberController::class, 'store'])->name('members.store');
        Route::post('/members/update', [MemberController::class, 'updateMember'])->name('members.update');
        Route::post('/member/delete', [MemberController::class, 'deleteMember'])->name('members.delete');
        Route::post('/members/actions', [MemberController::class, 'memberActions'])->name('members.actions');
        Route::post('/fetch-member', [MemberController::class, 'fetchMember'])->name('fetch.member');

        // Plan Routes
        Route::get("/plan/{view}", [DashboardController::class, "plan"])->name("admin.plan");
        Route::post('/plan/update', [PlanController::class, 'updatePlan'])->name('plan.update');

        
        // Performance Bonuse
        Route::get("/performanceBonus/{view}", [DashboardController::class, "performanceBonus"])->name("admin.performanceBonus");
        Route::post('/performanceBonus/store', [PerformanceBonusController::class, 'store'])->name('performanceBonus.store');
        Route::post('/performanceBonus/update', [PerformanceBonusController::class, 'updatePerformanceBonus'])->name('performanceBonus.update');
        Route::post('/performanceBonus/actions', [PerformanceBonusController::class, 'performanceBonusActions'])->name('performanceBonus.actions');
        
        // Pincode Master
        Route::get("/pincodeMaster/{view}", [DashboardController::class, "pincodeMaster"])->name("admin.pincodeMaster");
        Route::post('/pincodeMaster/store', [PincodeMasterController::class, 'store'])->name('pincodeMaster.store');
        Route::post('/pincodeMaster/update', [PincodeMasterController::class, 'updatePincodeMaster'])->name('pincodeMaster.update');
        Route::post('/pincodeMaster/actions', [PincodeMasterController::class, 'pincodeMasterActions'])->name('pincodeMaster.actions');

        // Kitchen Manager
        Route::get("/kitchenManager/{view}", [DashboardController::class, "kitchenManager"])->name("admin.kitchenManager");
        Route::post('/kitchenManager/store', [KitchenManagerController::class, 'store'])->name('kitchenManager.store');
        Route::post('/kitchenManager/update', [KitchenManagerController::class, 'updateKitchenManager'])->name('kitchenManager.update');
        Route::post('/kitchenManager/actions', [KitchenManagerController::class, 'kitchenManagerActions'])->name('kitchenManager.actions');

        // Kitchen 
        Route::get("/kitchen/{view}", [DashboardController::class, "kitchen"])->name("admin.kitchen");
        Route::post('/kitchen/store', [KitchenController::class, 'store'])->name('kitchen.store');
        Route::post('/kitchen/update', [KitchenController::class, 'updatekitchen'])->name('kitchen.update');
        Route::post('/kitchen/actions', [KitchenController::class, 'kitchenActions'])->name('kitchen.actions');

        // Category - (Kitchen Product)
        Route::get("/category/{view}", [DashboardController::class, "category"])->name("admin.category");
        Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::post('/category/update', [CategoryController::class, 'updateCategory'])->name('category.update');
        Route::post('/category/actions', [CategoryController::class, 'categoryActions'])->name('category.actions');

        // Product - (Kitchen)
        Route::get("/product/{view}", [DashboardController::class, "product"])->name("admin.product");
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::post('/product/update', [ProductController::class, 'updateProduct'])->name('product.update');
        Route::post('/product/actions', [ProductController::class, 'productActions'])->name('product.actions');


         // Product Variant - (Kitchen)
        Route::get("/productVariant/{view}", [DashboardController::class, "productVariant"])->name("admin.productVariant");
        Route::post('/productVariant/store', [ProductVariantController::class, 'store'])->name('productVariant.store');
        Route::post('/productVariant/update', [ProductVariantController::class, 'updateProductVariant'])->name('productVariant.update');
        Route::post('/productVariant/actions', [ProductVariantController::class, 'productVariantActions'])->name('productVariant.actions');


        // Kitchen Stock
        Route::get("/kitchenStock/{view}", [DashboardController::class, "kitchenStock"])->name("admin.kitchenStock");
        Route::post('/kitchenStock/store', [KitchenStockController::class, 'store'])->name('kitchenStock.store');
        Route::post('/kitchenStock/update', [KitchenStockController::class, 'updateKitchenStock'])->name('kitchenStock.update');
        Route::post('/kitchenStock/actions', [KitchenStockController::class, 'kitchenStockActions'])->name('kitchenStock.actions');


        // Ingredient
        Route::get("/ingredient/{view}", [DashboardController::class, "ingredient"])->name("admin.ingredient");
        Route::post('/ingredient/store', [IngredientController::class, 'store'])->name('ingredient.store');
        Route::post('/ingredient/update', [IngredientController::class, 'updateIngredient'])->name('ingredient.update');
        Route::post('/ingredient/actions', [IngredientController::class, 'ingredientActions'])->name('ingredient.actions');


    });
});
