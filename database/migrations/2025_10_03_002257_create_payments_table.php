<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payments_id');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('orders_id')->on('orders')->onDelete('cascade');

            $table->enum('payment_method', ['paypal', 'stripe', 'bank_transfer']);
            $table->decimal('amount', 10, 2);
            $table->string('transaction_id')->nullable();
            $table->json('transaction_json')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });
    }
};
