<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_product_id')->constrained('order_products')->onUpdate('cascade')->onDelete('cascade');
            $table->string('option_value_name');
            $table->string('option_name');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product_attributes');
    }
}
