<?php

namespace FELS\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->validateAlphaSpace();
    }

    /**
     * Validate that given pattern contains only
     * alphabetical characters and spaces.
     */
    protected function validateAlphaSpace()
    {
        $this->app->make('validator')
            ->extend('alpha_spaces', function ($attribute, $value, $parameters) {
                return preg_match('/^[\pL\s]+$/u', $value);
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
