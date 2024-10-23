<?php
namespace App\Http\Controllers;
use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;




class UserController extends Controller
{

    public function LoginPage()
    {
        return view('pages.login-page');
    }

    public function VerifyPage()
    {
        return view('pages.verify-page');
    }

    public function UserLogin(Request $request):JsonResponse
    {
        try {
            //web.php থেকে  UserEmail একটা পেয়েছি, সেটা প্যারামিটার হিসেবে এখানে রিসিভ করছি
            $UserEmail=$request->UserEmail;

              //একটি 6 digit pin  জেনারেট করছি
            $OTP=rand (100000,999999);

             //details এর ভিতর OTP রেখে দিচ্ছি
            $details = ['code' => $OTP];

             //details code ইউজারকে মেইল করে পাঠিয়ে দিচ্ছি. এর জন্য OTPMail
            Mail::to($UserEmail)->send(new OTPMail($details));

              //যে ইমেইলের এগেনস্টে আমার otp রান করছি সেই ইমেইল যদি অলরেডি একাউন্ট ক্রিয়েট করা থাকে তাহলে তাকে otp পাঠানো লাগবে না . তার existing যে otp code আছে সেটাকে আপডেট করে দিচ্ছি .
            //অন্যথায় নতুন করে ইউজারকে ক্রিয়েট করছি
            User::updateOrCreate(['email' => $UserEmail], ['email'=>$UserEmail,'otp'=>$OTP]);
            return ResponseHelper::Out('success',"A 6 Digit OTP has been send to your email address",200);

        } catch (Exception $e) {
            return ResponseHelper::Out('fail',$e,200);
        }
    }

    //public function VerifyLogin(Request $request):JsonResponse
    public function VerifyLogin($email ,$otp )
    {

        $UserEmail = $email;
        $OTP = $otp;

        //login করানোর জন্য ইউজারের email এবং otp দুইটা নিলাম

        //---- $UserEmail=$request->UserEmail---;
        //----$OTP=$request->OTP----;

        //অলরেডি যে OTP ক্রিয়েট হয়েছে সেইটা সেইটা কাউন্ট করে দেখছি যে আমার ইউজারের কোন ভেরিফিকেশনের জন্য কোড এসেছে কিনা
        $verification=User::where('email', $UserEmail)->where('otp', $OTP)->first();

        if($verification){

            //যদি কোন ইউজার থাকে বা ভেরিফিকেশন কোডটা পেয়ে যাই,তাহলে সেই OTP  ডাটাবেজে update হবে

          //  -----User::where('email',$UserEmail)->where('otp',$OTP)->update();   -----//


            //সেই ইউজারের জন্য JWT Token create করছি (CreateToken)এই ফাংশনের মাধ্যমে
            /* টোকেন ক্রিয়েট করার সময় ($UserEmail,$verification->id) এই দুইটা ইনফরমেশন
            JWTToken.php ফাইলের ভেতর ($userEmail,$userID) এই প্যারামিটা দুইটার ভিতরে pass করে দিচ্ছি */
            $token = JWTToken::CreateToken($UserEmail,$verification->id);

            //রেসপন্স হিসাবে একটা সাকসেস মেসেজ দিয়েছি. এবং ব্রাউজারের কিস এর ভেতরে 'token' নামে  $token তাকে সেট করে দিয়েছি

            return  ResponseHelper::Out('success',"",200)->cookie('token',$token,60*24*30);

        }else{
            return ResponseHelper::Out('fail',"Invalid OTP",401);
        }
    }



    public function UserLogout()
    {
        return redirect('userLoginPage')->cookie('token',null,-1);
    }



}






