<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        /** @var array $payload */
        $payload = $request->validated();

        /** @var ?User $user */
        $user = User::query()->where('email', $payload['email'])->first();

        if (is_null($user)) {
            return response()->json(
                [
                    'message' => __('auth.failed'),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (! Hash::check($payload['password'], $user->password)) {
            return response()->json(
                [
                    'message' => __('auth.password'),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $accessToken = $user->createToken(
            name: $request->userAgent(),
            expiresAt: now()->addMinutes((int) config('session.lifetime'))
        )->plainTextToken;

        return response()->json($user)->withHeaders(['Authorization' => 'Bearer '.$accessToken]);
    }
}
