<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the request is not secure (HTTP)
        if (!$request->secure()) {
            // Redirect to HTTPS
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
