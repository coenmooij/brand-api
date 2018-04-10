<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Domain\Twitter;

use CoenMooij\BrandApi\Domain\Authorization\AuthorizationServiceInterface;
use CoenMooij\BrandApi\Domain\User\LoggedInUserServiceInterface;
use CoenMooij\BrandApi\Domain\User\User;
use CoenMooij\BrandApi\Infrastructure\Connections\Twitter\TwitterServiceInterface;
use Illuminate\Database\Eloquent\Collection;

final class TwitterAccountService implements TwitterAccountServiceInterface
{
    /**
     * @var LoggedInUserServiceInterface
     */
    private $loggedInUserService;

    /**
     * @var AuthorizationServiceInterface
     */
    private $authorizationService;
    /**
     * @var TwitterServiceInterface
     */
    private $twitterService;

    public function __construct(
        LoggedInUserServiceInterface $loggedInUserService,
        AuthorizationServiceInterface $authorizationService,
        TwitterServiceInterface $twitterService
    ) {
        $this->loggedInUserService = $loggedInUserService;
        $this->authorizationService = $authorizationService;
        $this->twitterService = $twitterService;
    }

    /**
     * @return TwitterAccount[]|Collection
     */
    public function getAll(): Collection
    {
        $currentUser = $this->loggedInUserService->getLoggedInUser();

        return TwitterAccount::where(TwitterAccount::USER_ID, $currentUser->{User::ID})->get();
    }

    public function getOne($id): TwitterAccount
    {
        $twitterAccount = $this->getTwitterAccount($id);

        $this->authorizationService->ensureCanAccessTwitterAccount($twitterAccount);

        return $twitterAccount;
    }

    public function add(
        string $accessToken,
        string $accessTokenSecret,
        string $consumerKey,
        string $consumerSecret
    ): TwitterAccount {
        $account = new TwitterAccount();
        $account->{TwitterAccount::USER_ID} = $this->loggedInUserService->getLoggedInUser()->{User::ID};
        $account->{TwitterAccount::ACCESS_TOKEN} = $accessToken;
        $account->{TwitterAccount::ACCESS_TOKEN_SECRET} = $accessTokenSecret;
        $account->{TwitterAccount::CONSUMER_KEY} = $consumerKey;
        $account->{TwitterAccount::CONSUMER_SECRET} = $consumerSecret;

        $username = $this->twitterService->getCredentials($account);

        $account->{TwitterAccount::USERNAME} = $username;
        $account->saveOrFail();

        return $account;
    }

    public function update(int $id, array $data): TwitterAccount
    {
        $twitterAccount = $this->getTwitterAccount($id);
        $this->authorizationService->ensureCanAccessTwitterAccount($twitterAccount);

        foreach ($data as $key => $value) {
            $twitterAccount->{snake_case($key)} = $value;
        }

        $username = $this->twitterService->getCredentials($twitterAccount);

        $twitterAccount->{TwitterAccount::USERNAME} = $username;
        $twitterAccount->saveOrFail();

        return $twitterAccount;
    }

    public function delete($id): void
    {
        $twitterAccount = $this->getTwitterAccount($id);
        $this->authorizationService->ensureCanAccessTwitterAccount($twitterAccount);

        $twitterAccount->delete();
    }

    private function getTwitterAccount(int $id): TwitterAccount
    {
        return TwitterAccount::findOrFail($id);
    }
}
