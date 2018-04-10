<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Connections\Twitter;

use CoenMooij\BrandApi\Domain\Twitter\TwitterAccount;
use Thujohn\Twitter\Facades\Twitter;

final class TwitterService implements TwitterServiceInterface
{
    private const ACCESS_TOKEN_KEY = 'token';
    private const ACCESS_TOKEN_SECRET_KEY = 'secret';
    private const CONSUMER_KEY_KEY = 'consumer_key';
    private const CONSUMER_SECRET_KEY = 'consumer_secret';
    private const USERNAME_KEY = 'screen_name';

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
}
