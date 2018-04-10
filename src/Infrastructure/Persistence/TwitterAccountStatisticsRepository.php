<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Persistence;

use CoenMooij\BrandApi\Domain\Twitter\TwitterAccountServiceInterface;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccountStatistics;
use CoenMooij\BrandApi\Infrastructure\Connections\Twitter\TwitterServiceInterface;
use Illuminate\Support\Facades\Redis;

final class TwitterAccountStatisticsRepository implements TwitterAccountStatisticsRepositoryInterface
{
    private const EXPIRATION_TIME_IN_SECONDS = 900;

    /**
     * @var TwitterServiceInterface
     */
    private $twitterService;

    /**
     * @var TwitterAccountServiceInterface
     */
    private $twitterAccountService;

    public function __construct(
        TwitterServiceInterface $twitterService,
        TwitterAccountServiceInterface $twitterAccountService
    ) {
        $this->twitterService = $twitterService;
        $this->twitterAccountService = $twitterAccountService;
    }

    public function getByAccountId(int $accountId): TwitterAccountStatistics
    {
        $rawStatistics = $this->getFromCache($accountId);

        if ($rawStatistics !== null) {
            return TwitterAccountStatistics::deserialize($accountId, $rawStatistics);
        }

        $twitterAccount = $this->twitterAccountService->getOne($accountId);
        $statistics = $this->twitterService->getAccountStatistics($twitterAccount);
        $this->cache($accountId, $statistics);

        return $statistics;
    }

    private function getCacheKey(int $id): string
    {
        return sprintf('twitter_account_statistics_%d', $id);
    }

    private function getFromCache(int $accountId): ?string
    {
        return Redis::get($this->getCacheKey($accountId));
    }

    private function cache(int $accountId, TwitterAccountStatistics $statistics): void
    {
        $key = $this->getCacheKey($accountId);
        Redis::set($key, $statistics->serialize());
        Redis::expire($key, self::EXPIRATION_TIME_IN_SECONDS);
    }
}
