<?php

namespace FELS\Providers;

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
}
