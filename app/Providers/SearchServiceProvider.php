<?php

namespace FELS\Providers;

use FELS\Core\Search\EloquentSearch;
use Illuminate\Support\ServiceProvider;
use FELS\Core\Search\Contracts\Searchable;

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
        $this->app->singleton(Searchable::class, EloquentSearch::class);
    }

    /**
     * Register search facade.
     */
    protected function registerSearchFacade()
    {
        $this->app->singleton('search', Searchable::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['search', Searchable::class];
    }
}
