<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Persistence\Twitter;

use CoenMooij\BrandApi\Domain\Twitter\Tweet;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;
use CoenMooij\BrandApi\Infrastructure\Connections\Twitter\TwitterServiceInterface;
use Illuminate\Support\Facades\Redis;

final class TweetRepository implements TweetRepositoryInterface
{
    private const EXPIRATION_TIME_IN_SECONDS = 900;

    /**
     * @var TwitterServiceInterface
     */
    private $twitterService;

    public function __construct(TwitterServiceInterface $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    /**
     * @return Tweet[]|array
     */
    private static function deserializeAccountTweets(string $serialized): array
    {
        $accounts = json_decode($serialized, true);

        $tweets = [];
        foreach ($accounts as $account) {
            $tweets[] = new Tweet(...array_values($account));
        }

        return $tweets;
    }

    private static function serializeAccountTweets(Tweet ...$tweets): string
    {
        $serializedTweets = [];
        foreach ($tweets as $tweet) {
            $serializedTweets[] = [
                $tweet->getId(),
                $tweet->getText()
            ];
        }

        return json_encode($serializedTweets);
    }

    /**
     * @return Tweet[]|array
     */
    public function getLatestTweets(TwitterAccount $account): array
    {
        $cachedTweets = $this->getAccountTweetsFromCache($account->getId());

        if ($cachedTweets !== null) {
            return self::deserializeAccountTweets($cachedTweets);
        }

        $tweets = $this->twitterService->getLatestTweets($account);
        $this->cacheAccountTweets($account->getId(), $tweets);

        return $tweets;
    }

    public function getTweet(TwitterAccount $account, string $tweetId): Tweet
    {
        $cachedTweet = $this->getTweetFromCache($tweetId);

        if ($cachedTweet !== null) {
            return Tweet::deserialize($cachedTweet);
        }

        $tweet = $this->twitterService->getTweet($account, $tweetId);
        $this->cacheTweet($tweetId, $tweet);

        return $tweet;
    }

    private function getAccountTweetsCacheKey(int $id): string
    {
        return sprintf('account_tweets_%d', $id);
    }

    private function getAccountTweetsFromCache(int $accountId): ?string
    {
        return Redis::get($this->getAccountTweetsCacheKey($accountId));
    }

    private function cacheAccountTweets(int $accountId, array $tweets): void
    {
        $key = $this->getAccountTweetsCacheKey($accountId);
        Redis::set($key, self::serializeAccountTweets(...$tweets));
        Redis::expire($key, self::EXPIRATION_TIME_IN_SECONDS);
    }

    private function getTweetFromCache(string $tweetId): ?string
    {
        return Redis::get($this->getTweetCacheKey($tweetId));
    }

    private function cacheTweet(string $tweetId, Tweet $tweet): void
    {
        $key = $this->getTweetCacheKey($tweetId);
        Redis::set($key, $tweet->serialize());
        Redis::expire($key, self::EXPIRATION_TIME_IN_SECONDS);
    }

    private function getTweetCacheKey(string $tweetId): string
    {
        return sprintf('tweet_%s', $tweetId);
    }
}
