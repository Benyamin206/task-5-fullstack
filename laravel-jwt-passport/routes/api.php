<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
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

Route::post('login', [AuthController::class, 'login']);

// Route::prefix('v1')->group(function () {
//     Route::apiResource('articles', ArticleController::class);
// });


// Rute untuk artikel (posts) dengan menggunakan middleware auth:api
Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->group(function () {
        // Rute untuk list semua artikel (GET)
        Route::get('/articles', [ArticleController::class, 'index']);

        // Rute untuk membuat artikel baru (POST)
        Route::post('/articles', [ArticleController::class, 'store']);

        // Rute untuk menampilkan detail artikel (GET)
        Route::get('/articles/{article}', [ArticleController::class, 'show']);

        // Rute untuk memperbarui artikel (PUT/PATCH)
        Route::put('/articles/{article}', [ArticleController::class, 'update']);
        Route::patch('/articles/{article}', [ArticleController::class, 'update']);

        // Rute untuk menghapus artikel (DELETE)
        Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);
    });
});
