<?php

namespace FELS\Services;

use FELS\Entities\Word;

class WordCounter
{
    public function total()
    {
        return Word::count();
    }

    public function countHardWords()
    {
        return Word::ofLevel(Word::HARD)->count();
    }

    public function countMediumWords()
    {
        return Word::ofLevel(Word::MEDIUM)->count();
    }

    public function countEasyWords()
    {
        return Word::ofLevel(Word::EASY)->count();
    }

    public function percentageOfHardWords()
    {
        return round($this->countHardWords() / $this->total() * 100);
    }

    public function percentageOfMediumWords()
    {
        return round($this->countMediumWords() / $this->total() * 100);
    }

    public function percentageOfEasyWords()
    {
        return round($this->countEasyWords() / $this->total() * 100);
    }
}
