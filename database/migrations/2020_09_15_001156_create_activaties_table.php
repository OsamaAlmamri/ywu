<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivatiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activaties', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('title');
            $table->string('url');
            $table->unsignedInteger('type')->default(1);
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedInteger('sort')->default(1);
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
        Schema::dropIfExists('activaties');
    }
}
