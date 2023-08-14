<?php

use App\Http\Controllers\PostsController;
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
Route::group(['middleware' => 'auth:sanctum'], function()
{

});
Route::get('/posts', [PostsController::class, 'index']);
Route::get('/posts/id/{id?}', [PostsController::class, 'show']);
Route::post('/posts/create', [PostsController::class, 'store']);
Route::put('/posts/update/id/{id?}', [PostsController::class, 'update']);
Route::delete('/posts/delete/id/{id?}', [PostsController::class, 'destroy']);