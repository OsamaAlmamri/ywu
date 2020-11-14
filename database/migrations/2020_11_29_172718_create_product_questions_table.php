<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *...........
     * @return void
     */
    public function up()
    {

        Schema::create('product_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('customers_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->text('text', 65535)->nullable();
            $table->boolean('question_read')->default(0);
            $table->integer('sort')->default(1);;
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /*
    *
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_questions');
    }
}
