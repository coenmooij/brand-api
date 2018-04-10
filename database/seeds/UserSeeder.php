<?php

declare(strict_types=1);

use CoenMooij\BrandApi\Domain\Authentication\AuthenticationServiceInterface;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    private const EMAIL = 'coenmooij@gmail.com';
    private const PASSWORD = 'test123';
    private const FIRST_NAME = 'Coen';
    private const LAST_NAME = 'Mooij';

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function run(): void
    {
        $this->authenticationService->register(self::EMAIL, self::PASSWORD, self::FIRST_NAME, self::LAST_NAME);
    }
}
