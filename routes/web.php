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
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;

// guest routes
Route::view('/', 'guest.home')->name('home');
Route::view('/about', 'guest.about')->name('about');
Route::view('/contactus', 'guest.contactus')->name('contactus');

// authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// authenticated user routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('student.dashboard');
    })->name('dashboard');

    // admin routes
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

    // student routes
    Route::middleware([StudentMiddleware::class])->group(function () {
        Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');
        Route::get('/student/profile/edit', [UserController::class, 'editProfile'])->name('student.profile.edit');
        Route::post('/student/profile/update', [UserController::class, 'updateProfile'])->name('student.profile.update');
        Route::post('/profile/update-photo', [UserController::class, 'updatePhoto'])->name('profile.updatePhoto');

        // listings (items)
        Route::resource('items', ItemController::class);
        Route::post('items/{id}/status', [ItemController::class, 'updateStatus'])->name('items.updateStatus');
        Route::get('/items/{item}/respond', [ListingResponseController::class, 'create'])->name('items.respond');
        Route::post('/items/{item}/respond', [ListingResponseController::class, 'store'])->name('items.sendresponse');

        // wishlists
        Route::resource('wishlists', WishlistController::class);
        Route::post('wishlists/{wishlist}/status', [WishlistController::class, 'updateStatus'])->name('wishlists.updateStatus');
        Route::get('wishlists/{wishlist}/responses/create', [WishlistResponseController::class, 'create'])->name('wishlists.responses.create');
        Route::post('wishlists/{wishlist}/responses', [WishlistResponseController::class, 'store'])->name('wishlists.responses.store');

        // messages
        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{userId}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

        // notifications
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::get('/notifications/redirect/{id}', [NotificationController::class, 'showAndMarkAsRead'])->name('notifications.redirect');
    });

    // Public profile route for viewing other users' listings and wishlists
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/rate', [RatingController::class, 'store'])->name('users.rate');
});