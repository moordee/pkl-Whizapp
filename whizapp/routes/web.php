<?php

use App\Http\Controllers\CoreController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\WishlistItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CoreController::class, 'index'])->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BoardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/dark-mode', [ProfileController::class, 'toggleDarkMode'])->name('profile.toggle-dark-mode');

    Route::post('/boards', [BoardController::class, 'store'])->name('boards.store');
    Route::get('/boards/search', [BoardController::class, 'search'])->name('boards.search');
    Route::get('/boards/{board:slug}', [BoardController::class, 'show'])->name('boards.show');
    Route::delete('/boards/{board}', [BoardController::class, 'destroy'])->name('boards.destroy');

    Route::post('/boards/{board}/items', [WishlistItemController::class, 'store'])->name('items.store');
    Route::delete('/items/{item}', [WishlistItemController::class, 'destroy'])->name('items.destroy');

    Route::post('/boards/{board}/share', [BoardController::class, 'generateShareLink'])->name('boards.share');

    Route::post('/prefetch', [WishlistItemController::class, 'prefetch'])->name('prefetch');
});

Route::get('/shared/{token}', [BoardController::class, 'viewShared'])->name('boards.shared');

require __DIR__.'/auth.php';
