<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Persistence\Twitter;

use CoenMooij\BrandApi\Domain\Twitter\Tweet;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;

interface TweetRepositoryInterface
{
    /**
     * @return Tweet[]|array
     */
    public function getLatestTweets(TwitterAccount $account): array;

    public function getTweet(TwitterAccount $account, string $tweetId): Tweet;
}
