<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_word', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id')->unsigned();
            $table->integer('word_id')->unsigned();
            $table->integer('answer_id')->unsigned();
            $table->integer('point')->unsigned();
            $table->timestamps();
            
            $table->index('lesson_id');
            $table->index('word_id');
            $table->index('answer_id');
            $table->foreign('lesson_id')->references('id')->on('lessons');
            $table->foreign('word_id')->references('id')->on('words');
            $table->foreign('answer_id')->references('id')->on('answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lesson_word');
    }
}
