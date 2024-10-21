<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1><span id="policyName"></span></h1>
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
        <div class="row">
            <div id="policy" class="col-12">

            </div>
        </div>
    </div>
</div>


<!--
একটা ওয়েবসাইটে TOC, পলিসি এগুলো থাকে| এবং আমাদের ডেটাবেজে ওইভাবে ও ডিজাইন করা আছে পলিসি দিয়ে একটা টেক্সট, toc  দিয়ে একটা text also about, refund, terms, how to buy, contact, complain এইগুলা হচ্ছে আমাদের এক একটা পলিসির নাম

আমাদের একটাই পলিসি পেজ হবে.  সেখানে মেনু হেডার ফুটার এগুলো থাকবে | policy list এই নামে একটা কম্পনেন্ট বানিয়ে এখানে আমরা শুধু শো করিয়ে দিব যে কোন পলিসিতে আছি. তো আমরা যে policy ভিতরেই যায় না কেন আমরা একটা টাইপ ধরেই যাচ্ছি।

আমাদের কাজ হচ্ছে এই policy ফাংশনের ভেতরের URLSearchParams  দিয়ে এই type কে ধরে নেওয়া. এবং আমাদের য়ে API  টা আছে policyByType + type এ হিট করা. তারপরে যে আমরা let des ডেসক্রিপশন পাচ্ছি,  সেটা #policy আইডিয়ার ভেতরে html টা পাশ করে দিচ্ছি

-->
<script>

    async function Policy(){
        let searchParams=new URLSearchParams(window.location.search);
        let type=searchParams.get('type');

        //যদি টাইপ about  হয় তাহলে span policyName ট্যাগের ভেতরে About us  এই টেক্সট দেখাও
        if(type==="about"){
            $("#policyName").text("About Us")
        }

        if(type==="refund"){
            $("#policyName").text("Refund Policy")
        }

        if(type==="terms"){
            $("#policyName").text("Terms & Condition")
        }

        if(type==="how to buy"){
            $("#policyName").text("How to Buy")
        }

        if(type==="contact"){
            $("#policyName").text("Our Contact Details")
        }

        if(type==="complain"){
            $("#policyName").text("How to put complain")
        }



        let res=await axios.get("/PolicyByType/"+type);
        let des=res.data['des']
        $("#policy").html(des)
    }

</script>
