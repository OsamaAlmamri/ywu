<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->enum('action_type', ['trainings', 'posts', 'women'])->nullable();
            $table->unsignedBigInteger('action_id')->nullable();
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
        Schema::dropIfExists('slides');
    }
}
