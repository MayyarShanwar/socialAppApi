<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role == 'admin')
            return $next($request);
        else {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to do this action'
            ], 403);
        }
    }
}
