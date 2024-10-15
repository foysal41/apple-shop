<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Top Brands</h2>
                </div>
                <p class="text-center leads">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim Nullam nunc varius.</p>
            </div>
        </div>
        <div id="TopBrandItem" class="row align-items-center">


        </div>
    </div>
</div>


<script>
    TopBrands();
    async function TopBrands(){
        let res=await axios.get("/BrandList");
        $("#TopBrandItem").empty()
        res.data['data'].forEach((item,i)=>{

             //brandName ডাটাবেজ টেবিলের নামটা পাঠিয়ে দিলাম
            //brandImg ডাটাবেজ টেবিলের নামটা পাঠিয়ে দিলাম
            // #TopBrandItem এই ফাংশনটা অ্যাপেন্ড করে দিলাম
            let EachItem= `<div class="p-2 col-2">
                <div class="item">
                    <div class="categories_box">
                        <a href="/by-brand?id=${item['id']}">
                            <img src="${item['brandImg']}" alt="cat_img1"/>
                            <span>${item['brandName']}</span>
                        </a>
                    </div>
                </div>
            </div>`
            $("#TopBrandItem").append(EachItem);
        })
    }
</script>
