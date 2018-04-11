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

    /**
     * @var TwitterAccountServiceInterface
     */
    private $twitterAccountService;

    public function __construct(
        AuthorizationServiceInterface $authorizationService,
        TwitterAccountStatisticsRepositoryInterface $twitterAccountStatisticsRepository,
        TwitterAccountServiceInterface $twitterAccountService
    ) {
        $this->authorizationService = $authorizationService;
        $this->twitterAccountStatisticsRepository = $twitterAccountStatisticsRepository;
        $this->twitterAccountService = $twitterAccountService;
    }

    public function getByAccountId(int $accountId): TwitterAccountStatistics
    {
        $account = $this->twitterAccountService->getOne($accountId);
        $this->authorizationService->ensureCanAccessTwitterAccount($account);

        return $this->twitterAccountStatisticsRepository->getByAccountId($accountId);
    }
}
