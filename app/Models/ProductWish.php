<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductWish extends Model
{
    use HasFactory;
    //যখন কাস্টমার add to wishlist করবে কোন ইউজার (user_id) আর কোন প্রোডাক্ট (product_id) এটা আমার প্রয়োজন হবে 

    protected $fillable = ['product_id','user_id'];
    

    //wishlist যখন আমরা প্রোডাক্টগুলো শো করাবো, এর জন্য প্রোডাক্টের ডিটেলস লাগবে তাই ইনভার্স রিলেশন করে নিলাম 

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
