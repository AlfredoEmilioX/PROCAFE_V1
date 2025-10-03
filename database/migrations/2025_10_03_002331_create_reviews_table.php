<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('reviews_id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('products_id');
            $table->foreign('products_id')->references('products_id')->on('products')->onDelete('cascade');

            $table->tinyInteger('rating')->unsigned()->comment('1-5');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }
};
