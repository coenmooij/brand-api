<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\User;

interface LoggedInUserServiceInterface
{
    public function getLoggedInUser(): User;
}
