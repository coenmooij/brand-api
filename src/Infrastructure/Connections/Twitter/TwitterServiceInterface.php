<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Connections\Twitter;

use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccountStatistics;

interface TwitterServiceInterface
{
    public function getCredentials(TwitterAccount $twitterAccount): string;

    public function getAccountStatistics(TwitterAccount $twitterAccount): TwitterAccountStatistics;
}
