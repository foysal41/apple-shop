<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['email','otp'];

    //এখানে যেটা হবে যে প্রত্যেকটা ইউজারের একটা করে প্রোফাইল থাকবে. এখানে কাস্টমারদের প্রোফাইল থাকতেও পারে নাও থাকতে পারে. কিন্তু যদি থাকে তাহলে একটাই থাকবে. এজন্য hasOne রিলেশন করেছি 
    public function profile(): HasOne
    {
        return $this->hasOne(CustomerProfile::class);
    }
}
