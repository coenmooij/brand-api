<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Connections\Twitter;

use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;
use CoenMooij\BrandApi\Domain\Twitter\TwitterAccountStatistics;
use Thujohn\Twitter\Facades\Twitter;

final class TwitterService implements TwitterServiceInterface
{
    private const ACCESS_TOKEN_KEY = 'token';
    private const ACCESS_TOKEN_SECRET_KEY = 'secret';
    private const CONSUMER_KEY_KEY = 'consumer_key';
    private const CONSUMER_SECRET_KEY = 'consumer_secret';
    private const USERNAME_KEY = 'screen_name';
    private const FOLLOWER_COUNT_KEY = 'followers_count';
    private const STATUSES_COUNT_KEY = 'statuses_count';
    private const FRIENDS_COUNT_KEY = 'friends_count';
    private const LISTED_COUNT_KEY = 'listed_count';
    private const AVATAR_KEY = 'profile_image_url';

    public function getCredentials(TwitterAccount $twitterAccount): string
    {
        $this->configure($twitterAccount);

        $credentials = Twitter::getCredentials();

        return $credentials->{self::USERNAME_KEY};
    }

    private function configure(TwitterAccount $twitterAccount): void
    {
        Twitter::reconfigure(
            [
                self::ACCESS_TOKEN_KEY => $twitterAccount->{TwitterAccount::ACCESS_TOKEN},
                self::ACCESS_TOKEN_SECRET_KEY => $twitterAccount->{TwitterAccount::ACCESS_TOKEN_SECRET},
                self::CONSUMER_KEY_KEY => $twitterAccount->{TwitterAccount::CONSUMER_KEY},
                self::CONSUMER_SECRET_KEY => $twitterAccount->{TwitterAccount::CONSUMER_SECRET},
            ]
        );
    }

    public function getAccountStatistics(TwitterAccount $twitterAccount): TwitterAccountStatistics
    {
        $this->configure($twitterAccount);

        $credentials = Twitter::getCredentials();

        return new TwitterAccountStatistics(
            $twitterAccount->{TwitterAccount::ID},
            $credentials->{self::FOLLOWER_COUNT_KEY},
            $credentials->{self::STATUSES_COUNT_KEY},
            $credentials->{self::FRIENDS_COUNT_KEY},
            $credentials->{self::LISTED_COUNT_KEY},
            $credentials->{self::AVATAR_KEY}
        );
    }
}
