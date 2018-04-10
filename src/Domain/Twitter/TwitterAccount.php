<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

use CoenMooij\BrandApi\Domain\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TwitterAccount extends Model
{
    public const ID = 'id';
    public const USER_ID = 'user_id';
    public const USERNAME = 'username';
    public const ACCESS_TOKEN = 'access_token';
    public const ACCESS_TOKEN_SECRET = 'access_token_secret';
    public const CONSUMER_KEY = 'consumer_key';
    public const CONSUMER_SECRET = 'consumer_secret';

    protected $hidden = [
        self::ACCESS_TOKEN,
        self::ACCESS_TOKEN_SECRET,
        self::CONSUMER_KEY,
        self::CONSUMER_SECRET,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
