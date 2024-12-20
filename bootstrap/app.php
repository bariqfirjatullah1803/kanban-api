<?php

use App\Http\Middleware\ForceJsonMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            ForceJsonMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Not Found',
                    'data' => []
                ], 404);
            }
        });
        $exceptions->render(function (ValidationException $exception, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'status' => 422,
                    'message' => 'Validation failed.',
                    'data' => $exception->errors()
                ], 422);
            }
        });
        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => $exception->getMessage(),
                'data' => []
            ], 401);
        });
        $exceptions->render(function (Exception $exception, Request $request) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $exception->getMessage(),
                'data' => []
            ], 500);
        });
    })->create();
