<?php

//jwt token 3rd party library install এর জন্য jwt token php
//composer require firebase/php-jwt

namespace App\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTToken
{
    public static function CreateToken($userEmail,$userID):string
    {
        //JWT Token ক্রিয়েট করার জন্য আমাদের KEY কারো সেটা  env ফাইলের ভিতরে সেট করে দিয়েছি 
        $key =env('JWT_KEY');

        //JWT Token ক্রিয়েট করার জন্য $payload তৈরি করতে হয় | এই payload এর মধ্যে দুইটা জিনিস রেখে দিচ্ছি  userEmail,userID. পরবর্তীতে ব্যবহার করার জন্য 

        $payload=[
            'iss'=>'laravel-token',
            'iat'=>time(),
            'exp'=>time()+24*60*60,
            'userEmail'=>$userEmail,
            'userID'=>$userID
        ];

        //এই লাইনটি payload এবং key and algorithm এটি রিটার্ন করছে। এবং এভাবেই যে JWT আমরা ক্রিয়েট করছি 
        return JWT::encode($payload,$key,'HS256');
    }

    // JWT token read ফাংশন বানাচ্ছি 
    public static function ReadToken($token): string|object
    {

        try {
            //যদি তোকে null হয় তাহলে ইউজারকে unauthorized বলে দিব 
            if($token==null){
                return 'unauthorized';
            }

            //আর যদি নাল না হয় তাহলে  .env থেকে যে KEY পেয়ে jwt ক্রিয়েট করেছিলাম ওটা দিয়ে টোকেন টাকে decode করব  
            // decode করার জন্য decode ফাংশন ব্যবহার করেছি, টোকেন টা পাস করেছি.


            else{
                $key =env('JWT_KEY');
                return JWT::decode($token,new Key($key,'HS256'));
            }
        }

        //যদি কোন কারনে এই সম্পূর্ণ প্রক্রিয়াটি ভুল হয় তখন রিটার্ন করে দিলাম আন unauthorized 
        catch (Exception $e){
            return 'unauthorized';
        }
    }
}
