<?php

namespace App\Http\Middleware;

use Closure;

class PremiumMiddleware
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
        if ($request->user() && ! $request->user()->subscribed('Premium membership'))
        {
            return redirect('billing');
        }
        return $next($request);
    }
}
