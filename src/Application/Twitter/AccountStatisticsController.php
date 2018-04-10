<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Application\Twitter;

use CoenMooij\BrandApi\Application\AbstractController;

use CoenMooij\BrandApi\Domain\Twitter\TwitterAccountStatisticsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class AccountStatisticsController extends AbstractController
{
    private const STATISTICS_RESPONSE_KEY = 'statistics';

    /**
     * @var TwitterAccountStatisticsServiceInterface
     */
    private $statisticsService;

    public function __construct(TwitterAccountStatisticsServiceInterface $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function getByAccountId(int $id): JsonResponse
    {
        $statistics = $this->statisticsService->getByAccountId($id);

        return self::createResponse(Response::HTTP_OK, [self::STATISTICS_RESPONSE_KEY => $statistics]);
    }
}
