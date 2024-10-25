<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductSlider;
use App\Models\ProductDetails;
use App\Models\ProductReview;
use App\Models\CustomerProfile;
use App\Helper\ResponseHelper;
use App\Models\ProductWish;
use App\Models\ProductCart;

class ProductController extends Controller
{

    public function WishList()
    {
        return view('pages.wish-list-page');
    }

    public function CartListPage()
    {
        return view('pages.cart-list-page');
    }

    public function Details()
    {
        return view('pages.details-page');
    }

    public function ListProductByCategory(Request $request):JsonResponse{
        //একটা ক্যাটাগরির আন্ডারে তার প্রোডাক্টগুলি লিস্ট।

        $data=Product::where('category_id',$request->id)->with('brand','category')->get();
        return ResponseHelper::Out('success',$data,200);

        /*এখানে $request parameter এ একটা id received করিয়াছি ($request->id)। সেই category_id where  দিয়ে সিলেক্ট করেছি। তার সাথে যুক্ত করে দেয়া হয়েছে। মানে প্রোডাক্টের সাথে যেহেতু brand এবং category রিলেশন আছে, সেটা ->get তুলে নিয়ে আসলাম $data এর ভেতর। পরবর্তীতে ResponseHelper করে out function এর ভেতর   আমরা প্রোডাক্টগুলি রিটার্ন করতে পারিতেছি   */
    }

    public function ListProductByRemark(Request $request):JsonResponse{
        $data=Product::where('remark',$request->remark)->with('brand','category')->get();
        return ResponseHelper::Out('success',$data,200);

        /*
        যেহেতু আমরা product টেবিল নিয়ে কাজ করছি। এই product টেবিলের ভেতরে remark নামে একটা কলাম আছে। যেখানে enam "popular", "new" , "top" , "special" , "trending"  আছে।

        সেই প্রোডাক্ট টেবিল থেকে $request->remark এর মাধ্যমে remark কলাম কে where দিয়ে সিলেক্ট করব, তার সাথে যুক্ত করে দেয়া হয়েছে ->with । মানে প্রোডাক্টের সাথে যেহেতু brand এবং category রিলেশন আছে, সেটা ->get তুলে নিয়ে আসলাম $data এর ভেতর। পরবর্তীতে ResponseHelper করে out function এর ভেতর   আমরা প্রোডাক্টগুলি রিটার্ন করতে পারিতেছি

        */

    }

    public function ListProductByBrand(Request $request):JsonResponse{
        $data=Product::where('brand_id',$request->id)->with('brand','category')->get();
        return ResponseHelper::Out('success',$data,200);

        /*
        শুধু ক্যাটাগরি অনুযায়ী প্রোডাক্ট এর লিস্ট দেখেছি প্রথমে।

        কিন্তু ব্র্যান্ড অনুযায়ী প্রোডাক্ট এর লিস্ট  দেখতে পারি

        */
    }

    public function ListProductSlider():JsonResponse{
        $data=ProductSlider::all();
        return ResponseHelper::Out('success',$data,200);

        //Product slider model/table সব স্লাইডার তুলে এনে, ResponseHelper এর ভেতরে Out() function এ পাঠিয়ে দিয়েছি
    }

    public function ProductDetailsById(Request $request):JsonResponse{

        $data=ProductDetails::where('product_id',$request->id)->with('product','product.brand','product.category')->get();

        return ResponseHelper::Out('success',$data,200);

        /*

        যখনই আমরা কোন প্রোডাক্টের details সিলেক্ট করব. এটা অবশ্যই কোন আইডি ধরেই সিলেক্ট করতে হবে. where('product_id',$request->id) request parameter থেকে id টাকে ধরে প্রোডাক্ট এর details খুঁজবে.

        আমাদের ডাটাবেজে প্রোডাক্ট এর দুইটা টেবিল আছে. একটা হচ্ছে শুধু product আর একটা হচ্ছে product details table. এখানে product এর সাথে brand and category যুক্ত আছে. এখানে product এর view দেখার জন্য দুইটা টেবিল থেকে ডাটা আসতে হবে। একটা হচ্ছে শুধু product যেখানে শুধু প্রোডাক্টের সামারি আছে. আরেকটা হচ্ছে product details

        এখানে শুধু product আর details আনলে হবে না. তার সাথে ব্র্যান্ড এবং ক্যাটাগরি এসোসিয়েট আছে  ('product','product.brand','product.category')


        তারমানে আমাদের product  select করতে হলে brand and category কে select করতে হবে. এর জন্য product model এর মদ্ধে BelongsTo ব্যবহার করেছি।
        */
    }

    public function ListReviewByProduct(Request $request):JsonResponse{
        $data=ProductReview::where('product_id',$request->product_id)->with(['profile'=>function($query){
                $query->select('id','cus_name');
            }])->get();
        return ResponseHelper::Out('success',$data,200);

        /*
        Class 7 time: 12:42
        product review table থেকে id select করতে হবে| ProductReview::মডেলের মধ্যে customer profile রিলেশন করানো আছে| রিভিউ দেখানোর জন্য শুধুমাত্র কাস্টমারের id এবং customerName হলেই হয়ে যাবে, এর জন্য আমরা  কুয়েরি ব্যবহার করেছি

        */
    }

    public function CreateProductReview(Request $request):JsonResponse{

        //এখানে tokenAuthentication এর মধ্য থেকে userID তুলে নিয়ে আসলাম
        $user_id=$request->header('id');

        /*
        আগে ডায়াগ্রাম টা একটু দেখতে হবে যে রিভিউ এর সাথে customer Profile রিলেশন. যদি কাস্টমার প্রোফাইল থাকে তাহলে তো রিভিউ দেখতে পাবো .  এই user_id  নিয়ে যেটা করবো দেখবো যে তার প্রোফাইল আছে কিনা? যদি প্রোফাইল থাকে তাহলে একসেপ্ট করব অন্যথায় না.

        **এখানে এমন সিস্টেম রাখছি যেটা সে যখন একটা কাস্টমার একাউন্ট ক্রিয়েট করবে সে চাইলে রিভিউ দিতে পারবেনা. রিভিউ দিতে গেলে  Customer profile not exists. এই কথাটা আসবে. তাহলে তার কি করতে হবে? প্রথমে একটা কাস্টমার প্রোফাইল ক্রিয়েট করে নিয়ে আসতে হবে তারপরে রিভিউ দিতে পারবে


        */
        $profile=CustomerProfile::where('user_id',$user_id)->first();

        if($profile){

            //request body ভেতর customer Id  সাথে profile_id  merge করে দিচ্ছি
            $request->merge(['customer_id' =>$profile->id]);

            //এখানে একটা ইউজার একটা প্রোডাক্টে একটাই রিভিউ দিতে পারবে এর জন্য updateOrCreate
            $data=ProductReview::updateOrCreate(
                ['customer_id' => $profile->id,'product_id'=>$request->input('product_id')],
                $request->input()
            );
            return ResponseHelper::Out('success',$data,200);
        }
        else{
            return ResponseHelper::Out('fail','Customer profile not exists',200);
        }

    }

    public function CreateWishList(Request $request):JsonResponse{
        // preloader কাজ করছে কিনা সেটা sleep ফাংশন টি ব্যবহার করে চেক করে দেখতে পারি sleep(5);

        //আমাদের middleware কাজ হচ্ছে হেডারে সার্বক্ষণিক ইমেইল এবং আইডি দিতে থাকা. তদ্রূপভাবে $request দিয়ে -> header থেকে id টা কে ধরে নিলাম

        //অন্যদিকে productWishlist model তৈরি করে রেখেছি সে মডেলের ভেতর দুইটি product_id, user_id fillable property রয়েছে
        $user_id=$request->header('id');


        //দুইটি fillable property এক সাতে updateOrCreate করার জন্য productWish::model থেকে updateOrCreate মেথড কে কল করেছি
        $data=ProductWish::updateOrCreate(

            //আমি যেটা বুঝলাম যে $user_id হেডারের থেকে রিকোয়েস্ট এর মাধ্যমে 'user_id' ডাটাবেজের এই কলামে নতুন আইডি ইনফরমেশন সেভ করছে?
            ['user_id' => $user_id,'product_id'=>$request->product_id],
            ['user_id' => $user_id,'product_id'=>$request->product_id],
        );
        return ResponseHelper::Out('success',$data,200);
    }

    public function ProductWishList(Request $request):JsonResponse{
        $user_id=$request->header('id');

        //এখানে একটা সিলেক্ট query চালাচ্ছি এখানে যে ইউজার সেই ইউজারের wishlist নিয়ে আসবো  এর জন্য   ProductWish table থেকে where('user_id',$user_id).  আমরা জানি productWish মডেলের মধ্যে productWish এর সাথে product  belogsTo inverse রিলেশন করানো আছে

        $data=ProductWish::where('user_id',$user_id)->with('product')->get();
        return ResponseHelper::Out('success',$data,200);
    }

    public function RemoveWishList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        //updateOrCreate এর মত কিন্তু শেষে delete() মেথড কল করে দিয়েছি
        $data=ProductWish::where(['user_id' => $user_id,'product_id'=>$request->product_id])->delete();
        return ResponseHelper::Out('success',$data,200);
    }


    public function CreateCartList(Request $request):JsonResponse{
        $user_id=$request->header('id');

        //ইউজার যখন প্রোডাক্ট  add to cart এ click করছে, কোন proudct add to cart এড করবো তার id, color, size, qty
        $product_id =$request->input('product_id');
        $color=$request->input('color');
        $size=$request->input('size');
        $qty=$request->input('qty');

        //শুরুতে ইউনিট প্রাইস 0  দিয়ে রাখবো
        $UnitPrice=0;

        //প্রোডাক্টের বিস্তারিত ডাটাবেজ থেকে product_id এর মাধ্যমে সংগ্রহ করা হচ্ছে. তার মানে হচ্ছে product:: টেবিলের মধ্যে থেকে $product_id যে প্রোডাক্ট সে একটু কার্ড করতে চায় তার “id” দিয়ে প্রোডাক্ট এর ডিটেল বের করে নিয়ে আসলাম
        $productDetails=Product::where('id','=',$product_id)->first();

        //যদি প্রোডাক্টের ডিসকাউন্ট এক্টিভ থাকে, তাহলে ডিসকাউন্ট প্রাইস নেওয়া হবে।
        if($productDetails->discount==1){
            $UnitPrice=$productDetails->discount_price;
        }

        //যদি ডিসকাউন্ট না থাকে, তাহলে প্রোডাক্টের regular দাম $UnitPrice এ সেট করা হয়েছে
        else{
            $UnitPrice=$productDetails->price;
        }

        //প্রোডাক্টের পরিমাণ এবং ইউনিট প্রাইস দিয়ে মোট মূল্য গুন করে $totalPrice এ রাখা হচ্ছে।
        $totalPrice=$qty*$UnitPrice;


        //ProductCart::updateOrCreate মডেল ব্যবহার করে ডাটাবেজে কার্টের তথ্য সেভ বা আপডেট করা হচ্ছে। র্টে প্রোডাক্ট আইডি এবং ইউজারের আইডি চেক করে, যদি আগে থেকে কার্টে প্রোডাক্ট থাকে তাহলে আপডেট হবে
        $data=ProductCart::updateOrCreate(
            ['user_id' => $user_id,'product_id'=>$product_id],
            [
                'user_id' => $user_id,
                'product_id'=>$product_id,
                'color'=>$color,
                'size'=>$size,
                'qty'=>$qty,
                'price'=>$totalPrice
            ]
        );

        return ResponseHelper::Out('success',$data,200);
    }


    //same as wishlist
    public function CartList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $data=ProductCart::where('user_id',$user_id)->with('product')->get();
        return ResponseHelper::Out('success',$data,200);
    }



    public function DeleteCartList(Request $request):JsonResponse{
        $user_id=$request->header('id');
        $data=ProductCart::where('user_id','=',$user_id)->where('product_id','=',$request->product_id)->delete();
        return ResponseHelper::Out('success',$data,200);
    }


}
