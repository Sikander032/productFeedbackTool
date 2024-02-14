<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserController;
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
Route::post('/login', [RegisterController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [RegisterController::class, 'logout']);
    Route::get('/feedback-categories', [FeedbackController::class, 'getFeedbackCategories']);
    Route::post('/feedback', [FeedbackController::class, 'store']);

    Route::get('/feedback', [FeedbackController::class, 'index']);
    Route::post('/submit-comment', [FeedbackController::class, 'addComment']);
    Route::get('/get-comments', [FeedbackController::class, 'getCommentsByFeedbackId']);
    Route::get('/users-for-mention', [UserController::class, 'getUsersForMention']);
});


