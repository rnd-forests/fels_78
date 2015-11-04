<?php

namespace FELS\Providers;

use FELS\Core\Mailer\UserMailer;
use Illuminate\Support\ServiceProvider;
use FELS\Core\Mailer\Contracts\UserMailer as UserMailerContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureAppEnvironments();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMailer();
    }

    /**
     * Set different configurations for different
     * application environments.
     */
    protected function configureAppEnvironments()
    {
        switch ($this->app->environment()) {
            case 'production':
                break;
            case 'local':
                $this->logDatabaseQueries();
                break;
            case 'testing':
                config(['database.default' => 'sqlite']);
                break;
        }
    }

    /**
     * Log database queries for local development.
     */
    protected function logDatabaseQueries()
    {
        $logger = $this->app->make('log');
        $this->app->make('db')->listen(function ($sql) use ($logger) {
            $logger->info($sql);
        });
    }

    /**
     * Register mailer interfaces.
     */
    protected function registerMailer()
    {
        $this->app->singleton(UserMailerContract::class, UserMailer::class);
    }
}
