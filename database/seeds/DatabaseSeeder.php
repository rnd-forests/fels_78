<?php

use FELS\Entities\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Tables for seeding data.
     *
     * @var array
     */
    protected $tables = [
        'users',
    ];

    /**
     * Seeder classes.
     *
     * @var array
     */
    protected $seeders = [
        'UsersTableSeeder',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        User::flushEventListeners();
        $this->truncateDatabase();
        foreach ($this->seeders as $seeder) {
            $this->call($seeder);
        }
    }

    /**
     * Truncate the database.
     */
    private function truncateDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}