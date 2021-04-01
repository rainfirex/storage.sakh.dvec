<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityUserPasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_user_passwords', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entity_user_id')->unsigned();
            $table->foreign('entity_user_id')->references('id')->on('entity_users');
            $table->string('title');
            $table->string('password');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('entity_user_passwords');
    }
}
