<?php

namespace FELS\Services;

use FELS\Entities\Word;

class WordCounter
{
    public function total()
    {
        return Word::count();
    }

    public function percentageOfHardWords()
    {
        $partial = Word::ofLevel(Word::HARD)->count();

        return [$partial, round($partial / $this->total() * 100)];
    }

    public function percentageOfMediumWords()
    {
        $partial = Word::ofLevel(Word::MEDIUM)->count();

        return [$partial, round($partial / $this->total() * 100)];
    }

    public function percentageOfEasyWords()
    {
        $partial = Word::ofLevel(Word::EASY)->count();

        return [$partial, round($partial / $this->total() * 100)];
    }
}
