<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_attributes', function (Blueprint $table) {
            $table->id('products_attributes_id');
            $table->foreignId('product_id')->constrained('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('options_id')->references('products_options_id')->on('products_options')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('options_values_id')->references('products_options_values_id')->on('products_options_values')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('options_values_price');
            $table->char('price_prefix', 1);
            $table->boolean('is_default')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_attributes');
    }
}
