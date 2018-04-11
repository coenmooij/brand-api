<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Application\Twitter;

use CoenMooij\BrandApi\Application\AbstractController;

use CoenMooij\BrandApi\Domain\Twitter\TweetStatisticsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class TweetStatisticsController extends AbstractController
{
    private const STATISTICS_KEY = 'statistics';

    /**
     * @var TweetStatisticsServiceInterface
     */
    private $tweetStatisticsService;

    public function __construct(TweetStatisticsServiceInterface $tweetStatisticsService)
    {
        $this->tweetStatisticsService = $tweetStatisticsService;
    }

    public function getByTweetId(string $id): JsonResponse
    {
        $statistics = $this->tweetStatisticsService->getByTweetId($id);

        return self::createResponse(Response::HTTP_OK, [self::STATISTICS_KEY => $statistics]);
    }
}
