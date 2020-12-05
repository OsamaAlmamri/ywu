<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('gov_id')->constrained('zones')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('zones')->onUpdate('cascade')->onDelete('cascade');
            $table->string('more_address_info');
            $table->string('phone', 30);
            $table->string('customer_name', 100);
            $table->enum('payment_method', ['on_delivery', 'transfer'])->default('transfer');
            $table->smallInteger('payment_status')->default(0);
            $table->decimal('price', 10);
            $table->string('coupon')->nullable();
            $table->integer('coupon_discount')->default(0);
            $table->decimal('shipping_cost', 10)->default(0);
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
        Schema::dropIfExists('orders');
    }
}
