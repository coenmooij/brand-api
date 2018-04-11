<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Application\Twitter;

use CoenMooij\BrandApi\Application\AbstractController;

use CoenMooij\BrandApi\Domain\Twitter\TweetServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class TweetController extends AbstractController
{
    private const TWEETS_KEY = 'tweets';
    private const TWEET_KEY = 'tweet';

    /**
     * @var TweetServiceInterface
     */
    private $tweetService;

    public function __construct(TweetServiceInterface $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    public function getAll(): JsonResponse
    {
        $tweets = $this->tweetService->getAll();

        return self::createResponse(Response::HTTP_OK, [self::TWEETS_KEY => $tweets]);
    }

    public function getOne(string $id): JsonResponse
    {
        $tweet = $this->tweetService->getOne($id);

        return self::createResponse(Response::HTTP_OK, [self::TWEET_KEY => $tweet]);
    }

    public function getAllByAccountId(int $id): JsonResponse
    {
        $tweets = $this->tweetService->getAllByAccountId($id);

        return self::createResponse(Response::HTTP_OK, [self::TWEETS_KEY => $tweets]);
    }
}
