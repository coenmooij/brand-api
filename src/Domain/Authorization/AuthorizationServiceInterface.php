<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Authorization;

use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;

interface AuthorizationServiceInterface
{
    public function ensureCanAccessTwitterAccount(TwitterAccount $twitterAccount): void;
}
