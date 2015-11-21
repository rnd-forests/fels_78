<?php

namespace FELS\Providers;

use FELS\Entities\User;
use FELS\Entities\Word;
use FELS\Entities\Answer;
use FELS\Entities\Category;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'FELS\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $router->pattern('lessons', '[0-9]+');

        parent::boot($router);

        $this->bindRouteParameterToModel($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }

    /**
     * Bind route parameters with their associated models.
     *
     * @param Router $router
     */
    protected function bindRouteParameterToModel(Router $router)
    {
        // Bind 'users' key of defined routes to the User model.
        // The user instance will be retrieved by its slug attribute.
        // There are two cases to look for the users: the normal instances
        // and the soft deleted instances.
        $router->bind('users', function ($slug) {
            $user = User::whereSlug($slug)->first();

            return is_null($user)
                ? User::onlyTrashed()->whereSlug($slug)->firstOrFail()
                : $user;
        });

        // Bind 'answers' key of defined routes to the Answer model.
        $router->model('answers', Answer::class);

        // Bind 'words' key of defined routes to the Word model.
        $router->model('words', Word::class);

        // Bind 'categories' key of defined routes to the Category model.
        // The category instance will be retrieved by its slug attribute.
        $router->bind('categories', function ($slug) {
            return Category::whereSlug($slug)->firstOrFail();
        });
    }
}
