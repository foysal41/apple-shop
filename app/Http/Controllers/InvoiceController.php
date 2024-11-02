<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Helper\SSLCommerz;
use App\Models\CustomerProfile;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\ProductCart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    function InvoiceCreate(Request $request)
    {

        //Database (DB) এর একটি ট্রানজেকশন শুরু করা হচ্ছে। Transaction মানে, যদি সব ধাপে সফল না হয়, তাহলে আগের কাজগুলো বাতিল হয়ে যাবে।  কোন পার্শিয়াল বা অতিরিক্ত ডাটা যদি ঢুকে যায় তাহলে সম্পূর্ণ বিষয়টাই বাতিল হয়ে যাবে

        //কারণ মাল্টিপল টেবিলে কাজ করতে হলে একা একা যাচ্ছে কোন এক সময় একটা টেবিলে ডাটা ইনসার্ট হয়েছে কিন্তু আর একটা টেবিলে ডাটা ইনসার্ট হয়নি তখন একটা ঝামেলা লেগে যেতে পারে.

        //দুইটাই যেন ঠিকঠাক ভাবে ইনসার্ট হয় আর যদি না হয় একটাতেও হবে না এর জন্যই আমরা এটা Transaction ব্যবহার করি

        DB::beginTransaction();
        try {

            //রিকোয়েস্টের header থেকে ব্যবহারকারীর আইডি ($user_id) এবং ইমেইল ($user_email) নেওয়া হচ্ছে।

            $user_id=$request->header('id');
            $user_email=$request->header('email');

            //একটি ইউনিক ট্রানজেকশন আইডি তৈরি করা হচ্ছে, যাতে প্রতিটি লেনদেনের জন্য একটি আলাদা আইডি থাকে।
            $tran_id=uniqid();

            //ডেলিভারি এবং পেমেন্ট স্ট্যাটাস শুরুতে Pending রাখা হচ্ছে
            $delivery_status='Pending';
            $payment_status='Pending';

            //CustomerProfile মডেল থেকে ব্যবহারকারীর প্রোফাইল খুঁজে আনা হচ্ছে, যেখানে user_id পাবো।

            $Profile=CustomerProfile::where('user_id','=',$user_id)->first();

            //এই কাস্টমার প্রোফাইল থেকে যখন ইউজারের আইডি পাব তখন customer name, address, city, phone, details সব পেয়ে যাব.
            $cus_details="Name:$Profile->cus_name,Address:$Profile->cus_add,City:$Profile->cus_city,Phone: $Profile->cus_phone";
            $ship_details="Name:$Profile->ship_name,Address:$Profile->ship_add ,City:$Profile->ship_city ,Phone: $Profile->cus_phone";

            // Payable Calculation
            $total=0;

            //cart list থেকে আমরা সমস্ত প্রোডাক্ট উঠিয়ে নিয়ে আসতেছি.
            $cartList=ProductCart::where('user_id','=',$user_id)->get();

            //foreach লুপের মাধ্যমে প্রতিটি প্রোডাক্টের দাম total এর সাথে যোগ করা হচ্ছে।
            foreach ($cartList as $cartItem) {
                $total=$total+$cartItem->price;
            }

            //total এর উপর ৩% ভ্যাট (VAT) হিসাব করা হচ্ছে
            $vat=($total*3)/100;
            $payable=$total+$vat;

            //একটি নতুন ইনভয়েস তৈরি করা হচ্ছে এবং সব তথ্য DB ইনভয়েসে সংরক্ষণ করা হচ্ছে।
            $invoice= Invoice::create([
                'total'=>$total,
                'vat'=>$vat,
                'payable'=>$payable,
                'cus_details'=>$cus_details,
                'ship_details'=>$ship_details,
                'tran_id'=>$tran_id,
                'delivery_status'=>$delivery_status,
                'payment_status'=>$payment_status,
                'user_id'=>$user_id
            ]);

            //নতুন ভয়েস তৈরি হয়েছে মানে একটা আইডি পেয়েছি

            $invoiceID=$invoice->id;

            //$cartList=ProductCart::where('user_id','=',$user_id)->get()

            //শুরুতে যে cartlist এর ডাটাগুলো সিলেক্ট করেছিলাম. সেই cartlist ডাটাগুলো নিয়ে  আরেকটি ফর ইচ লুক চালালাম. InvoiceProduct টেবিলে ডাটা গুলা সেট করলাম

            foreach ($cartList as $EachProduct) {
                InvoiceProduct::create([
                    //উপরে যে invoiceID টা পেয়েছি সেটা নিয়ে নিলাম
                    'invoice_id' => $invoiceID,

                    //প্রত্যেকটা প্রোডাক্ট এর আইডি নিয়ে নিলাম
                    'product_id' => $EachProduct['product_id'],

                    //ইউজার আইডি সেটা হেডার থেকে পেয়েছি তা নিয়ে নিলাম
                    'user_id'=>$user_id,

                    //cartlist qty and price থেকে নিয়ে নিলাম
                    'qty' =>  $EachProduct['qty'],
                    'sale_price'=>  $EachProduct['price'],

                    //Finallyy InvoiceProduct টেবিলে ডাটা গুলা সেট করলাম
                ]);
            }

            //SSLCommerz.php  ফাইলের ভিতর এই ভ্যারিয়েবল গুলো প্যারামিটার আকারে pass করলাম

            //এবার যখন এই InitiatePayment মেথড ফাংশনটি কল হবে তখন sslcommerce সব ব্যাংকগুলো চলে আসবে

           $paymentMethod=SSLCommerz::InitiatePayment($Profile,$payable,$tran_id,$user_email);

           DB::commit();

           // **  API  টেস্ট করার সময় অবশ্যই একটি ইউজারের বা কাস্টমারের প্রোফাইলে ক্রিয়েট করে নিতে হবে অন্যথায় কোর্ট কাজ করবে না.

           return ResponseHelper::Out('success',array(['paymentMethod'=>$paymentMethod,'payable'=>$payable,'vat'=>$vat,'total'=>$total]),200);

        }
        catch (Exception $e) {
            DB::rollBack();
            return ResponseHelper::Out('fail',$e->getMessage(),400);
        }

    }

    function InvoiceList(Request $request){
        $user_id=$request->header('id');
        return Invoice::where('user_id',$user_id)->get();
    }

    function InvoiceProductList(Request $request){
        $user_id=$request->header('id');
        $invoice_id=$request->invoice_id;
        return InvoiceProduct::where(['user_id'=>$user_id,'invoice_id'=>$invoice_id])->with('product')->get();
    }

    //যখন পেমেন্ট সাকসেস হবে তখন SSLCommerz.php file এর মদ্ধে parameter হিসাবে বা query string  এ tran_id পাঠিয়ে দিয়েছি. কোথায় পাঠিয়ে দিচ্ছি? InvoiceController.php ফাইল এর নিচে| InitiatePayment function এর মদ্ধে গেলে দেখতে পাবো

    // একটা ট্রানজেকশন আইডি মানে হচ্ছে একটা পেমেন্ট


    function PaymentSuccess(Request $request){
        //// যখন পেমেন্ট সাকসেস হচ্ছে  querystring ট্রানজেকশন আইডিটা ধরে নিয়ে  সরাসরি চলে যাচ্ছি SSLCommerz -> InitiateSuccess() ফাইল এর ভেতর
        SSLCommerz::InitiateSuccess($request->query('tran_id'));
        //return redirect('/profile');
        return 1;

    }


    // যখন  PaymentCancel হলে প্রোফাইল পেইজে নিয়ে যাবো সেখানে দেখাবো তোমার পেমেন্ট ক্যান্সেল হয়েছে সাকসেস হয়েছে
    function PaymentCancel(Request $request){
        SSLCommerz::InitiateCancel($request->query('tran_id'));
        return redirect('/profile');
    }

    function PaymentFail(Request $request){
        return SSLCommerz::InitiateFail($request->query('tran_id'));
        return redirect('/profile');
    }

    // PaymentIPN একটি পোস্ট রিকোয়েস্ট পাঠাবে PaymentIPN রিকোয়েস্টের ভেতরে একটি json থাকবে .  এর ভিতরে tran_id, status , val_id ssl commerce আমাদের পাঠাবে

    // SSLCommerz.php file এর মদ্ধে static function InitiateIPN($tran_id,$status,$val_id)-> এখান থেকে পাঠাচ্ছে

    function PaymentIPN(Request $request){
        return SSLCommerz::InitiateIPN($request->input('tran_id'),$request->input('status'),$request->input('val_id'));
    }
}

