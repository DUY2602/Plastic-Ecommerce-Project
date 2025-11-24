<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User routes (require login)
Route::middleware(['auth.check'])->group(function () {
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
});

// Admin routes
Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
});
