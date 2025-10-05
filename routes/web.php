<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CigarettesController;

// API Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/user', [AuthController::class, 'getCurrentUser'])->middleware('auth');

// Other API routes...
Route::get('/cigarettes', [CigarettesController::class, 'index']);
Route::get('/cigarettes/search', [CigarettesController::class, 'search']);
Route::get('/cigarettes/{id}', [CigarettesController::class, 'show']);

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/cigarette/{cigaretteId}', [PostController::class, 'getByCigarette']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/posts', [PostController::class, 'store'])->middleware('auth');
Route::put('/posts/{id}', [PostController::class, 'update'])->middleware('auth');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('auth');
Route::get('/my-posts', [PostController::class, 'getUserPosts'])->middleware('auth');

// SPA Routes - Catch all route to handle SPA routing
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');