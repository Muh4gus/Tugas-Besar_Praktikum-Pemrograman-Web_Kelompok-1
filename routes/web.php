<?php

use App\Http\Controllers\Admin\AuctionItemController as AdminAuctionItemController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route Publik (Bisa diakses siapa saja)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
Route::get('/auctions/{id}', [AuctionController::class, 'show'])->name('auctions.show');

// Route Auth (Hanya untuk Tamu / Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Route User Terautentikasi (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard User
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-bids', [UserDashboardController::class, 'myBids'])->name('my-bids');
    Route::get('/won-auctions', [UserDashboardController::class, 'wonAuctions'])->name('won-auctions');
    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');

    // Fitur Bidding (Penawaran)
    Route::post('/bids', [BidController::class, 'store'])->name('bids.store');
    Route::get('/bids/{auctionId}/history', [BidController::class, 'history'])->name('bids.history');
});

// Route Khusus Admin
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');

        // Manajemen Barang Lelang
        Route::resource('items', AdminAuctionItemController::class);
        Route::post('/items/{id}/validate-winner', [AdminAuctionItemController::class, 'validateWinner'])
            ->name('items.validate-winner');

        // Manajemen Kategori
        Route::resource('categories', AdminCategoryController::class);

        // Manajemen User (Pengguna)
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
        Route::put('/users/{id}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
        Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    });
