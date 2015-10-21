<?php

namespace FELS\Providers;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSearchFacade();
        $this->registerSearchContract();
    }

    /**
     * Register search contract.
     */
    protected function registerSearchContract()
    {
        $this->app->singleton(
            \FELS\Core\Search\Contracts\SearchInterface::class,
            \FELS\Core\Search\EloquentSearch::class
        );
    }

    /**
     * Register search facade.
     */
    protected function registerSearchFacade()
    {
        $this->app->singleton('search', \FELS\Core\Search\Contracts\SearchInterface::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'search',
            \FELS\Core\Search\Contracts\SearchInterface::class,
        ];
    }
}
