<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

final class TwitterAccountStatistics implements Arrayable, JsonSerializable
{
    private const FOLLOWER_COUNT = 'follower_count';
    private const TWEET_COUNT = 'tweet_count';
    private const FRIEND_COUNT = 'friend_count';
    private const LISTED_COUNT = 'listed_count';
    private const AVATAR = 'avatar';

    /**
     * @var int
     */
    private $twitterAccountId;

    /**
     * @var int
     */
    private $followerCount;

    /**
     * @var int
     */
    private $statusesCount;

    /**
     * @var int
     */
    private $friendCount;

    /**
     * @var int
     */
    private $listedCount;

    /**
     * @var string
     */
    private $profileImageUrl;

    public function __construct(
        int $twitterAccountId,
        int $followerCount,
        int $statusesCount,
        int $friendsCount,
        int $listedCount,
        string $profileImageUrl
    ) {
        $this->twitterAccountId = $twitterAccountId;
        $this->followerCount = $followerCount;
        $this->statusesCount = $statusesCount;
        $this->friendCount = $friendsCount;
        $this->listedCount = $listedCount;
        $this->profileImageUrl = $profileImageUrl;
    }

    public function getTwitterAccountId(): int
    {
        return $this->twitterAccountId;
    }

    public function toArray(): array
    {
        return [
            self::FOLLOWER_COUNT => $this->followerCount,
            self::TWEET_COUNT => $this->statusesCount,
            self::FRIEND_COUNT => $this->friendCount,
            self::LISTED_COUNT => $this->listedCount,
            self::AVATAR => $this->profileImageUrl,
        ];
    }

    public function serialize(): string
    {
        return json_encode($this->toArray());
    }

    public static function deserialize(int $accountId, string $serialized): self
    {
        $data = json_decode($serialized, true);

        return new self($accountId, ...array_values($data));
    }

  public function jsonSerialize()
    {
        return $this->toArray();
    }
}
