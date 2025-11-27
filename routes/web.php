<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VisitorCountController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Favorite routes
Route::post('/favorite/toggle', [FavoriteController::class, 'toggle'])->name('favorite.toggle');
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

// Chat routes
Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');

// Visitor Count routes
Route::post('/visitor/increment', [VisitorCountController::class, 'incrementCount'])
    ->middleware('web')
    ->name('visitor.increment');

Route::get('/visitor/stats', [VisitorCountController::class, 'getTodayCount'])
    ->name('visitor.stats');

// User routes (require login)
Route::middleware(['auth.check'])->group(function () {
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
});

// Admin routes - GỘP TẤT CẢ VÀO ĐÂY
Route::prefix('admin')->middleware(['admin'])->group(function () {
    // Dashboard & Management
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User Management Routes
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Product Management
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}', [AdminController::class, 'show'])->name('admin.products.show');
    Route::get('/products/{id}/edit', [AdminController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{id}', [AdminController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroy'])->name('admin.products.destroy');

    // Category Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories/{id}', [AdminController::class, 'showCategory'])->name('admin.categories.show');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
});
