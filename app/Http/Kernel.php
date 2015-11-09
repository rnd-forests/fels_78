<?php

namespace FELS\Http;

use FELS\Http\Middleware\Authenticate;
use FELS\Http\Middleware\EncryptCookies;
use FELS\Http\Middleware\VerifyAdminUser;
use FELS\Http\Middleware\VerifyCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use FELS\Http\Middleware\RedirectIfAuthenticated;
use FELS\Http\Middleware\RedirectIfNotCorrectUser;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'guest' => RedirectIfAuthenticated::class,
        'auth.user' => RedirectIfNotCorrectUser::class,
        'admin' => VerifyAdminUser::class,
    ];
}
