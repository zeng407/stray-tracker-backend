<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostController::class, 'index']);
Route::post('/post', [PostController::class, 'store']);
Route::put('/post/{post}', [PostController::class, 'update']);
Route::post('/post/{post}/reply', [PostController::class, 'reply']);
Route::get('/post/{post}/reply', [PostController::class, 'getReplies']);
