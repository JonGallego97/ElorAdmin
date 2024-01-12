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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->string('surname1');
            $table->string('surname2');
            $table->string('DNI');
            $table->string('address')->nullable();
            $table->integer('phoneNumber1')->nullable();
            $table->integer('phoneNumber2')->nullable();
            $table->longText('image')->nullable();
            $table->boolean('dual')->nullable();
            $table->boolean('firstLogin')->nullable();
            $table->integer('year')->nullable();
            $table->rememberToken();
            $table->unsignedBigInteger('role_id')->nullable();
           

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_users');
        Schema::dropIfExists('users');
    }
};
