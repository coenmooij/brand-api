<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

interface TwitterAccountStatisticsServiceInterface
{
    public function getByAccountId(int $accountId): TwitterAccountStatistics;
}
