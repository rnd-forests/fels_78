<?php

namespace FELS\Core\Composers;

use Illuminate\Contracts\View\View;
use FELS\Core\Repository\Contracts\CategoryRepository;

class WordForm
{
    protected $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Composer word forms.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->categories->lists());
    }
}
