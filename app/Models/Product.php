<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    //আমরা জানি আমাদের db diagram প্রোডাক্ট টেবিলের সাথে ব্র্যান্ড টেবিলের একটা রিলেশনশিপ আছে। আবার ক্যাটাগরি টেবিলের সাথেও রিলেশন আছে। 


    //এখানে ইনভার্স রিলেশনশিপ belongsTo  ব্যবহার করে product model এর সাথে brand কে যুক্ত করা হয়েছে
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    //এখানে ইনভার্স রিলেশনশিপ belongsTo  ব্যবহার করে product model এর সাথে category কে যুক্ত করা হয়েছে
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
