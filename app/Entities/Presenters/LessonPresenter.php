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

    /**
     * Get lesson name with an icon indicating finished state.
     *
     * @return string
     */
    public function fullNameWithIcon()
    {
        return $this->finished
            ? "<i class=\"fa fa-check text-success\"></i> {$this->fullName()}"
            : "<i class=\"fa fa-times text-danger\"></i> {$this->fullName()}";
    }
}
