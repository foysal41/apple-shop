<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Models\Category;
use App\Helper\ResponseHelper;

class CategoryController extends Controller


{

    public function ByCategoryPage()
    {
        return view('pages.product-by-category');
    }
    public function CategoryList():JsonResponse
    {
        $data= Category::all();
        return  ResponseHelper::Out('success',$data,200);
    }
}
