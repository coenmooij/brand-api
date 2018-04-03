<?php

declare(strict_types=1);

namespace App\Service;

use Illuminate\Support\Facades\Redis;
use Thujohn\Twitter\Facades\Twitter;

final class ReachService implements ReachServiceInterface
{
    private const EXPIRATION_TIME_IN_SECONDS = 7200;

    public function getByTweet(string $tweetId): int
    {
        return $this->getReachFromCache($tweetId) ?? $this->calculateAndCacheReach($tweetId);
    }

    private function getReachFromCache(string $tweetId): ?int
    {
        $reach = Redis::get($tweetId);

        return $reach ? (int) $reach : null;
    }

    private function calculateAndCacheReach(string $tweetId): int
    {
        $retweeterIds = $this->getRetweeters($tweetId);
        $users = $this->getUsers($retweeterIds);
        $reach = $this->sumFollowers($users);

        Redis::set($tweetId, $reach);
        Redis::expire($tweetId, self::EXPIRATION_TIME_IN_SECONDS);

        return $reach;
    }

    private function getRetweeters(string $id): array
    {
        return Twitter::getRters(['id' => $id])->ids;
    }

    private function getUsers(array $ids): array
    {
        return Twitter::getUsersLookup(['user_id' => $ids]);
    }

    private function sumFollowers(array $users): int
    {
        $reach = 0;
        foreach ($users as $user) {
            $reach += $user->followers_count;
        }

        return $reach;
    }
}
