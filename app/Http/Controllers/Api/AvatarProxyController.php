<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Http, Log};


class AvatarProxyController extends Controller
{
    public function show(Request $request)
    {
        $url = $request->query('url');

        if (!$url) {
            return response('', 204);
        }

        $cacheKey = 'avatar_' . md5($url);

        try {
            $imageData = Cache::remember($cacheKey, now()->addDays(1), function () use ($url) {
                $response = Http::get($url);
                if (!$response->successful()){
                    Log::warning('Avatar proxy: failed to fetch ' . $url . ' status: ' . $response->status());
                    return null;
                }
                return [
                    'body' => base64_encode($response->body()),
                    'type' => $response->header('Content-Type') ?: 'image/png',
                ];
            });

            if (!$imageData)
                return response('', 204);

            return response(base64_decode($imageData['body']))
                ->header('Content-Type', $imageData['type'])
                ->header('Cache-Control', 'public, max-age=86400');

        } catch (Exception $e) {
            Log::warning('Avatar proxy failed: ' . $e->getMessage());
            return response('', 204);
        }
    }
}
