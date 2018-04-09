<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Authentication;

interface AuthenticationServiceInterface
{
    public function login(string $email, string $password): string;

    public function register(string $email, string $password, string $firstName, string $lastName): string;

    public function logout(): void;

    public function resetPassword(string $email): void;
}
