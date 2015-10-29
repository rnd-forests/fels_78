<?php

namespace FELS\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->registerRepositories();
    }

    /**
     * Bind all repository interfaces to their concrete implementations.
     */
    protected function registerRepositories()
    {
        $this->app->singleton(
            \FELS\Core\Repository\Contracts\UserRepository::class,
            \FELS\Core\Repository\EloquentUserRepository::class
        );

        $this->app->singleton(
            \FELS\Core\Repository\Contracts\CategoryRepository::class,
            \FELS\Core\Repository\EloquentCategoryRepository::class
        );

        $this->app->singleton(
            \FELS\Core\Repository\Contracts\WordRepository::class,
            \FELS\Core\Repository\EloquentWordRepository::class
        );

        $this->app->singleton(
            \FELS\Core\Repository\Contracts\AnswerRepository::class,
            \FELS\Core\Repository\EloquentAnswerRepository::class
        );

        $this->app->singleton(
            \FELS\Core\Repository\Contracts\LessonRepository::class,
            \FELS\Core\Repository\EloquentLessonRepository::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            \FELS\Core\Repository\Contracts\UserRepository::class,
            \FELS\Core\Repository\Contracts\CategoryRepository::class,
            \FELS\Core\Repository\Contracts\WordRepository::class,
            \FELS\Core\Repository\Contracts\AnswerRepository::class,
            \FELS\Core\Repository\Contracts\LessonRepository::class,
        ];
    }
}
