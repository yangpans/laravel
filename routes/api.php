<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{IndexController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('web')
    ->name('web.index.')
    ->controller(IndexController::class)
    ->group(
        function () {
            Route::get('index', 'index')->name('index');

            Route::get('update', 'update')->name('update');

            //GET method. Return the request content.
            Route::get('content', 'content')->name('content');

            //GET method. Throw an expected error, such as validation exception.
            Route::get('validation', 'validation')->name('validation');

            //GET method. Throw an unexpected error.
            Route::get('unexpected', 'unexpected')->name('unexpected');
        });
