<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReadController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('levels', LevelController::class);
Route::resource('books', BookController::class);
Route::resource('reads', ReadController::class);
Route::resource('authors', AuthorController::class);
Route::resource('publishers', PublisherController::class);
Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
});