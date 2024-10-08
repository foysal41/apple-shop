<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            
            // Ensure unique field names for each image
            $table->string('img1', 200); 
            $table->string('img2', 200);
            $table->string('img3', 200);
            $table->string('img4', 200);
    
            $table->longText('des');
            //এই color কলামের ভেতর প্রোডাক্ট এর কালার কমা দিয়ে রেখে দিব(Red, Green, Yellow ). Then front-end এই কালার গুলো split করে, as a array আমারা dropdown আকারে দেখাবো 
            $table->string('color', 200);
            $table->string('size', 200);
    
            //এখানে একটা product_id এর একটাই ডিটেলস থাকবে একাধিক প্রোডাক্ট হওয়ার কোন সুযোগ নাই এর জন্য unique 
            $table->unsignedBigInteger('product_id')->unique();
    
            $table->foreign('product_id')->references('id')->on('products')
                ->restrictOnDelete()
                ->restrictOnUpdate();
    
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
