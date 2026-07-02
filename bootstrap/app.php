<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (QueryException $e, Request $request) {
            $isConstraintFailure = $e->getCode() === '23000'
                || str_contains($e->getMessage(), '1451')
                || str_contains($e->getMessage(), 'foreign key')
                || str_contains($e->getMessage(), 'Integrity constraint violation');

            if (! $isConstraintFailure) {
                return null;
            }

            $message = 'Tidak dapat melakukan operasi karena data ini masih terhubung dengan data lain.';

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'errors' => ['database' => [$message]],
                ], 409);
            }

            return redirect()->back()->withInput()->withErrors([
                'database' => $message,
            ]);
        });
    })->create();
