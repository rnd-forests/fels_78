<?php

namespace FELS\Entities\Presenters;

use FELS\Entities\Word;
use Laracasts\Presenter\Presenter;

class WordPresenter extends Presenter
{
    /**
     * Print content of a word with according to its level of difficulty.
     *
     * @return string
     */
    public function printContent()
    {
        if ($this->level == Word::HARD) {
            return "<span class=\"word--type word--type__hard\">{$this->content}</span>";
        } elseif ($this->level == Word::MEDIUM) {
            return "<span class=\"word--type word--type__medium\">{$this->content}</span>";
        }

        return "<span class=\"word--type word--type__easy\">{$this->content}</span>";
    }
}
