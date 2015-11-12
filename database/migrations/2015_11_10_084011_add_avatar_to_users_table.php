<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('github_name', 'github');
            $table->renameColumn('google_name', 'google');
            $table->renameColumn('facebook_name', 'facebook');

            $table->dropUnique('users_auth_provider_id_unique');
            $table->dropColumn('auth_provider_id');

            $table->string('avatar', 255)->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');

            $table->string('auth_provider_id')->nullable();
            $table->unique('auth_provider_id');

            $table->renameColumn('facebook', 'facebook_name');
            $table->renameColumn('google', 'google_name');
            $table->renameColumn('github', 'github_name');
        });
    }
}
