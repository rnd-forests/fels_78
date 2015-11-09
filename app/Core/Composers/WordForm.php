<?php

namespace FELS\Core\Composers;

use Illuminate\Contracts\View\View;
use FELS\Core\Repository\Contracts\CategoryRepository;

class WordForm
{
    /**
     * Compose word forms.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categories', app(CategoryRepository::class)->lists());
    }
}
