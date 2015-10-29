<?php

use FELS\Entities\Word;
use FELS\Entities\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class, 50)->create()
            ->each(function ($category) {
                $category->words()->saveMany(factory(Word::class, 30)->make());
            });

        Word::all()->each(function ($word) {
            $answers = collect([
                factory(FELS\Entities\Answer::class)->make(),
                factory(FELS\Entities\Answer::class)->make(),
                factory(FELS\Entities\Answer::class)->make(),
                factory(FELS\Entities\Answer::class)->make(['correct' => 1])
            ]);
            $shuffled = $answers->shuffle();
            $word->answers()->saveMany($shuffled);
        });
    }
}
