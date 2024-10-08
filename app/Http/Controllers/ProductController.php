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

class ProductController extends Controller
{
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


 

}
