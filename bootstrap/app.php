<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->statefulApi();

        // Alias middleware robot
        $middleware->alias([
            'robot.token' => \App\Http\Middleware\RobotTokenMiddleware::class,
        ]);
        
        // Redirect ke admin.login jika belum login (untuk routes admin)
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->is('admin/*')) {
                return route('admin.login');
            }
            return route('admin.login'); // Default redirect
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle unauthenticated for API
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Silakan login terlebih dahulu.',
                ], 401);
            }
            
            // Redirect ke admin login untuk web requests
            if ($request->is('admin/*')) {
                return redirect()->route('admin.login')
                    ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
            }
            
            return redirect()->route('admin.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        });

        // Handle 404 Not Found
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Halaman tidak ditemukan.',
                ], 404);
            }
            return response()->view('errors.404', [], 404);
        });

        // Handle 403 Forbidden
        $exceptions->render(function (AccessDeniedHttpException $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak.',
                ], 403);
            }
            return response()->view('errors.403', [], 403);
        });

        // Handle other HTTP Exceptions (500, etc)
        $exceptions->render(function (HttpException $e, $request) {
            $statusCode = $e->getStatusCode();
            
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Terjadi kesalahan server.',
                ], $statusCode);
            }
            
            $view = 'errors.' . $statusCode;
            if (view()->exists($view)) {
                return response()->view($view, [], $statusCode);
            }
            
            return response()->view('errors.500', ['message' => $e->getMessage()], $statusCode);
        });
    })->create();
