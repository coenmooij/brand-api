<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Application\Twitter;

use CoenMooij\BrandApi\Application\AbstractController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class TweetController extends AbstractController
{
    private const TWEETS_KEY = 'tweets';
    private const TWEET_KEY = 'tweet';

    public function getAll(): JsonResponse
    {
        $tweets = []; // TODO : implement

        return self::createResponse(Response::HTTP_OK, [self::TWEETS_KEY => $tweets]);
    }

    public function getOne(int $id): JsonResponse
    {
        $tweet = []; // TODO : implement

        return self::createResponse(Response::HTTP_OK, [self::TWEET_KEY => $tweet]);
    }

    public function getAllByAccountId(int $id): JsonResponse
    {
        $tweets = []; // TODO : implement

        return self::createResponse(Response::HTTP_OK, [self::TWEETS_KEY => $tweets]);
    }
}
