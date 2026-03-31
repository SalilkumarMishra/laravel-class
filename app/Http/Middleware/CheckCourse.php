<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCourse
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->course === 'laravel') {
            return $next($request);
        }

        return response('Unauthorized - Course not allowed', 403);
    }
}