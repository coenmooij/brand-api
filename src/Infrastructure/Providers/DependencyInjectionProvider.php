<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Providers;

use CoenMooij\BrandApi\Domain\Authentication\AuthenticationService;
use CoenMooij\BrandApi\Domain\Authentication\AuthenticationServiceInterface;
use CoenMooij\BrandApi\Domain\Authorization\AuthorizationService;
use CoenMooij\BrandApi\Domain\Authorization\AuthorizationServiceInterface;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccountService;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccountServiceInterface;
use CoenMooij\BrandApi\Domain\User\LoggedInUserService;
use CoenMooij\BrandApi\Domain\User\LoggedInUserServiceInterface;
use CoenMooij\BrandApi\Infrastructure\Connections\Twitter\TwitterService;
use CoenMooij\BrandApi\Infrastructure\Connections\Twitter\TwitterServiceInterface;
use Illuminate\Support\ServiceProvider;

final class DependencyInjectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AuthenticationServiceInterface::class, AuthenticationService::class);
        $this->app->bind(TwitterAccountServiceInterface::class, TwitterAccountService::class);
        $this->app->bind(LoggedInUserServiceInterface::class, LoggedInUserService::class);
        $this->app->bind(AuthorizationServiceInterface::class, AuthorizationService::class);
        $this->app->bind(TwitterServiceInterface::class, TwitterService::class);
    }
}
