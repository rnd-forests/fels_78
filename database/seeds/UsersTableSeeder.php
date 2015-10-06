<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(FELS\Entities\User::class, 'admin')->create([
            'name' => 'FELS Administrator',
            'email' => 'administrator@fels.com',
        ]);

        factory(FELS\Entities\User::class, 50)->create();
    }
}
