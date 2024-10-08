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
        Schema::create('product_carts', function (Blueprint $table) {
            $table->id();

            //customer যখন প্রোডাক্ট add to cart করছে তার id 
            $table->unsignedBigInteger('user_id');

            //কোন প্রোডাক্টকে add to cart  করা হচ্ছে তার product_id
            $table->unsignedBigInteger('product_id');

            //product add to cart করার সময় যা যা নিচ্ছি color,size, qty, price
            $table->string('color',200);
            $table->string('size',200);
            $table->string('qty',200);
            $table->string('price',200);

            $table->foreign('product_id')->references('id')->on('products')
                ->restrictOnDelete()
                ->restrictOnUpdate();

            $table->foreign('user_id')->references('id')->on('users')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_carts');
    }
};
