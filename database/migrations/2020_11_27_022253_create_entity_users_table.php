<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('username')->unique();
            $table->string('login')->unique();
            $table->string('email')->nullable();
            $table->string('department')->nullable();
            $table->string('title')->nullable();
            $table->string('phone')->nullable();
            $table->string('othertelephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('cabinet')->nullable();
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
        Schema::dropIfExists('entity_users');
    }
}
