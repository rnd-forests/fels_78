<?php

namespace FELS\Entities\Presenters;

use Laracasts\Presenter\Presenter;

class LessonPresenter extends Presenter
{
    /**
     * Construct lesson name attribute.
     *
     * @return string
     */
    public function fullName()
    {
        $parts = preg_split('/_/', $this->name);

        return "{$parts[0]} on @{$parts[1]} ({$this->created_at})";
    }
}
