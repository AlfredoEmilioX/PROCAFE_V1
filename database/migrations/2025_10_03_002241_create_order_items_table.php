<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id('order_items_id');

            $table->unsignedBigInteger('orders_id');
            $table->foreign('orders_id')->references('orders_id')->on('orders')->onDelete('cascade');

            $table->unsignedBigInteger('products_id');
            $table->foreign('products_id')->references('products_id')->on('products')->onDelete('cascade');

            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }
};
