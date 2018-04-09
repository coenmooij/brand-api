<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    public function map(): void
    {
        Route::middleware('api')->group(base_path('/src/Application/routes.php'));
    }
}
