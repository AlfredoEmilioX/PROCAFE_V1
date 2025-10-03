<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('products_id');
            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id')->references('categories_id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('brands_id');
            $table->foreign('brands_id')->references('brands_id')->on('brands')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }
};
