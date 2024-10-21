<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Brand;
use App\Helper\ResponseHelper;

class BrandController extends Controller
{

    //প্রথমে ByBrandPage কন্ট্রোলার বানিয়ে নিলাম. এবং তার জন্য একটা রাউট তৈরি করলাম
    // product-by-brand blade এর মধ্যে যাব/ অথবা তৈরি করব 
    public function  ByBrandPage()
    {
        return view('pages.product-by-brand');
    }

    public function BrandList():JsonResponse
    {
        //brand মডেল থেকে সবগুলো ব্র্যান্ড তুলে এনেছি
        $data= Brand::all();

        //ব্রান্ড যেহেতু select করেছি, সেহেতু brand সমস্ত ডেটা পেয়ে যাব. ResponseHelper out function মাধ্যমে আউটপুট করে দিলাম
        return ResponseHelper::Out('success',$data,200);
    }
}
