<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsv2ToWomenPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('women_posts', function (Blueprint $table) {
            $table->enum('lang_type', ['ar', 'en', 'both'])->default('ar');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('women_posts', function (Blueprint $table) {
            //
        });
    }
}
