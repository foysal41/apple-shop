<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductReview extends Model
{
    use HasFactory;
    public function profile(): BelongsTo
    {
        //কোন কাস্টমার রিভিউগুলো দিয়েছে তার টেবিলটা এখানে রিলেশন করিয়ে

        return $this->belongsTo(CustomerProfile::class,'customer_id');
    }
    //কাস্টমার   যখন রিভিউ ক্রিয়েট করবে তখন তার description','rating','customer_id', কোন product এর জন্য তার id 'product_id' লাগবে

    protected $fillable = ['description','rating','customer_id','product_id'];
}
