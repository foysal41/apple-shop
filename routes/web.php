<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\TokenAuthenticate;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\HomeController;


// Home Page
Route::get('/', [HomeController::class, 'HomePage']);
Route::get('/by-category', [CategoryController::class, 'ByCategoryPage']);






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
Route::post('/createProductReview', [ProductController::class, 'CreateProductReview'])->middleware(TokenAuthenticate::class);


// User Auth
//user এর ইমেইল এ একটা opt code send করে দিবো
Route::get('/UserLogin/{UserEmail}', [UserController::class, 'UserLogin']);

//user যখন ওই ইমেইল এর মদ্ধে opt code টা পেয়েছে ওইটা আমাদের দিবে আমারা চেক করবো। থিক থাকলে তখন user এর জন একটা cookie generate করবো
//ওইটা user এর brower set হবে।
//Route::get('/VerifyLogin/{UserEmail}/{OTP}', [UserController::class, 'VerifyLogin']);

Route::get('/VerifyLogin/{UserEmail}/{otp}', [UserController::class,'VerifyLogin']);

//user এর লগইন click করলে cookie টা destory করে দিবো।
Route::get('/logout',[UserController::class,'UserLogout']);// User Auth


//User Profile

/*এখানে মিডিল ওয়ার দেওয়ার অর্থ হচ্ছে TokenAuthenticate.php ফাইলের ভিতরে cookie থেকে টোকেন রিসিভ করতে পারি এবং সেই token ta ডিকোড করার পর তা email and id রিড করতে পারি.*/
Route::post('/CreateProfile',[ProfileController::class,'CreateProfile'])->middleware([TokenAuthenticate::class]);
Route::get('/readProfile',[ProfileController::class,'readProfile'])->middleware([TokenAuthenticate::class]);


// Product Wish
Route::get('/ProductWishList', [ProductController::class, 'ProductWishList'])->middleware([TokenAuthenticate::class]);
Route::get('/CreateWishList/{product_id}', [ProductController::class, 'CreateWishList'])->middleware([TokenAuthenticate::class]);
Route::get('/RemoveWishList/{product_id}', [ProductController::class, 'RemoveWishList'])->middleware([TokenAuthenticate::class]);


// Product Cart
Route::post('/CreateCartList', [ProductController::class, 'CreateCartList'])->middleware([TokenAuthenticate::class]);
Route::get('/CartList', [ProductController::class, 'CartList'])->middleware([TokenAuthenticate::class]);
Route::get('/DeleteCartList/{product_id}', [ProductController::class, 'DeleteCartList'])->middleware([TokenAuthenticate::class]);


// Invoice and payment
Route::get("/InvoiceCreate",[InvoiceController::class,'InvoiceCreate'])->middleware([TokenAuthenticate::class]);
Route::get("/InvoiceList",[InvoiceController::class,'InvoiceList'])->middleware([TokenAuthenticate::class]);
Route::get("/InvoiceProductList/{invoice_id}",[InvoiceController::class,'InvoiceProductList'])->middleware([TokenAuthenticate::class]);


//payment
Route::post("/PaymentSuccess",[InvoiceController::class,'PaymentSuccess']);
Route::post("/PaymentCancel",[InvoiceController::class,'PaymentCancel']);
Route::post("/PaymentFail",[InvoiceController::class,'PaymentFail']);
//IPN call এর route web.php  রাখা হয়নি। কারণ web.php তে CSRF security এনাবেল করা থাকে. এর জন্য এই ফাইলটাকে API.php মধ্যে রাখা হয়েছে
