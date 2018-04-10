<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class DuplicateRegistrationException extends HttpException
{
    private const MESSAGE = 'Registration Failed, user already exists';

    public function __construct()
    {
        parent::__construct(Response::HTTP_BAD_REQUEST, self::MESSAGE);
    }
}
