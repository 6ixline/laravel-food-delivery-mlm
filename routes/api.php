<?php

use Illuminate\Http\Request;
use App\DTO\BaseResponseDTO;
use App\Http\Controllers\admin\PincodeMasterController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\customer\AuthController;
use App\Http\Controllers\customer\DashboardController;
use App\Http\Middleware\JwtAuthenticate;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');




// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function (){
    return response()->json("example Backend API is running");
});


// Auth Endpoints
Route::post('/register/customer', [AuthController::class, 'registerCustomer']);
Route::post('/verifyotp', [AuthController::class, 'verifyOtp']);
Route::post('/resendotp', [AuthController::class, 'resendOtp']);
Route::post('/login/customer', [AuthController::class, 'login']);

// Dashboard
Route::post("/dashboard", [DashboardController::class, "HomeData"]);

// Pincode

Route::get("/pincode", [PincodeMasterController::class, "getPincode"]);

// Product
Route::get("/product", [ProductController::class, "getProduct"]);

Route::middleware([JwtAuthenticate::class])->group(function () {

    // Auth - Logout
    Route::post('/logout', [AuthController::class, 'logout']);



    // File Handling
    // Route::post('/upload/{id?}', [FileUploadController::class, 'upload']);


    
});


Route::fallback(function () {
    return response()->json(new BaseResponseDTO("error", "Route Not Found!"), 404);
});