<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route (For all logged-in users)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin Only Routes
Route::middleware(['auth', \App\Http\Middleware\EnsureIsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/lexicon', [AdminController::class, 'storeLexicon'])->name('admin.lexicon.store');
    Route::post('/admin/port', [AdminController::class, 'storePort'])->name('admin.port.store');
    Route::post('/admin/article', [AdminController::class, 'storeArticle'])->name('admin.article.store');
});
