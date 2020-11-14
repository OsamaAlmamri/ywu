<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_replays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_question_id')->constrained('product_questions')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('replay_user_id')->index('replay_user_id');
            $table->text('text', 65535);
            $table->enum('replay_user_type', ['admin', 'customer'])->default('customer');
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
        Schema::dropIfExists('question_replays');
    }
}
