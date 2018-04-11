<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

use CoenMooij\BrandApi\Domain\Authorization\AuthorizationServiceInterface;
use CoenMooij\BrandApi\Infrastructure\Persistence\Twitter\TwitterAccountStatisticsRepositoryInterface;

final class TwitterAccountStatisticsService implements TwitterAccountStatisticsServiceInterface
{
    /**
     * @var AuthorizationServiceInterface
     */
    private $authorizationService;

    /**
     * @var TwitterAccountStatisticsRepositoryInterface
     */
    private $twitterAccountStatisticsRepository;

    public function __construct(
        AuthorizationServiceInterface $authorizationService,
        TwitterAccountStatisticsRepositoryInterface $twitterAccountStatisticsRepository
    ) {
        $this->authorizationService = $authorizationService;
        $this->twitterAccountStatisticsRepository = $twitterAccountStatisticsRepository;
    }

    public function getByAccountId($id): TwitterAccountStatistics
    {
        $account = TwitterAccount::findOrFail($id);
        $this->authorizationService->ensureCanAccessTwitterAccount($account);

        return $this->twitterAccountStatisticsRepository->getByAccountId($id);
    }
}
