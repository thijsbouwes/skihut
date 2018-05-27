<?php

namespace App\Http\Middleware;

use App\Exceptions\InvalidAuthorization;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminResource
{
    /**
     * @param         $request
     * @param Closure $next
     * @return mixed
     * @throws InvalidAuthorization
     */
    public function handle($request, Closure $next)
    {
//        dd(Auth::user()->is_admin);
        if (Auth::user()->is_admin === false) {
            throw new InvalidAuthorization();
        }

        return $next($request);
    }
}
