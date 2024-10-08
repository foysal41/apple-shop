<?php

namespace App\Helper;

use Illuminate\Http\JsonResponse;


//response সাজিয়ে গুছিয়ে আউটপুট আকারে দেওয়ার জন্য এই ফাইলটি

class ResponseHelper
{
 public static function Out($msg,$data,$code):JsonResponse{
   return  response()->json(['msg' => $msg, 'data' =>  $data],$code);

 }
}
