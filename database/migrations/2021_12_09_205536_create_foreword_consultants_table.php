<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForewordConsultantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreword_consultants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts');
            $table->foreignId('foreword_by')->constrained('users');
            $table->foreignId('foreword_to')->constrained(      'users');
            $table->longText('solve')->nullable();
            $table->enum('status', ['not_solve', 'not_complete', 'solved'])->default('not_solve');
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
        Schema::dropIfExists('forword_consultants');
    }
}
