<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WebsiteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('websites')->group(function () {
    Route::prefix('{website_id}')->group(function () {
        Route::post('posts', [PostController::class, 'create']);
        Route::prefix('users')->group(function () {
            Route::prefix('{user_id}')->group(function () {
                Route::patch('/subscribe', [WebsiteController::class, 'subscribe']);
            });
        });
    });
});
