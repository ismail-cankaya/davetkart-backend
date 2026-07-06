<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $session = $this->authService->login($request->validated());

        return $this->sessionResponse($session);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $session = $this->authService->register($request->validated());

        return $this->sessionResponse($session, status: 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Çıkış yapıldı.']);
    }

    /**
     * Shape shared by login and register — the frontend `AuthSession`.
     *
     * @param  array{user: User, token: string}  $session
     */
    private function sessionResponse(array $session, int $status = 200): JsonResponse
    {
        return response()->json([
            'user' => new UserResource($session['user']),
            'token' => $session['token'],
        ], $status);
    }
}
