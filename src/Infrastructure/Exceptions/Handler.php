<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\Infrastructure\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class ExceptionHandler extends Handler
{
    /**
     * @param  Request $request
     * @param  \Exception $exception
     *
     * @return Response
     */
    public function render($request, Exception $exception)
    {
        // TODO : handle our custom exceptions
        return parent::render($request, $exception);
    }
}
