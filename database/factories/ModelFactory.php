<?php

$factory->define(FELS\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => 'secret',
        'confirmed' => true,
    ];
});

$factory->defineAs(FELS\Entities\User::class, 'admin', function () use ($factory) {
    $user = $factory->raw(FELS\Entities\User::class);

    return array_merge($user, ['admin' => true]);
});
