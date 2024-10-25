@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.PaymentMethodList')
    <!-- এই কার্ড লিস্ট কম্পোনেন্ট এর ভেতরে, কোন ইউজার যখন প্রোডাক্ট কার্ড করছে, সেই প্রোডাক্টটা ডিসপ্লে করানো হচ্ছে
-->
    @include('component.CartList')
    @include('component.TopBrands')
    @include('component.Footer')
    <script>
        (async () => {
            await CartList();
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection





