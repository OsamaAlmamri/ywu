<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->enum('gender',['male','female'])->default('female');
            $table->enum('type',['customers','share_users','employees','visitor','admin', 'seller'])->default('visitor');
            $table->boolean('status')->default(1);
            $table->foreignId('gov_id')->constrained('zones')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('district_id')->constrained('zones')->onUpdate('cascade')->onDelete('cascade');
            $table->string('more_address_info');

            $table->timestamp('email_verified_at')->nullable();
            $table->string('image')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
