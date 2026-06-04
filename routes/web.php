<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\TransactionController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/home/addCart', [HomeController::class, 'addCart'])->name('home.addCart');
Route::post('/home/addWishlist', [HomeController::class, 'addWishlist'])->name('home.addWishlist');
Route::post('/home/delCart', [HomeController::class, 'delCart'])->name('home.delCart');
Route::post('/home/delWishlist', [HomeController::class, 'delWishlist'])->name('home.delWishlist');

Route::get('/product', [ProductController::class, 'index'])->name('product');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/logout', [LogoutController::class, 'index'])->name('logout');

// Auth-required routes
Route::middleware('user')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::get('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/finish', [CheckoutController::class, 'finish'])->name('checkout.finish');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
});

// Admin routes
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::post('/category/save', [CategoryController::class, 'save'])->name('admin.category.save');
    Route::post('/category/delete', [CategoryController::class, 'delete'])->name('admin.category.delete');

    Route::get('/product', [AdminProductController::class, 'index'])->name('admin.product');
    Route::post('/product/save', [AdminProductController::class, 'save'])->name('admin.product.save');
    Route::post('/product/delete', [AdminProductController::class, 'delete'])->name('admin.product.delete');

    Route::get('/user', [UserController::class, 'index'])->name('admin.user');
    Route::post('/user/save', [UserController::class, 'save'])->name('admin.user.save');
    Route::post('/user/delete', [UserController::class, 'delete'])->name('admin.user.delete');

    Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer');

    Route::get('/transaction', [TransactionController::class, 'index'])->name('admin.transaction');
    Route::get('/transaction/detail', [TransactionController::class, 'detail'])->name('admin.transaction.detail');
});
