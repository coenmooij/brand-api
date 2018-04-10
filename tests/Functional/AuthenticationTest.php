<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Tests\Functional;

use CoenMooij\BrandApi\Tests\AbstractFunctionalTest;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;

final class AuthenticationTest extends AbstractFunctionalTest
{
    private const METHOD_POST = 'POST';
    private const METHOD_GET = 'GET';

    private const LOGIN_ENDPOINT = '/authentication/login';
    private const REGISTER_ENDPOINT = '/authentication/register';
    private const LOGOUT_ENDPOINT = '/authentication/logout';

    private const EMAIL_KEY = 'email';
    private const PASSWORD_KEY = 'password';
    private const FIRST_NAME_KEY = 'firstName';
    private const LAST_NAME_KEY = 'lastName';
    private const TOKEN_KEY = 'token';
    private const USER_KEY = 'user';

    private const VALID_EMAIL = 'coenmooij@gmail.com';
    private const INVALID_EMAIL = 'invalid@email.com';
    private const VALID_PASSWORD = 'test123';
    private const INVALID_PASSWORD = 'invalid';
    private const FIRST_NAME = 'John';
    private const LAST_NAME = 'Doe';

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
    }

    /**
     * @test
     */
    public function login_success(): void
    {
        $response = $this->login(self::VALID_EMAIL, self::VALID_PASSWORD);
        $response->assertStatus(Response::HTTP_OK);
        $data = $response->json();

        $this->assertTrue(is_string($data['data']['token']));
    }

    /**
     * @test
     */
    public function login_invalidEmail(): void
    {
        $response = $this->login(self::INVALID_EMAIL, self::VALID_PASSWORD);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function login_invalidPassword(): void
    {
        $response = $this->login(self::VALID_EMAIL, self::INVALID_PASSWORD);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function logout_success(): void
    {
        $response = $this->login(self::VALID_EMAIL, self::VALID_PASSWORD);
        $token = $response->json('data')['token'];
        $response = $this->logout($token);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function logout_notLoggedIn(): void
    {
        $response = $this->logout();

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     */
    public function register_success(): void
    {
        $response = $this->register(self::INVALID_EMAIL, self::VALID_PASSWORD, self::FIRST_NAME, self::LAST_NAME);
        $response->assertStatus(Response::HTTP_CREATED);
        $data = $response->json()['data'];

        $this->assertEquals(self::FIRST_NAME . ' ' . self::LAST_NAME, $data[self::USER_KEY]['full_name']);
        $this->assertEquals(self::INVALID_EMAIL, $data[self::USER_KEY][self::EMAIL_KEY]);
    }

    /**
     * @test
     */
    public function register_emailExists(): void
    {
        $response = $this->register(self::VALID_EMAIL, self::VALID_PASSWORD, self::FIRST_NAME, self::LAST_NAME);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    private function register(string $email, string $password, string $firstName, string $lastName): TestResponse
    {
        return $this->json(
            self::METHOD_POST,
            self::REGISTER_ENDPOINT,
            [
                self::EMAIL_KEY => $email,
                self::PASSWORD_KEY => $password,
                self::FIRST_NAME_KEY => $firstName,
                self::LAST_NAME_KEY => $lastName,
            ]
        );
    }

    private function login(string $email, string $password): TestResponse
    {
        return $this->json(
            self::METHOD_POST,
            self::LOGIN_ENDPOINT,
            [self::EMAIL_KEY => $email, self::PASSWORD_KEY => $password]
        );
    }

    private function logout(string $token = ''): TestResponse
    {
        return $this->json(self::METHOD_GET, self::LOGOUT_ENDPOINT, [], [self::TOKEN_KEY => $token]);
    }
}
