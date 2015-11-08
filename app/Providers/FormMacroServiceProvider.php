<?php

namespace FELS\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->deleteFormMacro();
        $this->restoreFormMacro();
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
     * Delete form macro.
     */
    protected function deleteFormMacro()
    {
        Form::macro('delete', function ($route, $params, $class = null) {
            return Form::open(['method' => 'DELETE', 'route' => [$route, $params], 'class' => $class]).
            '<button type="submit" class="btn btn-danger btn-xs" title="Delete">
                <i class="fa fa-times"></i>
            </button>'.
            Form::close();
        });
    }

    /**
     * Restore form macro.
     */
    protected function restoreFormMacro()
    {
        Form::macro('restore', function ($route, $params, $class = null) {
            return Form::open(['method' => 'PUT', 'route' => [$route, $params], 'class' => $class]).
            '<button type="submit" class="btn btn-info btn-xs" title="Restore">
                <i class="fa fa-arrow-left"></i>
            </button>'.
            Form::close();
        });
    }
}
