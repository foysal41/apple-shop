<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Policy;

class PolicyController extends Controller
{
    public function PolicyPage()
    {
        return view('pages.policy-page');
    }


    function PolicyByType(Request $request){
        return Policy::where('type','=',$request->type)->first();
      }
      //Module:23,class:7 , (05:46)
      //Policy ডাটাবেজের ভেতরে পলিসির বেশ কিছু টাইপ আছে $request->type। সেই পলিসির টাইপ গুলোকে where দিয়ে সিলেক্ট করা হয়েছে


      //Policy type ধরে ধরে ডাটা গুলো চলে আসবে
}
