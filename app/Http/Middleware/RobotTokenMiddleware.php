<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RobotTokenMiddleware
{
    /**
     * Handle an incoming request.
     * Validasi menggunakan header X-Robot-Token yang harus sesuai dengan
     * nilai ROBOT_API_TOKEN di file .env.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token  = $request->header('X-Robot-Token');
        $secret = config('app.robot_api_token');

        if (empty($token) || $token !== $secret) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Token robot tidak valid.',
            ], 401);
        }

        return $next($request);
    }
}
