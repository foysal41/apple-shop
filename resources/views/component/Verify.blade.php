<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1">
                            <h3>Verification</h3>
                        </div>
                            <div class="form-group mb-3">
                                <!--একটি আইডি বসিয়ে দিলাম code -->
                                <input id="code" type="text" required="" class="form-control" name="email" placeholder="Verification Code">
                            </div>
                            <div class="form-group mb-3">
                                <!--onClick verify function এক্সিকিউট করে দিলাম-->
                                <button onclick="verify()" type="submit" class="btn btn-fill-out btn-block" name="login">Confirm</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    async function verify() {

        let code =document.getElementById('code').value;
        //login.blade.php থেকে ইমেইল টা তুলে নিয়ে আসব
        let email=sessionStorage.getItem('email');
        if (code.length === 0) {
            alert("Code Required!");
        } else {
            $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
            let res=await axios.get("/VerifyLogin/"+email+"/"+code);
            if(res.status===200){
                //ইউজারের last লোকেশন টা sessionStorage get করে "last_location" তুলে নিয়ে আসলাম
                    if(sessionStorage.getItem("last_location")){
                        window.location.href=sessionStorage.getItem("last_location")
                    }
                    else{
                        window.location.href="/"
                    }
            }
            else{
                $(".preloader").delay(90).fadeOut(100).addClass('loaded');
                alert("Request Fail")
            }
        }

    }

    // আরেকটি ভেরিফাই পেজ বানালাম


</script>


