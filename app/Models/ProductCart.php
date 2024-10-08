<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCart extends Model
{
    use HasFactory;
    //ইউজার যখন add to cart করবে তখন add to cart টেবিলে ডাটা যোগ করতে হবে। ইনসার্ট করানোর জন্য $fillable

    protected $fillable = ['user_id','product_id','color','size','qty','price'];

    //একটু add to cart যখন যুক্ত করছি সেটা কোন প্রোডাক্ট? তার ডিটেলএর জন্য ইনভার্স প্রপার্টি belongsTo ব্যবহার করছি।
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
