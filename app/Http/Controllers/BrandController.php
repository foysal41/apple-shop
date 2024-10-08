<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Brand;
use App\Helper\ResponseHelper;

class BrandController extends Controller
{
    public function BrandList():JsonResponse
    {   
        //brand মডেল থেকে সবগুলো ব্র্যান্ড তুলে এনেছি 
        $data= Brand::all();

        //ব্রান্ড যেহেতু select করেছি, সেহেতু brand সমস্ত ডেটা পেয়ে যাব. ResponseHelper out function মাধ্যমে আউটপুট করে দিলাম 
        return ResponseHelper::Out('success',$data,200);
    }
}
