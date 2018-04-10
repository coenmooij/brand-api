<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Providers;

use CoenMooij\BrandApi\Domain\Authentication\AuthenticationService;
use CoenMooij\BrandApi\Domain\Authentication\AuthenticationServiceInterface;
use Illuminate\Support\ServiceProvider;

final class DependencyInjectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthenticationServiceInterface::class, AuthenticationService::class);
    }
}
