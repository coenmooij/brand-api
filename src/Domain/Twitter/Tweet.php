<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

final class Tweet implements Arrayable, JsonSerializable
{
    private const ID_KEY = 'id';
    private const TEXT_KEY = 'text';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    public function __construct(string $id, string $text)
    {
        $this->id = $id;
        $this->text = $text;
    }

    public static function deserialize(string $serialized): self
    {
        $data = json_decode($serialized, true);

        return new self(...array_values($data));
    }

    public function serialize(): string
    {
        return json_encode($this->toArray());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function toArray(): array
    {
        return [
            self::ID_KEY => $this->id,
            self::TEXT_KEY => $this->text,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
