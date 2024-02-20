<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiKey;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');


        if (!$apiKey) {
            return response()->json(['error' => 'API key missing'], 401);
        }

        $validApiKey = env('API_KEY');

        if ($apiKey !== $validApiKey) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        if (!$validApiKey) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        return $next($request);
    }
}
