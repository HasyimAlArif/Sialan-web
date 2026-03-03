<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Handle unauthenticated users
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Jika request dari API, return JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Silakan login terlebih dahulu.',
            ], 401);
        }

        // Jika dari web, redirect ke login sesuai guard
        $guard = $exception->guards()[0] ?? null;

        switch ($guard) {
            case 'admin':
                return redirect()->guest(route('admin.login'));
            case 'petugas':
                return redirect()->guest(route('petugas.login'));
            default:
                return redirect()->guest(route('admin.login')); // default ke admin
        }
    }
}