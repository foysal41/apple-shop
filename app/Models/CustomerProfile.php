<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerProfile extends Model
{
    use HasFactory;

    //কাস্টমাররা তো তাদের প্রোফাইলে আসবে এবং প্রোফাইলে ডিটেলস পরিবর্তন করবে, এর জন্য এই মডেলে  কাজ করলাম

    protected $fillable = [
        'cus_name',
        'cus_add',
        'cus_city',
        'cus_state',
        'cus_postcode',
        'cus_country',
        'cus_phone',
        'cus_fax',
        'ship_name',
        'ship_add',
        'ship_city',
        'ship_state',
        'ship_postcode',
        'ship_country',
        'ship_phone',
        'user_id'
    ];

    //প্রত্যেকটা কাস্টমাররা, প্রোফাইল ইউজারের সাথে যুক্ত এর জন্য এখানে BelongsTo দ্বারা user এর সাথে যুক্ত করে দেয়া হয়েছে

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
