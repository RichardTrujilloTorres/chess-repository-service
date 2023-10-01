<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return response()->json([
        'message' => 'All good',
    ]);
});


Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', [\App\Http\Controllers\User\LoginController::class, '__invoke']);
    Route::post('register', [\App\Http\Controllers\User\RegisterController::class, '__invoke']);

    Route::group(['middleware' => ['auth']], function () {
        Route::get('refresh', [\App\Http\Controllers\User\TokenRefreshController::class, '__invoke']);
        Route::post('logout', [\App\Http\Controllers\User\LogoutController::class, '__invoke']);
    });
});

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'users',
], function () {
    Route::get('', [\App\Http\Controllers\User\UserController::class, '__invoke']);
    Route::put('', [\App\Http\Controllers\User\UserUpdateController::class, '__invoke']);
});

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'games',
], function () {
    Route::get('', [\App\Http\Controllers\Game\IndexController::class, '__invoke']);
    Route::get('search', [\App\Http\Controllers\Game\SearchController::class, '__invoke']);
    Route::get('{id}', [\App\Http\Controllers\Game\ShowController::class, '__invoke'])
        ->where('id', '[0-9]+');
    Route::get('{id}/download', [\App\Http\Controllers\Game\DownloadController::class, '__invoke'])
        ->where('id', '[0-9]+');
    Route::post('', [\App\Http\Controllers\Game\StoreController::class, '__invoke']);
    Route::delete('{id}', [\App\Http\Controllers\Game\DeleteController::class, '__invoke'])
        ->where('id', '[0-9]+');
});

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'analysis',
], function () {
    Route::put('{id}', [\App\Http\Controllers\Analysis\AppendController::class, '__invoke'])
        ->where('id', '[0-9]+');
});
