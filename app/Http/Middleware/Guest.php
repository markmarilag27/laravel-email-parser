<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Guest
{
    public function handle(Request $request, Closure $next): JsonResponse|Response
    {
        if (! is_null($request->user())) {
            return response()->json(
                [
                    'message' => 'Not found.',
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return $next($request);
    }
}
