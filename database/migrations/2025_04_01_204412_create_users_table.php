<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('avatar')->nullable();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->char('password_hash', 60);
            $table->string('phone', 20)->nullable();
            $table->enum('role', ['admin', 'stockkeeper'])->default('stockkeeper');
            $table->tinyInteger('status')->default(1);
            $table->char('code_verification_account', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
