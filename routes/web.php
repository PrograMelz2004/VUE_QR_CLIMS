<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\InventoryPdfController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/users/login', [AuthController::class, 'login'])->name('users.login');
Route::post('/users/register', [AuthController::class, 'register'])->name('users.register');
Route::get('/system', [AuthController::class, 'system'])->name('system.view');
Route::get('/about', [AuthController::class, 'about'])->name('system.about');
Route::get('/logout', [AuthController::class, 'logout'])->name('users.logout')->middleware('auth');

// Protected Routes (Require Authentication)
Route::middleware(['auth'])->group(function () {
    // Item Routes
    Route::get('/items', [ItemController::class, 'index'])->name('items.view');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/scan', [ItemController::class, 'scanner'])->name('items.scan');
    Route::post('/scan', [ItemController::class, 'scan'])->name('items.scan');
    Route::patch('/items/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');

    // System Routes
    Route::get('/edit', [SystemController::class, 'settings'])->name('system.edit');
    Route::post('/update/short_name', [SystemController::class, 'updateShortName'])->name('system.update.short_name');
    Route::post('/update/long_name', [SystemController::class, 'updateLongName'])->name('system.update.long_name');
    Route::post('/add-room', [SystemController::class, 'addRoom'])->name('room.add');
    Route::post('/update-room', [SystemController::class, 'editRoom'])->name('room.update');
    Route::post('/delete-room', [SystemController::class, 'deleteRoom'])->name('room.delete');

    // User Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.view');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile.view');

    //PDF Routes
    Route::get('/download-inventory', [InventoryPdfController::class, 'generateItemPdf'])->name('download.inventory');
    Route::get('/download-user', [InventoryPdfController::class, 'generateUserPdf'])->name('download.user');
});
