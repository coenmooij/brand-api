<?php

namespace CoenMooij\BrandApi\Infrastructure\Http;

use CoenMooij\BrandApi\CoenMooij\BrandApi\Infrastructure\Middleware\AuthenticationMiddleware;
use CoenMooij\BrandApi\Infrastructure\Middleware\CorsMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

final class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     * These middleware are run during every request to your application.
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \CoenMooij\BrandApi\Infrastructure\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \CoenMooij\BrandApi\Infrastructure\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     * @var array
     */
    protected $middlewareGroups = [
        'api' => [
            'throttle:60,1',
            'bindings',
            CorsMiddleware::class,
        ],
        'auth' => [
            AuthenticationMiddleware::class,
        ]
    ];

    /**
     * The application's route middleware.
     * These middleware may be assigned to groups or used individually.
     * @var array
     */
    protected $routeMiddleware = [
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
