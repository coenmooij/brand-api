<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

interface TweetStatisticsServiceInterface
{
    public function getByTweetId(string $tweetId): TweetStatistics;
}
