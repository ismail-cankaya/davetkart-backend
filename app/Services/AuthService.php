<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    private const TOKEN_NAME = 'davetkart-spa';

    /**
     * Register a new account and open its first session.
     *
     * @param  array{fullName: string, email: string, password: string}  $payload
     * @return array{user: User, token: string}
     */
    public function register(array $payload): array
    {
        $user = User::create([
            'full_name' => $payload['fullName'],
            'email' => $payload['email'],
            'password' => $payload['password'], // hashed by the model cast
        ]);

        return [
            'user' => $user,
            'token' => $this->issueToken($user),
        ];
    }

    /**
     * Verify credentials and open a session.
     *
     * @param  array{email: string, password: string}  $credentials
     * @return array{user: User, token: string}
     *
     * @throws ValidationException when the credentials do not match (422)
     */
    public function login(array $credentials): array
    {
        $user = User::query()->where('email', $credentials['email'])->first();

        if ($user === null || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => __('E-posta veya şifre hatalı.'),
            ]);
        }

        return [
            'user' => $user,
            'token' => $this->issueToken($user),
        ];
    }

    /** Revoke the token used by the current request. */
    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }

    private function issueToken(User $user): string
    {
        return $user->createToken(self::TOKEN_NAME)->plainTextToken;
    }
}
