<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware {
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string {
        return $request->expectsJson() ? null : '';
    }

    public function handle($request, Closure $next, ...$guards) {

        if ($token = $request->cookie('token')) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
            // dd($request->headers);
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}