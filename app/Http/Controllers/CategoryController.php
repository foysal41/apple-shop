<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Category;
use App\Helper\ResponseHelper;

class CategoryController extends Controller
{
    public function CategoryList():JsonResponse
    {
        $data= Category::all();
        return  ResponseHelper::Out('success',$data,200);
    }  
}
