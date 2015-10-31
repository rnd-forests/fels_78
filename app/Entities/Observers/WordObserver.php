<?php

namespace FELS\Entities\Observers;

use FELS\Entities\Word;

class WordObserver
{
    /**
     * Hook into word deleting event.
     *
     * @param Word $word
     */
    public function deleting(Word $word)
    {
        $word->answers()->delete();
        $word->lessons()->detach();
        $word->users()->detach();
    }
}
