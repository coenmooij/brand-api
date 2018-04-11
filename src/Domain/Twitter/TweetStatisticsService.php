<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

use CoenMooij\BrandApi\Infrastructure\Persistence\Twitter\TweetStatisticsRepositoryInterface;

final class TweetStatisticsService implements TweetStatisticsServiceInterface
{
    /**
     * @var TwitterAccountServiceInterface
     */
    private $twitterAccountService;

    /**
     * @var TweetStatisticsRepositoryInterface
     */
    private $statisticsRepository;

    public function __construct(
        TwitterAccountServiceInterface $twitterAccountService,
        TweetStatisticsRepositoryInterface $statisticsRepository
    ) {
        $this->twitterAccountService = $twitterAccountService;
        $this->statisticsRepository = $statisticsRepository;
    }

    public function getByTweetId(string $tweetId): TweetStatistics
    {
        $account = $this->twitterAccountService->getAll()->first();

        return $this->statisticsRepository->getTweetStatistics($account, $tweetId);
    }
}
