<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\User;

use Illuminate\Support\Facades\Auth;

final class LoggedInUserService implements LoggedInUserServiceInterface
{
    public function getLoggedInUser(): User
    {
        return Auth::user();
    }
}
