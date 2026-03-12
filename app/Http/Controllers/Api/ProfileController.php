<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private User $user;

    public function __construct()
    {
        Auth::shouldUse('api');
        $this->user = Auth::user();
    }

    public function me(): JsonResponse
    {
        return response()->json([
            'message' => 'Profile fetched successfully',
            'user'    => new UserResource($this->user),
        ], 200);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $this->user->update($request->validated());

        return response()->json([
            'message' => 'Profile updated successfully',
            'user'    => new UserResource($this->user),
        ], 200);
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        if (!Hash::check($request->current_password, $this->user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect',
            ], 422);
        }

        $this->user->update(['password' => $request->new_password]);

        return response()->json([
            'message' => 'Password updated successfully',
        ], 200);
    }

    public function destroy(): JsonResponse
    {
        Auth::logout();
        $this->user->delete();

        return response()->json([
            'message' => 'Account deleted successfully',
        ], 200);
    }
}
