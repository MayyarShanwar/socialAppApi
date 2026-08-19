<?php

use App\Http\Controllers\WebPostController;
use App\Http\Controllers\WebAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| These are session-based (Blade) routes, separate from the JWT-protected
| routes/api.php used by your Postman collection. Add this file's contents
| to your existing routes/web.php (or replace it, if it's still the default).
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register']);
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

    Route::get('/posts/create', [WebPostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [WebPostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [WebPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [WebPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [WebPostController::class, 'destroy'])->name('posts.destroy');
});

Route::get('/', [WebPostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [WebPostController::class, 'show'])->name('posts.show');
