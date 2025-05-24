<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::resource('items', ItemController::class);
Route::post('items/{id}/status', [ItemController::class, 'updateStatus'])->name('items.updateStatus');

Route::get('/', function () {
    return view('welcome');
});
