<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        Auth::shouldUse('api');
    }
    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = User::create([
            ...$validated,
            'avatar_url' => 'https://api.dicebear.com/7.x/avataaars/png?seed=' . $validated['username']
        ]);

        return response()->json([
            'message' => 'Account created successfully',
            'user' => new UserResource($user),
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        if (!$token = Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'type' => 'bearer',
            'user' => new UserResource($user),
        ], 200);
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logout successfull',
        ], 200);
    }

    public function refresh(): JsonResponse
    {
        return response()->json([
            'message' => 'Token refreshed successfully',
            'token'   => Auth::refresh(),
            'type'    => 'bearer',
        ], 200);
    }

}
