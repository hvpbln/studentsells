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
use App\Http\Controllers\ListingResponseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;

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
        return redirect()->route('student.dashboard');
    })->name('dashboard');

    // Admin routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'showPendingUsers'])->name('admin.users');
        Route::get('/admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manageUsers');
        Route::post('/admin/users/{id}/status', [AdminController::class, 'updateUserStatus'])->name('admin.users.updateStatus');
        Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::get('/admin/users/{user}/posts', [AdminController::class, 'showUserPosts'])->name('admin.users.posts');

        Route::get('/admin/listings', [AdminController::class, 'listings'])->name('admin.listings');
        Route::delete('/admin/listings/{item}', [AdminController::class, 'deleteListing'])->name('admin.listings.delete');

        Route::get('/admin/wishlists', [AdminController::class, 'wishlists'])->name('admin.wishlists');
        Route::delete('/admin/wishlists/{wishlist}', [AdminController::class, 'deleteWishlist'])->name('admin.wishlists.delete');

        Route::get('/admin/responses', [AdminController::class, 'responses'])->name('admin.responses');
        Route::delete('/admin/responses/wishlist/{response}', [AdminController::class, 'deleteWishlistResponse'])->name('admin.responses.wishlist.delete');
        Route::delete('/admin/responses/listing/{response}', [AdminController::class, 'deleteListingResponse'])->name('admin.responses.listing.delete');
    });

    // Student routes
    Route::middleware([StudentMiddleware::class])->group(function () {
        Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

        Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');

        Route::resource('items', ItemController::class);
        Route::post('items/{id}/status', [ItemController::class, 'updateStatus'])->name('items.updateStatus');
        Route::get('/items/{item}/respond', [ItemController::class, 'respond'])->name('listings.respond');
        Route::post('/items/{item}/respond', [ItemController::class, 'sendResponse'])->name('listings.sendResponse');

        Route::resource('wishlists', WishlistController::class);
        Route::post('wishlists/{wishlist}/status', [WishlistController::class, 'updateStatus'])->name('wishlists.updateStatus');

        Route::get('wishlists/{wishlist}/responses/create', [WishlistResponseController::class, 'create'])->name('wishlists.responses.create');
        Route::post('wishlists/{wishlist}/responses', [WishlistResponseController::class, 'store'])->name('wishlists.responses.store');

        Route::get('/items/{item}/respond', [ListingResponseController::class, 'create'])->name('items.respond');
        Route::post('/items/{item}/respond', [ListingResponseController::class, 'store'])->name('items.sendresponse');
    });

    // Public profile route for viewing other users' listings and wishlists
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/rate', [RatingController::class, 'store'])->name('users.rate')->middleware('auth');


});
