<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Application\Twitter;

use CoenMooij\BrandApi\Application\AbstractController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class TwitterAccountController extends AbstractController
{
    private const ACCOUNTS_KEY = 'accounts';
    private const ACCOUNT_KEY = 'account';
    private const DELETED_MESSAGE = 'Twitter account successfully deleted';

    public function getAll(): JsonResponse
    {
        $accounts = []; // TODO : implement

        return self::createResponse(Response::HTTP_OK, [self::ACCOUNTS_KEY => $accounts]);
    }

    public function getOne(int $id): JsonResponse
    {
        $account = []; // TODO : implement

        return self::createResponse(Response::HTTP_OK, [self::ACCOUNT_KEY => $account]);
    }

    public function post(Request $request): JsonResponse
    {
        $account = []; // TODO : implement

        return self::createResponse(Response::HTTP_CREATED, [self::ACCOUNT_KEY => $account]);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
        $account = []; // TODO : implement

        return self::createResponse(Response::HTTP_ACCEPTED, [self::ACCOUNT_KEY => $account]);
    }

    public function delete(int $id): JsonResponse
    {
        $account = []; // TODO : implement

        return self::createResponse(Response::HTTP_ACCEPTED, null, self::DELETED_MESSAGE);
    }
}
