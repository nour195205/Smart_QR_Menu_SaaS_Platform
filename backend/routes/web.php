<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PdfMenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublishController;
use App\Http\Controllers\QrStyleController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| All dashboard routes use session auth (Breeze) + restaurant.owner middleware.
| The public menu frontend is a separate Netlify app that reads static JSON.
|
*/

// Landing: redirect to login or dashboard
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard.index')
        : redirect()->route('login');
});

// ─── Dashboard (session auth + restaurant required) ───────────────────────────
Route::middleware(['auth', 'restaurant.owner'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        // Home / overview
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // Restaurant settings
        Route::get('/settings', [RestaurantController::class, 'edit'])->name('restaurant.edit');
        Route::put('/settings', [RestaurantController::class, 'update'])->name('restaurant.update');

        // Categories (reorder before /{category} to avoid routing conflicts)
        Route::get('/menu', [CategoryController::class, 'index'])->name('menu.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::post('/categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Items (reorder before /{item})
        Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
        Route::post('/items', [ItemController::class, 'store'])->name('items.store');
        Route::post('/items/reorder', [ItemController::class, 'reorder'])->name('items.reorder');
        Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
        Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
        Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

        // Theme
        Route::get('/theme', [ThemeController::class, 'edit'])->name('theme.edit');
        Route::put('/theme', [ThemeController::class, 'update'])->name('theme.update');

        // QR Style
        Route::get('/qr', [QrStyleController::class, 'edit'])->name('qr.edit');
        Route::put('/qr', [QrStyleController::class, 'update'])->name('qr.update');

        // PDF menu
        Route::get('/pdf', [PdfMenuController::class, 'index'])->name('pdf.index');
        Route::post('/pdf', [PdfMenuController::class, 'store'])->name('pdf.store');
        Route::delete('/pdf/{pdfMenu}', [PdfMenuController::class, 'destroy'])->name('pdf.destroy');

        // Publish workflow
        Route::get('/publish/status', [PublishController::class, 'status'])->name('publish.status');
        Route::post('/publish', [PublishController::class, 'publish'])->name('publish.publish');
        Route::post('/publish/retry', [PublishController::class, 'retry'])->name('publish.retry');

    });

// ─── User Profile (Breeze default) ────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Breeze Auth Routes (login, register, password reset, etc.) ───────────────
require __DIR__.'/auth.php';

