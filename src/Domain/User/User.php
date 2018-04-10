<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\User;

use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class User extends Model implements Authenticatable
{
    public const ID = 'id';
    public const EMAIL = 'email';
    public const PASSWORD = 'password';
    public const SALT = 'salt';
    public const FIRST_NAME = 'first_name';
    public const LAST_NAME = 'last_name';
    public const TOKEN = 'token';
    public const TOKEN_EXPIRES = 'token_expires';
    public const FULL_NAME = 'full_name';

    protected $guarded = [
        self::ID,
    ];

    protected $hidden = [
        self::PASSWORD,
        self::SALT,
        self::TOKEN,
    ];

    protected $appends = [
        self::FULL_NAME,
    ];

    public function getFullNameAttribute(): string
    {
        return $this->{self::FIRST_NAME} . ' ' . $this->{self::LAST_NAME};
    }

    public function twitterAccounts(): HasMany
    {
        return $this->hasMany(TwitterAccount::class, 'user_id');
    }

    /**
     * Add these so we can use the Auth Facade
     */
    public function getAuthIdentifierName(): string
    {
        return self::ID;
    }

    public function getAuthIdentifier(): int
    {
        return $this->{self::ID};
    }

    public function getAuthPassword(): string
    {
        return '';
    }

    public function getRememberToken(): string
    {
        return '';
    }

    public function setRememberToken($value): void
    {
    }

    public function getRememberTokenName()
    {
        return self::TOKEN;
    }
}
