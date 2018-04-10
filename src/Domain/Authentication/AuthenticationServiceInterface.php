<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Authentication;

use CoenMooij\BrandApi\Domain\User\User;

interface AuthenticationServiceInterface
{
    public function login(string $email, string $password): string;

    public function register(string $email, string $password, string $firstName, string $lastName): User;

    public function logout(): void;
}
