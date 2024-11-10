<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Debugbar::addMeasure('now', LARAVEL_START, microtime(true));
// Debugbar::measure('My long operation', function () {
//     // Do something…
// Route::view('/', 'home');
// });

Route::view('/', 'home');
Route::view('/article', 'single-article');
Route::view('/articles', 'articles');
Route::view('/associations', 'associations');

Route::prefix("/dashboard")->middleware('auth')->group(function () {
    Route::view('/', 'dashboard')->name('dashboard');
    Route::prefix("/users")->group(function () {
        Route::view('/', 'dashboard')->name('users_manage');
        Route::view('/create', 'dashboard')->name('user_add');
        Route::view('/{user}', 'dashboard')->name('user_edit');
    });
    Route::prefix("/article")->group(function () {
        Route::view('/', 'dashboard')->name('articles_manage');
        Route::view('/create', 'dashboard')->name('article_add');
        Route::view('/edit', 'dashboard')->name('article_edit');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
