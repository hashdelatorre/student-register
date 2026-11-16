<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class PreventDoubleSubmit
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('post')) {
            $token = $request->input('_once');

            // Cache::add only succeeds for the FIRST request with this token
            if (! $token || ! Cache::add('once:' . $token, true, now()->addHours(2))) {
                return redirect()->back()
                    ->with('error', 'This form was already submitted. Please check the table below.');
            }
        }

        return $next($request);
    }
}
