<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WishlistResponseController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('items.index');
    })->name('dashboard');

    // Admin routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'showPendingUsers'])->name('admin.users');
        Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manageUsers');
        Route::post('/admin/users/{id}/status', [AdminController::class, 'updateUserStatus'])->name('admin.users.updateStatus');
    });

    // Student routes
    Route::middleware([StudentMiddleware::class])->group(function () {
        Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

        Route::resource('items', ItemController::class);
        Route::post('items/{id}/status', [ItemController::class, 'updateStatus'])->name('items.updateStatus');

        Route::resource('wishlists', WishlistController::class);
        Route::post('wishlists/{wishlist}/status', [WishlistController::class, 'updateStatus'])->name('wishlists.updateStatus');

        Route::get('wishlists/{wishlist}/responses/create', [WishlistResponseController::class, 'create'])->name('wishlists.responses.create');
        Route::post('wishlists/{wishlist}/responses', [WishlistResponseController::class, 'store'])->name('wishlists.responses.store');
    });

});
