<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Persistence;

use CoenMooij\BrandApi\Domain\Twitter\TwitterAccountStatistics;

interface TwitterAccountStatisticsRepositoryInterface
{
    public function getByAccountId(int $accountId): TwitterAccountStatistics;
}
