<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Connections\Twitter;

use CoenMooij\BrandApi\Domain\Twitter\Tweet;
use CoenMooij\BrandApi\Domain\Twitter\TweetStatistics;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccountStatistics;

interface TwitterServiceInterface
{
    public function getCredentials(TwitterAccount $twitterAccount): string;

    public function getAccountStatistics(TwitterAccount $twitterAccount): TwitterAccountStatistics;

    public function getTweet(TwitterAccount $account, string $tweetId): Tweet;

    /**
     * @return Tweet[]|array
     */
    public function getLatestTweets(TwitterAccount $account): array;

    public function getTweetStatistics(TwitterAccount $account, string $tweetId): TweetStatistics;
}
