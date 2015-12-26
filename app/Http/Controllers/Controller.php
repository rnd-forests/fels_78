<?php

namespace FELS\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Gets the current authenticated user.
     *
     * @return \FELS\Entities\User|null
     */
    public function getAuthUser()
    {
        if (Auth::check()) {
            return Auth::user();
        }

        return null;
    }
}
