<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Service\ReachServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class ReachController extends AbstractController
{
    private const REACH_KEY = 'reach';
    /**
     * @var ReachServiceInterface
     */
    private $reachService;

    public function __construct(ReachServiceInterface $reachService)
    {
        $this->reachService = $reachService;
    }

    public function getReachForTweet(string $id): JsonResponse
    {
        $reach = $this->reachService->getByTweet($id);

        return self::createResponse(Response::HTTP_OK, [self::REACH_KEY => $reach]);
    }
}
