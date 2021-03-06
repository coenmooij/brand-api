<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Application\Authentication;

use CoenMooij\BrandApi\Application\AbstractController;
use CoenMooij\BrandApi\Domain\Authentication\AuthenticationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class AuthenticationController extends AbstractController
{
    private const LOGIN_SUCCESS = 'Login successful';
    private const LOGOUT_SUCCESS = 'Logout successful';
    private const REGISTER_SUCCESS = 'Successfully registered';

    private const EMAIL_KEY = 'email';
    private const PASSWORD_KEY = 'password';
    private const FIRST_NAME_KEY = 'firstName';
    private const LAST_NAME_KEY = 'lastName';
    private const TOKEN_KEY = 'token';
    private const USER_KEY = 'user';

    private const LOGIN_VALIDATION_RULES = [
        self::EMAIL_KEY => 'required|email|max:255',
        self::PASSWORD_KEY => 'required|max:255',
    ];

    private const REGISTER_RULES = [
        self::EMAIL_KEY => 'required|email|max:255',
        self::PASSWORD_KEY => 'required|max:255',
        self::FIRST_NAME_KEY => 'required|max:255',
        self::LAST_NAME_KEY => 'required|max:255',
    ];

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function login(Request $request): JsonResponse
    {
        $this->validate($request, self::LOGIN_VALIDATION_RULES);

        $token = $this->authenticationService->login(
            $request->request->get(self::EMAIL_KEY),
            $request->request->get(self::PASSWORD_KEY)
        );

        return self::createResponse(Response::HTTP_OK, [self::TOKEN_KEY => $token], self::LOGIN_SUCCESS);
    }

    public function register(Request $request): JsonResponse
    {
        $this->validate($request, self::REGISTER_RULES);

        $user = $this->authenticationService->register(
            $request->request->get(self::EMAIL_KEY),
            $request->request->get(self::PASSWORD_KEY),
            $request->request->get(self::FIRST_NAME_KEY),
            $request->request->get(self::LAST_NAME_KEY)
        );

        return self::createResponse(Response::HTTP_CREATED, [self::USER_KEY => $user], self::REGISTER_SUCCESS);
    }

    public function logout(): JsonResponse
    {
        $this->authenticationService->logout();

        return self::createResponse(Response::HTTP_OK, null, self::LOGOUT_SUCCESS);
    }
}
