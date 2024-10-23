<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Login</h3>
                        </div>
                            <div class="form-group mb-3">
                                 <!--একটি আইডি বসিয়ে দিলাম email -->
                                <input id="email" type="text" required="" class="form-control" name="email" placeholder="Your Email">
                            </div>
                            <div class="form-group mb-3">
                                <button onclick="Login()" type="submit" class="btn btn-fill-out btn-block" name="login">Next</button>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    async function Login() {
        // 2. ইউজারের ইমেইল এড্রেসটা document.getElementById input type থেকে পাব
        let email = document.getElementById('email').value;

        //3. তারপর এখানে একটা ছোট ভ্যালেডিশন করতে পারি, যদি ইমেইল না থাকে. ইউজারকে একটা টোস্ট মেসেজ দিতে পারি ইমেইল  Required
        if (email.length === 0) {
            alert("Email Required!");
        } else {
            $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
            //1. এক্সকিউজ ব্যবহার করে UserLogin একটি get রিকোয়েস্ট পাঠাবো + এর জন্য ইউজারের ইমেইল এড্রেসটা দরকার
            let res=await axios.get("/UserLogin/"+email);

            //4. যদি ইউজারের স্ট্যাটাস ২০০ থাকে তাহলে verify পেজে নিয়ে যাব
            if(res.status===200){
                //পরবর্তী পেজে যে যেন ইমেইল এড্রেসটাকে পিক করতে পারি এর জন্য সেশন স্টোরেজে রেখে গেলাম
                sessionStorage.setItem('email',email);
                window.location.href="/verify"
            }
            else{
                $(".preloader").delay(90).fadeOut(100).addClass('loaded');
                alert("Something Went Wrong");
            }
        }

    }
</script>
