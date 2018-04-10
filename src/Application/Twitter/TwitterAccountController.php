<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Application\Twitter;

use CoenMooij\BrandApi\Application\AbstractController;

use CoenMooij\BrandApi\Domain\Twitter\TwitterAccountServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class TwitterAccountController extends AbstractController
{
    private const ACCESS_TOKEN_KEY = 'accessToken';
    private const ACCESS_TOKEN_SECRET_KEY = 'accessTokenSecret';
    private const CONSUMER_KEY_KEY = 'consumerKey';
    private const CONSUMER_SECRET_KEY = 'consumerSecret';

    private const ACCOUNTS_RESPONSE_KEY = 'accounts';
    private const ACCOUNT_RESPONSE_KEY = 'account';

    private const TWITTER_ACCOUNT_DELETED_MESSAGE = 'Twitter account successfully deleted';

    private const POST_RULES = [
        self::ACCESS_TOKEN_KEY => 'required|max:255',
        self::ACCESS_TOKEN_SECRET_KEY => 'required|max:255',
        self::CONSUMER_KEY_KEY => 'required|max:255',
        self::CONSUMER_SECRET_KEY => 'required|max:255',
    ];

    private const PATCH_RULES = [
        self::ACCESS_TOKEN_KEY => 'max:255',
        self::ACCESS_TOKEN_SECRET_KEY => 'max:255',
        self::CONSUMER_KEY_KEY => 'max:255',
        self::CONSUMER_SECRET_KEY => 'max:255',
    ];

    /**
     * @var TwitterAccountServiceInterface
     */
    private $twitterAccountService;

    public function __construct(TwitterAccountServiceInterface $twitterAccountService)
    {
        $this->twitterAccountService = $twitterAccountService;
    }

    public function getAll(): JsonResponse
    {
        $accounts = $this->twitterAccountService->getAll();

        return self::createResponse(Response::HTTP_OK, [self::ACCOUNTS_RESPONSE_KEY => $accounts]);
    }

    public function getOne(int $id): JsonResponse
    {
        $account = $this->twitterAccountService->getOne($id);

        return self::createResponse(Response::HTTP_OK, [self::ACCOUNT_RESPONSE_KEY => $account]);
    }

    public function post(Request $request): JsonResponse
    {
        $this->validate($request, self::POST_RULES);
        $account = $this->twitterAccountService->add(
            $request->request->get(self::ACCESS_TOKEN_KEY),
            $request->request->get(self::ACCESS_TOKEN_SECRET_KEY),
            $request->request->get(self::CONSUMER_KEY_KEY),
            $request->request->get(self::CONSUMER_SECRET_KEY)
        );

        return self::createResponse(Response::HTTP_CREATED, [self::ACCOUNT_RESPONSE_KEY => $account]);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $this->validate($request, self::PATCH_RULES);

        $updateFields = array_filter(
            $request->keys(),
            function ($key) {
                return in_array($key, array_keys(self::PATCH_RULES));
            }
        );

        $account = $this->twitterAccountService->update($id, $request->all($updateFields));

        return self::createResponse(Response::HTTP_ACCEPTED, [self::ACCOUNT_RESPONSE_KEY => $account]);
    }

    public function delete(int $id): JsonResponse
    {
        $this->twitterAccountService->delete($id);

        return self::createResponse(Response::HTTP_ACCEPTED, null, self::TWITTER_ACCOUNT_DELETED_MESSAGE);
    }
}
