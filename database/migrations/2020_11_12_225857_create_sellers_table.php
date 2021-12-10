<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sale_name');
            $table->string('ssn_image');
            $table->foreignId('gov_id')->constrained('zones')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('zones')->onUpdate('cascade')->onDelete('cascade');
            $table->string('more_address_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sellers');
    }
}
