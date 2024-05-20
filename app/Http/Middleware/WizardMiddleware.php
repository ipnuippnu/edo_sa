<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WizardMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->account_type == 1)
        {
            if(auth()->user()->personal->finished_at == null && !in_array($request->route()->getName(), ['wizard', 'wizard.save', 'verify', 'verify.request', 'logout']))
                return redirect()->route('wizard');

            else if(auth()->user()->personal->finished_at != null && in_array($request->route()->getName(), ['wizard', 'wizard.save']))
                return redirect()->route('home');
        }

        else if(auth()->user()->account_type == 1 && in_array($request->route()->getName(), ['wizard', 'wizard.save']))
        {
            abort(404);
        }

        return $next($request);
    }
}
