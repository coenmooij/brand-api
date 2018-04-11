<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Connections\Twitter;

use CoenMooij\BrandApi\Domain\Twitter\Tweet;
use CoenMooij\BrandApi\Domain\Twitter\TweetStatistics;
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
    private const TEXT_KEY = 'text';
    private const COUNT_KEY = 'count';
    private const TWEET_ID_KEY = 'id_str';
    private const RETWEETER_ID_LIST_KEY = 'ids';
    private const ID_KEY = 'id';
    private const USER_ID_KEY = 'user_id';
    private const RETWEETED_KEY = 'retweeted';
    private const USER_KEY = 'user';

    private const LATEST_TWEET_COUNT = 10;

    public function getCredentials(TwitterAccount $twitterAccount): string
    {
        $this->configure($twitterAccount);

        $credentials = Twitter::getCredentials();

        return $credentials->{self::USERNAME_KEY};
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

    public function getTweet(TwitterAccount $account, string $tweetId): Tweet
    {
        $this->configure($account);

        $rawTweet = Twitter::getTweet($tweetId);

        return new Tweet($tweetId, $rawTweet->{self::TEXT_KEY});
    }

    /**
     * @return Tweet[]|array
     */
    public function getLatestTweets(TwitterAccount $account): array
    {
        $this->configure($account);

        $rawTweets = Twitter::getUserTimeline(
            [
                self::USERNAME_KEY => $account->getUsername(),
                self::COUNT_KEY => self::LATEST_TWEET_COUNT
            ]
        );

        $tweets = [];
        foreach ($rawTweets as $rawTweet) {
            $tweets[] = new Tweet(
                $rawTweet->{self::TWEET_ID_KEY},
                $rawTweet->{self::TEXT_KEY}
            );
        }

        return $tweets;
    }

    public function getTweetStatistics(TwitterAccount $account, string $tweetId): TweetStatistics
    {
        $this->configure($account);

        $rawTweet = Twitter::getTweet($tweetId);
        $ownFollowers = $rawTweet->{self::USER_KEY}->{self::FOLLOWER_COUNT_KEY};

        if (!$rawTweet->{self::RETWEETED_KEY}) {
            return new TweetStatistics($tweetId, $ownFollowers);
        }
        $retweeterIdList = Twitter::getRters([self::ID_KEY => $tweetId])->{self::RETWEETER_ID_LIST_KEY};

        if (empty($retweeterIdList)) {
            return new TweetStatistics($tweetId, $ownFollowers);
        }

        $retweetUserList = Twitter::getUsersLookup([self::USER_ID_KEY => $retweeterIdList]);
        $retweetUsersFollowers = $this->sumFollowers($retweetUserList);
        $reach = $ownFollowers + $retweetUsersFollowers;

        return new TweetStatistics($tweetId, $reach);
    }

    private function sumFollowers(array $users): int
    {
        $followers = 0;
        foreach ($users as $user) {
            $followers += $user->{self::FOLLOWER_COUNT_KEY};
        }

        return $followers;
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
