<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('status', ['new', 'cancel_by_seller', 'cancel_by_user', 'in_progress', 'shipping', 'delivery'])->default('new');
            $table->decimal('price', 10);
            $table->decimal('shipping_cost', 10)->default(0);
            $table->string('shipping_method', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_sellers');
    }
}
