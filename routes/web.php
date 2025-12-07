<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VisitorCountController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Route xử lý form (POST)
Route::post('/contact', [ContactController::class, 'submitContactForm'])->name('contact.submit');

// Product routes - PUBLIC
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');

// Blog routes - PUBLIC (không cần đăng nhập)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');

// =========================================================
// 🔥 AUTH & LOGOUT ROUTES
// =========================================================

// Route Đăng nhập/Đăng ký cho User thường
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Đăng xuất User thường

// Route Đăng nhập/Đăng xuất cho Admin
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);
Route::post('/admin/logout', [AuthController::class, 'adminLogout'])->name('admin.logout'); // 🔥 ROUTE MỚI: Đăng xuất Admin

// =========================================================

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

// Admin Routes - CHỈ cho admin đã đăng nhập
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/visitors', [AdminController::class, 'visitors'])->name('visitors');

    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');

    Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
    Route::post('/messages/{id}/toggle-handled', [AdminController::class, 'toggleMessageHandled'])->name('messages.toggle.handled');


    // Product routes
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    // Low Stock items routes
    Route::get('/products/low-stock', [AdminController::class, 'lowStock'])->name('products.low-stock');
    Route::get('/products/create', [AdminController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [AdminController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [AdminController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroy'])->name('products.destroy');

    // Category routes
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{id}', [AdminController::class, 'showCategory'])->name('categories.show');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    // User routes
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Blog routes - TRANG ADMIN QUẢN LÝ BLOG (yêu cầu đăng nhập admin)
    Route::get('/blog', [AdminController::class, 'blogIndex'])->name('blog.index');
    Route::get('/blog/create', [AdminController::class, 'blogCreate'])->name('blog.create');
    Route::post('/blog', [AdminController::class, 'blogStore'])->name('blog.store');
    Route::get('/blog/{id}', [AdminController::class, 'blogShow'])->name('blog.show');
    Route::get('/blog/{id}/edit', [AdminController::class, 'blogEdit'])->name('blog.edit');
    Route::put('/blog/{id}', [AdminController::class, 'blogUpdate'])->name('blog.update');
    Route::delete('/blog/{id}', [AdminController::class, 'blogDestroy'])->name('blog.destroy');
});

// Route download, nhận ProductID
Route::get('/product/{id}/download', [ProductController::class, 'downloadFile'])->name('product.download');