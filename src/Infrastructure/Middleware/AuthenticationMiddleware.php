<?php

declare(strict_types=1);

namespace CoenMooij\BrandApi\CoenMooij\BrandApi\Infrastructure\Middleware;

use Carbon\Carbon;
use Closure;
use CoenMooij\BrandApi\Application\AbstractController;
use CoenMooij\BrandApi\Domain\User\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

final class AuthenticationMiddleware
{
    private const TOKEN_INVALID = 'Invalid Token';

    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('token', '');
        if ($this->tokenIsValid($token)) {
            return $next($request);
        }

        return AbstractController::createResponse(Response::HTTP_FORBIDDEN, null, self::TOKEN_INVALID);
    }

    private function tokenIsValid(string $token): bool
    {
        try {
            $user = User::where(User::TOKEN, $token)->where(User::TOKEN_EXPIRES, '>', Carbon::now())->firstOrFail();
            $user->{User::TOKEN_EXPIRES} = Carbon::now()->addHours(1);
            $user->save();

            Auth::login($user);

            return true;
        } catch (ModelNotFoundException $exception) {
            return false;
        }
    }
}
