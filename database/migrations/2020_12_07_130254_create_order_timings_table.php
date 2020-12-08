<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTimingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_timings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('order_seller_id')->constrained('order_sellers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status')->default(1);
            $table->string('description');
            $table->enum('type', ['payment_status', 'order_status'])->default('order_status');
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
        Schema::dropIfExists('order_timings');
    }
}
