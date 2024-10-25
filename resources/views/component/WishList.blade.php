<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Wish List</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">This Page</a></li>
                </ol>
            </div>
        </div>
    </div><!-- END CONTAINER-->
</div>



<div class="mt-5">
    <div class="container my-5">
        <div id="byList" class="row">
        </div>
    </div>
</div>



<script>
    async function WishList(){
        let res=await axios.get(`/ProductWishList`);
        //প্রথমে wishlist ফাঁকা করে নিয়েছি
        $("#byList").empty();

        //তারপর foreach loop চালিয়ে append করিয়ে দিয়েছি
        // wishlistগুলো শো করাইনি যখন প্রোডাক্ট এর উপর ক্লিক করবে তার details পেজে নিয়ে যাওয়ার ব্যবস্থা রেখেছি

        res.data['data'].forEach((item,i)=>{
            let EachItem=`<div class="col-lg-3 col-md-4 col-6">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="#">
                                            <img src="${item['product']['image']}" alt="product_img9">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li><a href="/details?id=${item['product']['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="/details?id=${item['product']['id']}">${item['product']['title']}</a></h6>
                                        <div class="product_price">
                                            <span class="price">$ ${item['product']['price']}</span>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:${item['product']['star']}%"></div>
                                            </div>
                                        </div>

                                        <button class="btn remove btn-sm my-2 btn-danger" data-id="${item['product']['id']}">Remove</button>

                                    </div>
                                </div>
                            </div>`
                            //
            $("#byList").append(EachItem);
        })


        //এই ফাংশন টি ব্যবহার করে প্রোডাক্ট লিস্টে রিমুভ যেভাবে করে সেটার ফাংশন তৈরি করলাম. যা হচ্ছে একটি css class এটা উপরে apend করিয়েছি. যেটার কার্যকারিতা হচ্ছে onclick function, তারমানে একটি বাটনে ক্লিক করলে তার id পিক করবে


        $(".remove").on('click',function () {
            let id= $(this).data('id');
            RemoveWishList(id);
        })


    }

    /* wishlist থেকে প্রোডাক্ট রিমুভ করতে হলে axios দিয়ে একটি রিকোয়েস্ট পাঠাবো.

    wishlist রিমুভ করার ফাংশন বা লজিকটা এমন ছিল. postman  উইস লিস্টের api এর সাথে আইডিটা দিয়ে দিতাম দিয়ে হিট করলে প্রোডাক্ট রিমুভ হয়ে যেত. তো এখানে লজিক হচ্ছে functino ভিতর একটি id পাস করছি

    wishlist যদি প্রোডাক্ট দেয়া দেয়া হয় তার স্ট্যাটাস যদি ২০০ হয় wishlist কে রিফ্রেশ করে দিতে পারি অন্যথায় না হলে Request Fail


    */
  async function RemoveWishList(id){
      $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
        let res=await axios.get("/RemoveWishList/"+id);
      $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        if(res.status===200) {
            await WishList();
        }
        else{
            alert("Request Fail")
        }
    }

</script>
