<?php

namespace App\Http\Middleware;

use Closure;

class InjectClientSecretToRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Validate if the request is a password grant
        if ($request->get('grant_type') === 'password') {
            // Then adding the client secret so its not publicly visible
            $request->request->add([
                'client_id' => config('auth.api.client_id'),
                'client_secret' => config('auth.api.client_secret')
            ]);
        }

        return $next($request);
    }
}
