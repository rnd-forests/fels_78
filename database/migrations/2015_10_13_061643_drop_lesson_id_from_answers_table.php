<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropLessonIdFromAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->dropForeign('answers_lesson_id_foreign');
            $table->dropIndex('answers_lesson_id_index');
            $table->dropColumn('lesson_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->integer('lesson_id')->unsigned();
            $table->index('lesson_id');
            $table->foreign('lesson_id')->references('id')->on('lessons');
        });
    }
}
