<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Authenticate a restaurant owner and return a Sanctum token.
     *
     * Revokes all existing tokens on login to enforce single-session access.
     * The frontend stores the token in localStorage and sends it
     * as a Bearer token in the Authorization header.
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Revoke all existing tokens — one active session at a time
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'    => 'Login successful.',
            'user'       => $user,
            'restaurant' => $user->restaurant?->load('theme', 'qrStyle'),
            'token'      => $token,
        ]);
    }
}
