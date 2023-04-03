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
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_category_id');
            $table->string('username');
            $table->string('address');
            $table->string('mobile');
            $table->string('phone');
            $table->tinyInteger('active');
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('user_category_id')->references('id')->on('user_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
