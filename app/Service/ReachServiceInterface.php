<?php

declare(strict_types=1);

namespace App\Service;

interface ReachServiceInterface
{
    public function getByTweet(string $tweetId): int;
}
