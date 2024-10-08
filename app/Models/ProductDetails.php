<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDetails extends Model
{
    use HasFactory;
    //প্রোডাক্ট ডিটেল এর জন্য তো প্রোডাক্ট টেবিলের সবকিছু আনতে হবে।

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
