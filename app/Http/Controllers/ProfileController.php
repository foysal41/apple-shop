<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Helper\ResponseHelper;
use Illuminate\Http\Request;
use App\Models\CustomerProfile;





class ProfileController extends Controller
{
    public function CreateProfile(Request $request):JsonResponse
    {
        //এখানে আমরা ইউজারের id হেডারের মাধ্যমে পেয়েছি। এটি ঐ ইউজারের ইউনিক আইডেন্টিফায়ার।
        $user_id = $request->header('id');

        //এখানে আমরা $request এর সাথে user_id যুক্ত করছি, যাতে এটি অন্যান্য ইনপুটের সাথে একত্রে প্রোফাইল তৈরি বা আপডেটের জন্য ব্যবহার করা যায়।
        $request->merge(['user_id' => $user_id]);

        $data=CustomerProfile::updateOrCreate(
            ['user_id' => $user_id],
            $request->input()
        );

        //অবশেষে, ফাংশনটি সফলভাবে প্রোফাইল তৈরি বা আপডেট করার পরে success messageরিটার্ন করবে ডাটাবেজ।
        return ResponseHelper::Out('success',$data,200);
    }

    public function ReadProfile(Request $request): JsonResponse
    {
        $user_id=$request->header('id');
        $data=CustomerProfile::where('user_id',$user_id)->with('user')->first();
        return ResponseHelper::Out('success',$data,200);
    }
}
