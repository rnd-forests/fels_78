<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('word_id')->unsigned();
            $table->integer('lesson_id')->unsigned();
            $table->string('solution');
            $table->boolean('correct')->default(false);
            $table->timestamps();

            $table->index('word_id');
            $table->index('lesson_id');
            $table->foreign('word_id')->references('id')->on('words');
            $table->foreign('lesson_id')->references('id')->on('lessons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('answers');
    }
}
