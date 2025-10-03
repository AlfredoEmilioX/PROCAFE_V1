<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id('cart_id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('products_id');
            $table->foreign('products_id')->references('products_id')->on('products')->onDelete('cascade');

            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->timestamps();
        });
    }
};
