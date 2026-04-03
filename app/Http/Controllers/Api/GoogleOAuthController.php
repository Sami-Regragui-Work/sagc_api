<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class GoogleOAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->setScopes(['openid', 'email', 'profile'])
            ->redirect([
                'prompt' => 'select_account',
                'approval_prompt' => 'force'
            ]);
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $name = $googleUser->getName();
            $firstLast = $name ? explode(' ', trim($name), 2) : ['', ''];
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'username' => ($name ? strtolower($firstLast[0] . '_' . $firstLast[1]) : 'user') . '_' . substr($googleUser->getId(), -6),
                    'first_name' => $googleUser->user['given_name'] ?? $firstLast[0] ?? '',
                    'last_name' => $googleUser->user['family_name'] ?? $firstLast[1] ?? '',
                    'avatar_url' => $googleUser->avatar ?? $googleUser->getAvatar(),
                    'email_verified_at' => now(),
                    'password' => 'oauth-temp',
                    'oauth_provider' => 'google',
                    'oauth_id' => $googleUser->getId(),
                ]
            );

            $token = JWTAuth::fromUser($user);

            return redirect('http://localhost:8080/?token=' . $token . '&user=' . urlencode(json_encode($user)));
        } catch (Exception $e) {
            Log::error('Google OAuth failed: ' . $e->getMessage());
            return redirect('http://localhost:8080/?error=Google auth failed');
        }
    }
}
