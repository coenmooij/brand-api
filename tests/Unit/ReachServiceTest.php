<?php

namespace Tests\Unit;

use App\Service\ReachService;
use App\Service\ReachServiceInterface;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Thujohn\Twitter\Facades\Twitter;

final class ReachServiceTest extends TestCase
{
    private const TWEET_ID = '12345678901234567890';
    private const REACH = 25;
    private const RETWEETERS = [1, 2, 3];
    private const EXPIRATION_TIME = 7200;
    private const USERS_FOLLOWERS_COUNT = [3, 5, 13, 16, 594];

    /**
     * @var ReachServiceInterface
     */
    private $reachService;

    public function setUp(): void
    {
        $this->reachService = new ReachService();
        Redis::shouldReceive('get')->once()->with(self::TWEET_ID)->andReturn(null);
        Twitter::shouldReceive('getRters')->once()->with(['id' => self::TWEET_ID])->andReturn(
            (object) ['ids' => self::RETWEETERS]
        );

        $users = [];
        foreach (self::USERS_FOLLOWERS_COUNT as $count) {
            $users[] = (object) ['followers_count' => $count];
        }

        Twitter::shouldReceive('getUsersLookup')->once()->with(['user_id' => self::RETWEETERS])->andReturn($users);

        Redis::shouldReceive('set')->once()->with(self::TWEET_ID, array_sum(self::USERS_FOLLOWERS_COUNT));
        Redis::shouldReceive('expire')->once()->with(self::TWEET_ID, self::EXPIRATION_TIME);

        Redis::shouldReceive('get')->once()->with(self::TWEET_ID)->andReturn((string) self::REACH);
    }

    /**
     * @test
     */
    public function getByTweet(): void
    {
        $reach = $this->reachService->getByTweet(self::TWEET_ID);
        $this->assertEquals(array_sum(self::USERS_FOLLOWERS_COUNT), $reach);

        $reach = $this->reachService->getByTweet(self::TWEET_ID);
        $this->assertEquals(self::REACH, $reach);
    }
}
