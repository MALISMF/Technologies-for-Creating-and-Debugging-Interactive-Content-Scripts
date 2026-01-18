<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\FeedbackController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes v1.1
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    // Основные CRUD маршруты
    Route::apiResource('feedbacks', FeedbackController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('tags', TagController::class);
    Route::apiResource('comments', CommentController::class);
    
    // Дополнительные маршруты для работы со связями
    Route::get('feedbacks/{feedback}/comments', [FeedbackController::class, 'comments']);
    Route::post('feedbacks/{feedback}/tags', [FeedbackController::class, 'attachTags']);
});
