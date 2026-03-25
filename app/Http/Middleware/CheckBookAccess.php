<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBookAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secretKey = $request->header('secret-key');

        if ($secretKey !== 'book-secret-123') {
            return new JsonResponse([
                'message' => 'Unauthorized access. Invalid or missing secret-key header.',
            ], 403);
        }

        return $next($request);
    }
}
