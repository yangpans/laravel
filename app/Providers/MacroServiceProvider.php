<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        Response::macro('success', function ($data = null, $message = 'Success', $statusCode = 200) {
            return Response::json([
                'success' => true,
                'data' => $data,
                'message' => $message,
            ], $statusCode);
        });

        Response::macro('error', function ($message = 'Error', $statusCode = 400) {
            return Response::json([
                'success' => false,
                'message' => $message,
            ], $statusCode);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
