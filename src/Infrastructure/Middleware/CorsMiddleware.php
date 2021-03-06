<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Middleware;

use Closure;
use Illuminate\Http\Request;

final class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Credentials', true)
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->header(
                'Access-Control-Allow-Headers',
                'Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control'
            );
    }
}