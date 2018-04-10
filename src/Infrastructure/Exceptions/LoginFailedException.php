<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class LoginFailedException extends HttpException
{
    private const MESSAGE = 'Login Failed';

    public function __construct()
    {
        parent::__construct(Response::HTTP_UNAUTHORIZED, self::MESSAGE);
    }
}
