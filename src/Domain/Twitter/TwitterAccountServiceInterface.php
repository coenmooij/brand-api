<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

use Illuminate\Database\Eloquent\Collection;

interface TwitterAccountServiceInterface
{
    /**
     * @return TwitterAccount[]|Collection
     */
    public function getAll(): Collection;

    public function getOne($id): TwitterAccount;

    public function add(
        string $accessToken,
        string $accessTokenSecret,
        string $consumerKey,
        string $consumerSecret
    ): TwitterAccount;

    public function update(int $id, array $data): TwitterAccount;

    public function delete($id): void;
}
