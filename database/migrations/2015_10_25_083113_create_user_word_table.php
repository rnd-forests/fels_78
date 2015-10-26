<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_word', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('word_id')->unsigned();
            $table->timestamps();

            $table->index('user_id');
            $table->index('word_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('word_id')->references('id')->on('words');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_word');
    }
}
