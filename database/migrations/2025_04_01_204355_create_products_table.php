<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('id_provider');
            $table->unsignedBigInteger('id_category');
            $table->double('price', 10, 2);
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->dateTime('create_at')->nullable();
            $table->dateTime('update_at')->nullable();
            $table->enum('unit_type', ['kg', 'g', 'T', 'unit', 'L', 'ml']);
            $table->timestamps();
            
            $table->foreign('id_provider')->references('id')->on('providers')->onDelete('cascade');
            $table->foreign('id_category')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}