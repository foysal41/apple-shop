@extends('layout.app')
@section('content')
    @include('component.MenuBar')
    @include('component.HeroSlider')
    @include('component.TopCategories')
    @include('component.ExclusiveProducts')
    @include('component.TopBrands')
    @include('component.Footer')

/*Popular Top New Special এই পার্টে ফ্রন্ট এন্ডের সকল ইনফরমেশন ডিসপ্লে করিয়ে ছিলাম .
ট্যাব সেকশনে সকল ফাংশান ওখানে কল না করে সিকোয়েন্স ভাবে HOME পেজে ডিসপ্লে করাতে পারি.

যেটাকে বলে JAVASCRIPT INVOCKED  IIF ফাংশন. যেটাকে ম্যাজিক বা অটো কলিং ফাংশন বলা হয়.

কোন ডাটা গুলো আগে লোড হবে এবং কোন ডাটা গুলো পরে লোড হবে সেটা জন্য

*/

    <script>
        (async () => {
            await Category();
            await Hero();
            await TopCategory();
            //পেজের শুরুতে prpeloader এনিমেশন যুক্ত করছি
            //শুরুতে যে কমপ্লিট গুলো শো করালে হবে সেগুলো দেখিয়ে প্রডাক্টটা সেট করে দিব. স্ক্রল করতে করতে বাকিগুলো লোড নিয়ে নিবে
            $(".preloader").delay(90).fadeOut(100).addClass('loaded');
            await Popular();
            await New();
            await Top();
            await Special();
            await Trending();
            await TopBrands();
        })()
    </script>

@endsection

