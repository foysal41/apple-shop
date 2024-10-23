@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.Login')
    @include('component.TopBrands')
    @include('component.Footer')
    <script>
        (async () => {
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>
@endsection

<!--ইউজার যদি লগইন অবস্থায় না থাকে তাহলে আমরা এই পেজে নিয়ে আসব এবং এই পেজের এনে আইডি পাসওয়ার্ড দিয়ে লগইন করতে দিব
-->
