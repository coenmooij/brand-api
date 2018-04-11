<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

use CoenMooij\BrandApi\Infrastructure\Persistence\Twitter\TweetRepositoryInterface;

final class TweetService implements TweetServiceInterface
{
    /**
     * @var TweetRepositoryInterface
     */
    private $tweetRepository;

    /**
     * @var TwitterAccountServiceInterface
     */
    private $twitterAccountService;

    public function __construct(
        TweetRepositoryInterface $tweetRepository,
        TwitterAccountServiceInterface $twitterAccountService
    ) {
        $this->tweetRepository = $tweetRepository;
        $this->twitterAccountService = $twitterAccountService;
    }

    /**
     * @return Tweet[]|array
     */
    public function getAll(): array
    {
        $tweets = [];

        $accounts = $this->twitterAccountService->getAll();
        foreach ($accounts as $account) {
            array_push($tweets, ...$this->tweetRepository->getLatestTweets($account));
        }

        return $tweets;
    }

    /**
     * @return Tweet[]|array
     */
    public function getAllByAccountId(int $accountId): array
    {
        $account = $this->twitterAccountService->getOne($accountId);

        return $this->tweetRepository->getLatestTweets($account);
    }

    public function getOne(string $tweetId): Tweet
    {
        $account = $this->twitterAccountService->getAll()->first();

        return $this->tweetRepository->getTweet($account, $tweetId);
    }
}
