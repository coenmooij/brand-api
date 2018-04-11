<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Persistence\Twitter;

use CoenMooij\BrandApi\Domain\Twitter\TweetStatistics;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;
use CoenMooij\BrandApi\Infrastructure\Connections\Twitter\TwitterServiceInterface;
use Illuminate\Support\Facades\Redis;

final class TweetStatisticsRepository implements TweetStatisticsRepositoryInterface
{
    const EXPIRATION_TIME_IN_SECONDS = 7200;
    /**
     * @var TwitterServiceInterface
     */
    private $twitterService;

    public function __construct(TwitterServiceInterface $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    public function getTweetStatistics(TwitterAccount $account, string $tweetId): TweetStatistics
    {
        $rawStatistics = $this->getFromCache($tweetId);

        if ($rawStatistics !== null) {
            return TweetStatistics::deserialize($tweetId, $rawStatistics);
        }

        $statistics = $this->twitterService->getTweetStatistics($account, $tweetId);
        $this->cache($tweetId, $statistics);

        return $statistics;
    }

    private function getCacheKey(string $id): string
    {
        return sprintf('tweet_statistics_%s', $id);
    }

    private function getFromCache(string $tweetId): ?string
    {
        return Redis::get($this->getCacheKey($tweetId));
    }

    private function cache(string $tweetId, TweetStatistics $statistics): void
    {
        $key = $this->getCacheKey($tweetId);
        Redis::set($key, $statistics->serialize());
        Redis::expire($key, self::EXPIRATION_TIME_IN_SECONDS);
    }
}
