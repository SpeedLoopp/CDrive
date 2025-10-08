<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\Admin;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/l/{customLink}', [LinkController::class, 'show'])->name('link.show');
Route::get('/l/{customLink}/download', [LinkController::class, 'download'])->name('link.download');

Route::get('/mark-popup-shown/{id}', function ($id) {
    session(['popup_shown_' . $id => true]);
    return response()->json(['success' => true]);
});

// Auth routes
require __DIR__.'/auth.php';

// User dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // File management
    Route::prefix('files')->name('files.')->group(function () {
        Route::get('/', [FileController::class, 'index'])->name('index');
        Route::post('/upload', [FileController::class, 'upload'])->name('upload');
        Route::get('/{file}/download', [FileController::class, 'download'])->name('download');
        Route::delete('/{file}', [FileController::class, 'destroy'])->name('destroy');
    });

    // Link management
    Route::prefix('links')->name('links.')->group(function () {
        Route::get('/', [LinkController::class, 'index'])->name('index');
        Route::get('/create/{file}', [LinkController::class, 'create'])->name('create');
        Route::post('/{file}', [LinkController::class, 'store'])->name('store');
        Route::delete('/{link}', [LinkController::class, 'destroy'])->name('destroy');
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // User management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [Admin\UserController::class, 'index'])->name('index');
        Route::post('/{user}/toggle', [Admin\UserController::class, 'toggleStatus'])->name('toggle');
        Route::delete('/{user}', [Admin\UserController::class, 'destroy'])->name('destroy');
    });

    // File management
    Route::prefix('files')->name('files.')->group(function () {
        Route::get('/', [Admin\FileController::class, 'index'])->name('index');
        Route::delete('/{file}', [Admin\FileController::class, 'destroy'])->name('destroy');
    });

    // Link management
    Route::prefix('links')->name('links.')->group(function () {
        Route::get('/', [Admin\LinkController::class, 'index'])->name('index');
        Route::delete('/{link}', [Admin\LinkController::class, 'destroy'])->name('destroy');
    });

    // Ad management
    Route::prefix('ads')->name('ads.')->group(function () {
        Route::get('/', [Admin\AdController::class, 'index'])->name('index');
        Route::get('/create', [Admin\AdController::class, 'create'])->name('create');
        Route::post('/', [Admin\AdController::class, 'store'])->name('store');
        Route::get('/{ad}/edit', [Admin\AdController::class, 'edit'])->name('edit');
        Route::put('/{ad}', [Admin\AdController::class, 'update'])->name('update');
        Route::post('/{ad}/toggle', [Admin\AdController::class, 'toggleStatus'])->name('toggle');
        Route::delete('/{ad}', [Admin\AdController::class, 'destroy'])->name('destroy');
    });
});
