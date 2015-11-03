<?php

namespace FELS\Providers;

use FELS\Core\Composers\WordForm;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeAllViews();
        $this->composeWordFormView();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * All views will receive an instance of the
     * current authenticated user.
     */
    protected function composeAllViews()
    {
        view()->composer('*', function ($view) {
            return $view->with('currentUser', auth()->user());
        });
    }

    /**
     * Word forms will receive a list of categories.
     */
    protected function composeWordFormView()
    {
        view()->composer(
            ['admin.words.partials._main_form', 'users.words.index'],
            WordForm::class
        );
    }
}
