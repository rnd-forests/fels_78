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

$factory->define(FELS\Entities\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(5),
        'description' => $faker->sentences(2, true),
    ];
});

$factory->define(FELS\Entities\Word::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->word,
    ];
});

$factory->define(FELS\Entities\Answer::class, function (Faker\Generator $faker) {
    return [
        'solution' => $faker->sentence(6),
        'correct' => false,
    ];
});
