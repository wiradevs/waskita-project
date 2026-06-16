<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Middleware\AdminAuthenticate;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');

Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/katalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

// Admin panel
Route::prefix('panel')->name('panel.')->group(function () {
    // Guest only
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);

    });

    // Authenticated
    Route::middleware(AdminAuthenticate::class)->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/password', [AuthController::class, 'passwordForm'])->name('password');
        Route::put('/password', [AuthController::class, 'passwordUpdate'])->name('password.update');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/upload-media', [SettingsController::class, 'uploadMedia'])->name('settings.upload-media');
        Route::post('/settings/delete-media', [SettingsController::class, 'deleteMedia'])->name('settings.delete-media');

        Route::resource('products', ProductController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])->names('products');
        Route::resource('categories', CategoryController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])->names('categories');
        Route::resource('messages', MessageController::class)->only(['index', 'show', 'destroy'])->names('messages');
    });
});
