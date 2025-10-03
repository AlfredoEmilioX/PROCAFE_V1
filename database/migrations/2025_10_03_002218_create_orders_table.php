<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orders_id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('user_address_id');
            $table->foreign('user_address_id')->references('shipping_addresses_id')->on('shipping_addresses')->onDelete('cascade');

            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'paid', 'shipped', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }
};
