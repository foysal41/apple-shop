<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceProduct extends Model
{
    use HasFactory;

    //প্রত্যেকটা ইনভয়েসের এগেইনস্টে প্রোডাক্ট থাকবে। সে প্রোডাক্টের সামারি ক্রিয়েট করার জন্য fillable 

    protected $fillable = ['invoice_id', 'product_id', 'qty', 'sale_price','user_id'];

    //Product id সাথে সেই প্রোডাক্টের রিলেশনশিপ করানো হয়েছে
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
