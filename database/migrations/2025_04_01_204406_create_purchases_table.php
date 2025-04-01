<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('id_products');
            $table->unsignedBigInteger('id_providers');
            $table->integer('quantity');
            $table->double('price', 10, 2);
            $table->dateTime('purcharse_date');
            $table->timestamps();
            
            $table->foreign('id_products')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('id_providers')->references('id')->on('providers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
