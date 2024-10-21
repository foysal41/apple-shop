<header class="header_wrap fixed-top header_with_topbar">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <ul class="contact_detail text-center text-lg-start">
                            <li><i class="ti-mobile"></i><span>123-456-7890</span></li>
                            <li><i class="ti-email"></i><span>info@apple.com</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center text-md-end">
                        <ul class="header_list">
                            <!-- href এর মধ্যে আমরা টাইপটাকে মেনশন করে দিলাম তাহলে এবাউটের লিংক থেকে ওই টাইপের আন্ডারে যে কনটেন্ট টা ডিসপ্লে হবে -->
                            <li><a href="/policy?type=about">About</a></li>

                            @if(Cookie::get('token') !== null)
                                <li><a href="{{url("/profile")}}"> <i class="linearicons-user"></i> Account</a></li>
                                <li><a class="btn btn-danger btn-sm" href="{{url("/logout")}}"> Logout</a></li>
                            @else
                                <li><a class="btn btn-danger btn-sm" href="{{url("/login")}}">Login</a></li>
                            @endif



                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom_header dark_skin main_menu_uppercase">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{url("/")}}">
                    <img class="logo_dark" src="assets/images/logo_dark.png" alt="logo" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false">
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li><a class="nav-link nav_item" href="{{url("/")}}">Home</a></li>
                        <!--মেনুতে প্রোডাক্টের ড্রপ ডাউন আছে. এটা javascript দিয়ে নিচে append করে দেওয়া আছে CategoryItem id এর মাধ্য-->
                        <li class="dropdown">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Products</a>
                            <div class="dropdown-menu">
                                <ul id="CategoryItem">

                                </ul>
                            </div>
                        </li>
                        <li><a class="nav-link nav_item" href="{{url("/wish")}}"><i class="ti-heart"></i> Wish</a></li>
                        <li><a class="nav-link nav_item" href="{{url("/cart")}}"><i class="linearicons-cart"></i> Cart </a></li>
                        <li><a href="javascript:void(0);" class="nav-link search_trigger"><i class="linearicons-magnifier"></i> Search</a>
                            <div class="search_wrap">
                                <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                                <form>
                                    <input type="text" placeholder="Search" class="form-control" id="search_input">
                                    <button type="submit" class="search_icon"><i class="ion-ios-search-strong"></i></button>
                                </form>
                            </div><div class="search_overlay"></div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

<script>

    async function Category(){
        //step 1: function বানালাম এবং axios মাধ্যমে ক্যাটাগরির লিস্ট API কল করে নিয়ে আসলাম
        let res=await axios.get("/CategoryList");

        //step 2:ক্যাটাগরির আইটেম Empty করে দিলাম
        $("#CategoryItem").empty()

        //আমরা জানি যখন CategoryList এই API postman কল করা হয়. সম্পূর্ণ ক্যাটাগরির লিস্ট json data রিটার্ন চলে আসে. Step 3 তাই এখানে আমরা loop করাবো
        res.data['data'].forEach((item,i)=>{

            //আমরা একটা dropdowen item loop করাব তারপর আইটেম গুলা আপেন্ট করে দিব. DropDown একটা html li টুকু কপি করে নিয়ে `` এর ভিতরে নিয়ে নিলাম

            /*<li> <a class="dropdown-item nav-link nav_item" href="about.html"> Item </a> </li>*/

            /*let EachItem= এই লাইনে যেটা করেছি উপরে প্রোডাক্টের ড্রপ ডাউনের যে li গুলো হবে তার লুপ এখানে ঘোরাবো.
                href="" এর ভিতরে /by-category?id= মানে হচ্ছে by-category click or ধরে যাবে কোন আইটেমটা ধরবে সেটা হচ্ছে ${item['id']
            */

             // categoryName ডাটাবেজ টেবিলের নামটা পাঠিয়ে দিলাম
            // #CategoryItem এই ফাংশনটা অ্যাপেন্ড করে দিলাম
            let EachItem= ` <li><a class="dropdown-item nav-link nav_item" href="/by-category?id=${item['id']}">${item['categoryName']}</a></li>`

            $("#CategoryItem").append(EachItem);

        })
    }
</script>
