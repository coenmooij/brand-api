<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Authorization;

use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;
use CoenMooij\BrandApi\Domain\User\LoggedInUserServiceInterface;
use CoenMooij\BrandApi\Domain\User\User;
use Illuminate\Validation\UnauthorizedException;

final class AuthorizationService implements AuthorizationServiceInterface
{
    /**
     * @var LoggedInUserServiceInterface
     */
    private $loggedInUserService;

    public function __construct(LoggedInUserServiceInterface $loggedInUserService)
    {
        $this->loggedInUserService = $loggedInUserService;
    }

    public function ensureCanAccessTwitterAccount(TwitterAccount $twitterAccount): void
    {
        $user = $this->loggedInUserService->getLoggedInUser();

        if ($user->{User::ID} !== $twitterAccount->{TwitterAccount::USER_ID}) {
            throw new UnauthorizedException();
        };
    }
}
