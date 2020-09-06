<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category__trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('employee_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('training_id')->constrained('trainings')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('category__trainings');
    }
}
