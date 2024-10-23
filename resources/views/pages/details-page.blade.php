@extends('layout.app')
@section('content')
    @include('component.MenuBar')

    <!--
         1. এই পর্বে প্রোডাক্ট ডিটেল পেজ নিয়ে কাজ করব. ইউজার যখন কোন একটি প্রোডাক্ট এ ক্লিক করবে, উক্ত প্রোডাক্ট এর একটা আইডি / API থেকে প্রোডাক্ট এর ডিটেইল পেজটা get/চলে আসবে.

        2. যে পেজ থেকে প্রোডাক্ট এর ডিটেল দেখাবো সেই page কাজ করব
        exclusiveProductDetails.blade.php
        byBrandlist.blade.php
        byCategoryList.blade.php
        heroSlider.blade.php
    -->
    @include('component.ProductDetails')
    @include('component.ProductSpecification')
    @include('component.TopBrands')
    @include('component.Footer')
    <script>
        (async () => {
            //প্রোডাক্ট detalis ফাংশন এখানে এক্সিকিউট করলাম 

            await productDetails();
            await productReview();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection

