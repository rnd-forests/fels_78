<?php

namespace FELS\Providers;

use Illuminate\Support\ServiceProvider;
use FELS\Core\Repository\EloquentUserRepository;
use FELS\Core\Repository\EloquentWordRepository;
use FELS\Core\Repository\Contracts\UserRepository;
use FELS\Core\Repository\Contracts\WordRepository;
use FELS\Core\Repository\EloquentAnswerRepository;
use FELS\Core\Repository\EloquentLessonRepository;
use FELS\Core\Repository\Contracts\AnswerRepository;
use FELS\Core\Repository\EloquentCategoryRepository;
use FELS\Core\Repository\Contracts\LessonRepository;
use FELS\Core\Repository\Contracts\CategoryRepository;

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
        $this->bindRepositories();
    }

    /**
     * Bind all repository interfaces to their
     * concrete implementations.
     */
    protected function bindRepositories()
    {
        $this->app->singleton(UserRepository::class, EloquentUserRepository::class);
        $this->app->singleton(CategoryRepository::class, EloquentCategoryRepository::class);
        $this->app->singleton(WordRepository::class, EloquentWordRepository::class);
        $this->app->singleton(AnswerRepository::class, EloquentAnswerRepository::class);
        $this->app->singleton(LessonRepository::class, EloquentLessonRepository::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            UserRepository::class,
            CategoryRepository::class,
            WordRepository::class,
            AnswerRepository::class,
            LessonRepository::class,
        ];
    }
}
