<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoreController;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', [CoreController::class, 'index']);
Route::get('/profile', [CoreController::class, 'profile']);
Route::get('/dashboard', [CoreController::class, 'dashboard']);
Route::get('/board', [CoreController::class, 'board']);
