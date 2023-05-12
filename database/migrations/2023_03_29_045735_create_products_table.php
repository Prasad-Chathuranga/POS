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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_category_id');
            $table->string('name');
            $table->string('soh');
            $table->float('price');
            $table->tinyInteger('allow_price_change');
            $table->tinyInteger('can_delete');
            $table->tinyInteger('discountable');
            $table->tinyInteger('active');
            $table->timestamps();

            $table->foreign('product_category_id')->references('id')->on('product_categories');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
