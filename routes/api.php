<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/mensaje', [App\Http\Controllers\MessageController::class, 'sendText']);

Route::get('/leer', [App\Http\Controllers\MessageController::class, 'markMessageAsRead']);


Route::get('/test', [App\Http\Controllers\MessageController::class, 'test']);
Route::post('/plantilla', [App\Http\Controllers\MessageController::class, 'sendMessageTemplateText']);
Route::post('/multimedia', [App\Http\Controllers\MessageController::class, 'sendMessageTemplateMultiMedia']);

