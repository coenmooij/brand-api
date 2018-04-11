<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Persistence\Twitter;

use CoenMooij\BrandApi\Domain\Twitter\TweetStatistics;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;

interface TweetStatisticsRepositoryInterface
{
    public function getTweetStatistics(TwitterAccount $account, string $tweetId): TweetStatistics;
}
