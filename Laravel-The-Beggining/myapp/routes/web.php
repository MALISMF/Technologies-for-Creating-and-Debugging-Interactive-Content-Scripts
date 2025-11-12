<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
Route::get('/', [PageController::class, 'home']);
Route::get('/about', [PageController::class, 'about']);
Route::post('/feedback', [PageController::class, 'submitFeedback'])->name('feedback.submit');
Route::get('/feedbacks', [PageController::class, 'showFeedbacks'])->name('feedbacks.show');