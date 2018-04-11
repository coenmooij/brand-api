<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

interface TweetServiceInterface
{
    /**
     * @return Tweet[]|array
     */
    public function getAll(): array;

    /**
     * @return Tweet[]|array
     */
    public function getAllByAccountId(int $accountId): array;

    public function getOne(string $tweetId): Tweet;
}
