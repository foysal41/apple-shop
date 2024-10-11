<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\UserController;



Route::get('/', function () {
    return view('welcome');
});


// Brand List
Route::get('/BrandList', [BrandController::class, 'BrandList']);
// Category List
Route::get('/CategoryList', [CategoryController::class, 'CategoryList']);
// Product List
Route::get('/ListProductByCategory/{id}', [ProductController::class, 'ListProductByCategory']);
Route::get('/ListProductByBrand/{id}', [ProductController::class, 'ListProductByBrand']);
Route::get('/ListProductByRemark/{remark}', [ProductController::class, 'ListProductByRemark']);

// Slider
Route::get('/ListProductSlider', [ProductController::class, 'ListProductSlider']);
// Product Details
Route::get('/ProductDetailsById/{id}', [ProductController::class, 'ProductDetailsById']);
Route::get('/ListReviewByProduct/{product_id}', [ProductController::class, 'ListReviewByProduct']);
//policy
Route::get("/PolicyByType/{type}",[PolicyController::class,'PolicyByType']);

//Product Review
Route::get('/listReviewByProduct/{product_id}', [ProductController::class, 'ListReviewByProduct']);



// User Auth
//user এর ইমেইল এ একটা opt code send করে দিবো
Route::get('/UserLogin/{UserEmail}', [UserController::class, 'UserLogin']);

//user যখন ওই ইমেইল এর মদ্ধে opt code টা পেয়েছে ওইটা আমাদের দিবে আমারা চেক করবো। থিক থাকলে তখন user এর জন একটা cookie generate করবো
//ওইটা user এর brower set হবে।
//Route::get('/VerifyLogin/{UserEmail}/{OTP}', [UserController::class, 'VerifyLogin']);

Route::get('/VerifyLogin/{UserEmail}/{otp}', [UserController::class,'VerifyLogin']);


//user এর লগইন click করলে cookie টা destory করে দিবো।
Route::get('/logout',[UserController::class,'UserLogout']);// User Auth
