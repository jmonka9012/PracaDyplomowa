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
        $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;
        
        if ($request->expectsJson()) {
            return response()->json([
                'throttle' => 'Zbyt wiele prób, spróbuj ponownie za '.$retryAfter.' sekund.',
                'retry_after' => $retryAfter
            ], 429, $e->getHeaders());
        }

        
       return response(
        'Zbyt wiele prób, spróbuj ponownie za '.$retryAfter.' sekund.',
        429
        )->withHeaders($e->getHeaders());

        
    }
}
}