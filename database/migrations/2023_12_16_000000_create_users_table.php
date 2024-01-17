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
            $table->integer('phone_number1')->nullable();
            $table->integer('phone_number2')->nullable();
            $table->longText('image')->nullable();
            $table->boolean('dual')->nullable();
            $table->boolean('first_login')->nullable();
            $table->integer('year')->nullable();
            $table->rememberToken();
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
