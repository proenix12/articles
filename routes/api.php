<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\ArticleController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/articles', [ArticleController::class, 'index']);
Route::post('/v1/article/create', [ArticleController::class, 'store']);
Route::post('/v1/article/{id}/update', [ArticleController::class, 'update']);
Route::post('/v1/article/search', [ArticleController::class, 'search']);
Route::delete('/v1/article/{id}', [ArticleController::class, 'destroy']);

//Article tag add/remove routes
Route::post('/v1/article/{id}/tag', [ArticleController::class, 'articleTagAttach']);
Route::delete('/v1/article/{id}/tag', [ArticleController::class, 'articleTagUntag']);
