<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

final class TweetStatistics implements Arrayable, JsonSerializable
{
    private const REACH = 'reach';

    /**
     * @var string
     */
    private $tweetId;
    /**
     * @var int
     */
    private $reach;

    public function __construct(string $tweetId, int $reach)
    {
        $this->tweetId = $tweetId;
        $this->reach = $reach;
    }

    public function getTweetId(): string
    {
        return $this->tweetId;
    }

    public function toArray(): array
    {
        return [
            self::REACH => $this->reach,
        ];
    }

    public function serialize(): string
    {
        return json_encode($this->toArray());
    }

    public static function deserialize(string $tweetId, string $serialized): self
    {
        $data = json_decode($serialized, true);

        return new self($tweetId, $data[0]);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
