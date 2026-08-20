<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReadController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\BookInteractionController;
use App\Http\Controllers\UserDashboardController;

Route::get('/', function () {
    return view('welcome');
});

// ── Authentication ──────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Public: Book Detail & Reader ────────────────────────────
Route::get('/books/{book}/detail', [BookController::class, 'show'])->name('books.show');
Route::get('/books/{book}/read/{chapter?}', [ReaderController::class, 'show'])->name('books.read');

// ── Public: Fetch Comments (JSON) ───────────────────────────
Route::get('/books/{book}/comments', [BookInteractionController::class, 'getComments'])->name('books.comments');

// ── Authenticated: Interactions (JSON API) ──────────────────
Route::middleware('auth')->group(function () {
    Route::post('/books/{book}/like', [BookInteractionController::class, 'toggleLike'])->name('books.like');
    Route::post('/books/{book}/bookmark', [BookInteractionController::class, 'toggleBookmark'])->name('books.bookmark');
    Route::post('/books/{book}/comment', [BookInteractionController::class, 'storeComment'])->name('books.comment');
    Route::post('/reader/progress', [ReaderController::class, 'updateProgress'])->name('reader.progress');

    // User Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

// ── Admin Resource Routes ───────────────────────────────────
Route::resource('levels', LevelController::class);
Route::resource('books', BookController::class)->except(['show']);
Route::resource('reads', ReadController::class);
Route::resource('authors', AuthorController::class);
Route::resource('publishers', PublisherController::class);
Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
});

Route::get('/setup-db-rahasia', function () {
    try {
        // Menjalankan migrasi secara paksa di mode production
        Artisan::call('migrate', ['--force' => true]);
        
        // (Opsional) Menjalankan seeder untuk mengisi data awal
        Artisan::call('db:seed', ['--force' => true]);
        
        return 'Tabel Database dan Data Awal Berhasil Dibuat!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
