<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

final class LoggedInUserService implements LoggedInUserServiceInterface
{
    public function getLoggedInUser(): User
    {
        /** @var User $user */
        $user = Auth::user();

        if (is_null($user)) {
            throw new UnauthorizedException();
        }

        return $user;
    }
}
