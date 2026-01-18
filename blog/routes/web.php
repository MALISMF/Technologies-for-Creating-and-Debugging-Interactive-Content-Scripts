<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

// Админ-панель для модерации комментариев
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/comments', [App\Http\Controllers\Admin\CommentModerationController::class, 'index'])->name('comments.index');
    Route::post('/comments/{comment}/approve', [App\Http\Controllers\Admin\CommentModerationController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reject', [App\Http\Controllers\Admin\CommentModerationController::class, 'reject'])->name('comments.reject');
});
