<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Application\Twitter;

use CoenMooij\BrandApi\Application\AbstractController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class TweetStatisticsController extends AbstractController
{
    private const STATISTICS_KEY = 'statistics';

    public function getByAccountId(int $id): JsonResponse
    {
        $statistics = []; // TODO : implement

        return self::createResponse(Response::HTTP_OK, [self::STATISTICS_KEY => $statistics]);
    }
}
