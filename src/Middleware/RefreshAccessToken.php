<?php

/*
 * style: fix StyleCI.
 */

namespace Platform\Middleware;

use Closure;
use Illuminate\Http\Request;

class RefreshAccessToken
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param string $guard
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = 'admin')
    {
        return $next($request);
    }
}
