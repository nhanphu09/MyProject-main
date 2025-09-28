<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/* 🔐 Auth routes */
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerSave'])->name('register.save');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginAction'])->name('login.action');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* 👤 User routes */
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/* 🛠️ Admin routes */
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
 
    Route::get('/admin/profile', [AdminController::class, 'profilepage'])->name('admin.profile');
 
    Route::prefix('/admin/products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.products');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('admin.products.show');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/edit/{id}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    });
});

/* 🛒 Products (user view) */
Route::get('/products', [ProductController::class, 'userIndex'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

/* 🛒 Cart */
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/cart/data', [CartController::class, 'getCart'])->name('cart.data');

/* 🔍 Search */
Route::get('/search', [SearchController::class, 'search'])->name('search');
