<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class HasPowerlevel
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $powerlevel
     * @return mixed
     */
    public function handle($request, Closure $next, string $powerlevel = "1") {
        $powerlevel = (int)$powerlevel;
        $role = Auth::user()->role;

        if (!$role)
            abort(401);

        if ((int)$role->powerlevel < $powerlevel)
            abort(401);

        return $next($request);
    }

}
