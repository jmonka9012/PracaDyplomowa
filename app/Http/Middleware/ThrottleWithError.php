<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Inertia\Inertia;

class ThrottleWithError extends ThrottleRequests
{
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        try {
            return parent::handle($request, $next, $maxAttempts, $decayMinutes, $prefix);
        } catch (ThrottleRequestsException $e) {
            if ($request->header('X-Inertia')) {
                $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;
                
                return back()->withErrors([
                    'throttle' => 'Zbyt wiele prób, spróbuj ponownie za'.$retryAfter.' sekund.',
                ])
                ->withHeaders($e->getHeaders())
                ->setStatusCode(429);
            }

            throw $e;
        }
    }
}