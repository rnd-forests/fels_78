<?php

use FELS\Entities\User;
use FELS\Entities\Word;
use FELS\Entities\Answer;
use FELS\Entities\Category;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => 'secret',
        'confirmed' => true,
    ];
});

$factory->defineAs(User::class, 'admin', function () use ($factory) {
    $user = $factory->raw(FELS\Entities\User::class);

    return array_merge($user, ['admin' => true]);
});

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(5),
        'description' => $faker->sentences(2, true),
    ];
});

$factory->define(Word::class, function (Faker $faker) {
    $levels = [Word::HARD, Word::MEDIUM, Word::EASY];

    return [
        'content' => $faker->word,
        'level' => array_random_val($levels),
    ];
});

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'solution' => $faker->sentence(6),
        'correct' => false,
    ];
});
