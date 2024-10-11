<?php

/*
আমরা কাস্টমারদের একটা প্রোফাইল ক্রিয়েট করব এবার. তার জন্য আমরা ফ্রন্ট এন্ড একটা ফর্ম দিয়ে দিতে পারি. এখানে নাম এড্রেস সিটি থাকলো তাই সকল তথ্য দিয়ে ইউজারের প্রোফাইল ক্রিয়েট করবে.

মনে রাখতে হবে প্রোফাইল ক্রিয়েটের ঘটনাটি হচ্ছে লগইন পরবর্তী ঘটনা. Login পরবর্তী ঘটনা চেক করার জন্য or লগইন করেছে কিনা সেটা চেক করতে হবে.

 আমরা জানি যখন ইউসার কে লগইন করিয়েছিলাম তখন তার ব্রাউজারে একটা টোকেন নামে  এর মধ্যে কুকি সেট করেছিলাম. এই টোকেনের ভেতর ইউজারের ইমেইল এবং আইডি রেখে দিয়েছি.

এবার এই টোকেন  যখন ব্যান্ডে যাবে তখন tokenverification  নামে একটা middleware তৈরি করে তারপর এই টোকেন টাকে যদি ডিকোড করি. তখন ইউজারের ইমেইল আইডি পেয়ে যাব. এর জন্য এই পেজটি বানিয়েছি

*/
namespace App\Http\Middleware;
use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class TokenAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        //যখন আমাদের ব্রাউজারে token সেট হয়ে যাবে তখনই টোকেন টা cookies  টা backend চলে যাবে. তখনই $token আমাকে ধরতে হবে.
        $token=$request->cookie('token');

        //এখানে token ডিকোড করালাম
        $result=JWTToken::ReadToken($token);

        /*
        এখানে উল্টা করে চিন্তা করতে হবে.  যদি ইউজার unauthorized হয় তাহলে তাকে বলে দেব.

        আর যদি সবকিছু ঠিকঠাক থাকে else  এর মধ্যে যেটা করলাম, ইউজারের হেডারে আইডি এবং ইমেইল সেট করে দেব
        */


        if($result=="unauthorized"){
           // return ResponseHelper::Out('unauthorized',null,401);
           return redirect('userLogin');
        }
        else{
            $request->headers->set('email',$result->userEmail);
            $request->headers->set('id',$result->userID);
            return $next($request);
        }
    }
}
