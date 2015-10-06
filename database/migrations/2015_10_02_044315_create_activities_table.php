<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('target_id')->unsigned();
            $table->integer('subject_id')->unsigned();
            $table->string('subject_type');
            $table->string('action');
            $table->timestamps();

            $table->index('user_id');
            $table->index('target_id');
            $table->index('subject_id');
            $table->index('subject_type');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activities');
    }
}
