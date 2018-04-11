<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Authentication;

use Carbon\Carbon;
use CoenMooij\BrandApi\Domain\User\LoggedInUserServiceInterface;
use CoenMooij\BrandApi\Domain\User\User;
use CoenMooij\BrandApi\Infrastructure\Exceptions\DuplicateRegistrationException;
use CoenMooij\BrandApi\Infrastructure\Exceptions\LoginFailedException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class AuthenticationService implements AuthenticationServiceInterface
{
    /**
     * @var LoggedInUserServiceInterface
     */
    private $loggedInUserService;

    public function __construct(LoggedInUserServiceInterface $loggedInUserService)
    {
        $this->loggedInUserService = $loggedInUserService;
    }

    /**
     * @throws LoginFailedException
     */
    public function login(string $email, string $password): string
    {
        try {
            $user = $this->findUser(User::EMAIL, $email);
        } catch (ModelNotFoundException $exception) {
            throw new LoginFailedException();
        }

        if (!$this->passwordIsValid($password, $user->{User::SALT}, $user->{User::PASSWORD})) {
            throw new LoginFailedException();
        }

        $this->createToken($user);

        return $user->{User::TOKEN};
    }

    public function register(string $email, string $password, string $firstName, string $lastName): User
    {

        if (User::where(User::EMAIL, $email)->first() !== null) {
            throw new DuplicateRegistrationException();
        }

        $user = new User();
        $user->{User::EMAIL} = $email;
        $user->{User::SALT} = $this->createSalt($user->{User::EMAIL});
        $user->{User::PASSWORD} = $this->hashPassword($password, $user->{User::SALT});
        $user->{User::FIRST_NAME} = $firstName;
        $user->{User::LAST_NAME} = $lastName;
        $user->saveOrFail();

        return $user;
    }

    public function logout(): void
    {
        $user = $this->loggedInUserService->getLoggedInUser();
        $user->{User::TOKEN} = null;
        $user->{User::TOKEN_EXPIRES} = null;
        $user->saveOrFail();
    }

    private function findUser($column, $value): User
    {
        return User::where($column, $value)->firstOrFail();
    }

    private function createToken(User $user): User
    {
        $token = bin2hex(random_bytes(64));
        $user->{User::TOKEN} = $token;
        $user->{User::TOKEN_EXPIRES} = Carbon::now()->addHours(1);
        $user->save();

        return $user;
    }

    private function hashPassword(string $password, string $salt): string
    {
        return password_hash($password . $salt . $this->getPepper(), PASSWORD_BCRYPT);
    }

    private function passwordIsValid(string $password, string $salt, string $hash): bool
    {
        return password_verify($password . $salt . $this->getPepper(), $hash);
    }

    private function createSalt(string $prefix): string
    {
        return uniqid($prefix, true);
    }

    private function getPepper(): string
    {
        $pepper = env('PEPPER', '');
        if (empty($pepper)) {
            throw new Exception('Configuration Missing');
        }

        return $pepper;
    }
}
