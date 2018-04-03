<?php

declare(strict_types=1);

namespace App\Providers;

use App\Service\ReachService;
use App\Service\ReachServiceInterface;
use Illuminate\Support\ServiceProvider;

final class DependencyInjectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ReachServiceInterface::class, ReachService::class);
    }
}
