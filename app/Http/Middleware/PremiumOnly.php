<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PremiumOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasActivePremium()) {
            return response()->json([
                'message' => 'Prístup je povolený len používateľom s prémiom.',
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
