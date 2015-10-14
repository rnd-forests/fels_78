<?php

use FELS\Entities\User;
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
        factory(User::class, 'admin')->create([
            'name' => 'FELS Administrator',
            'email' => 'administrator@fels.com',
        ]);

        $me = factory(User::class)->create([
            'name' => 'Vinh Nguyen',
            'email' => 'ngocvinh.nnv@gmail.com',
        ]);

        factory(User::class, 300)->create();
        foreach (range(3, 11) as $id) {
            $me->activeRelations()->create(['followed_id' => $id]);
        }
        factory(User::class, 10)->create()
            ->each(function ($user) use ($me) {
                $user->activeRelations()->create(['followed_id' => $me->id]);
            });
    }
}
