<?php

use FELS\Entities\Relationship;
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

        $me = factory(FELS\Entities\User::class)->create([
            'name' => 'Vinh Nguyen',
            'email' => 'ngocvinh.nnv@gmail.com',
        ]);

        factory(FELS\Entities\User::class, 150)->create();
        foreach (range(3, 11) as $id) {
            $me->activeRelations()->save(Relationship::create([
                'follower_id' => $me->id,
                'followed_id' => $id,
            ]));
        }
        factory(FELS\Entities\User::class, 10)->create()
            ->each(function ($user) use ($me) {
                $user->activeRelations()->save(Relationship::create([
                    'follower_id' => $user->id,
                    'followed_id' => $me->id,
                ]));
            });
    }
}
