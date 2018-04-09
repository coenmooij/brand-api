<?php

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__ . '/../')
);

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    CoenMooij\BrandApi\Infrastructure\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    \Illuminate\Foundation\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    CoenMooij\BrandApi\Infrastructure\Exceptions\ExceptionHandler::class
);

return $app;
