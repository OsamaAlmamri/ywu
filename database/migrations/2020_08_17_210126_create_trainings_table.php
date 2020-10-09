<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // كورسات الماجدة التدريبية
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained('subject_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('mark')->default(0);
            $table->string('type');
            $table->text('learn')->nullable();
            $table->string('instructor')->nullable();
            $table->boolean('has_certificate')->default(0);
            $table->text('description')->nullable();
            $table->string('length')->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->string('thumbnail');
            $table->softDeletes();
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
        Schema::dropIfExists('trainings');
    }
}
