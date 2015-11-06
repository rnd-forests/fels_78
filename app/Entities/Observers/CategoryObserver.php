<?php

namespace FELS\Entities\Observers;

use FELS\Entities\Category;

class CategoryObserver
{
    /**
     * Hook into category deleting event.
     *
     * @param Category $category
     * @return void
     */
    public function deleting(Category $category)
    {
        $category->lessons->each(function ($lesson) {
            $lesson->delete();
        });
        $category->words->each(function ($word) {
            $word->answers()->delete();
            $word->delete();
        });
    }
}
