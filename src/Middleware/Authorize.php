<?php

namespace Platform\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Authorize
{
    private $abilities = [
        'show' => 'update',
    ];

    public function handle(Request $request, \Closure $next, $guard = 'admin')
    {
        $method = str_after(Route::currentRouteAction(), '@');
        $name = Route::currentRouteName();

        if (array_get($this->abilities, $method)) {
            $name = str_before($name, $method).array_get($this->abilities, $method);
        }

        if (auth($guard)->user()->can($name)) {
            return $next($request);
        }

        return abort(403, __('无权限访问'));
    }
}
