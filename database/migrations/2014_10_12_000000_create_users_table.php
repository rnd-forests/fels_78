<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('email');
            $table->string('password', 60);
            $table->boolean('admin')->default(false);
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_code', 100)->nullable();
            $table->string('auth_provider')->default('eloquent');
            $table->string('auth_provider_id')->nullable();
            $table->string('facebook_name')->nullable();
            $table->string('github_name')->nullable();
            $table->string('google_name')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->index('slug');
            $table->unique('email');
            $table->unique('auth_provider_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
