<?php

use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin / CMS Routes
|--------------------------------------------------------------------------
| Semua route di sini otomatis diberi prefix "admin/" dan nama "admin.*",
| serta dilindungi middleware auth + role:admin (lihat bootstrap/app.php
| untuk registrasi alias 'role').
|
| Daftarkan file ini di bootstrap/app.php atau routes/web.php dengan:
| Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])
|     ->group(base_path('routes/admin.php'));
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Master User
Route::delete('/users/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('users.bulk-destroy');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Master Produk
Route::delete('/products/bulk-destroy', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');
Route::resource('products', ProductController::class)->except(['show']);
Route::post('/products/{product}/images', [ProductController::class, 'uploadImage'])->name('products.images.store');
Route::delete('/products/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.destroy');
Route::patch('/products/images/{image}/set-primary', [ProductController::class, 'setPrimaryImage'])->name('products.images.primary');
Route::post('/products/{product}/images/reorder', [ProductController::class, 'reorderImages'])->name('products.images.reorder');

// Master Kategori
Route::delete('/categories/bulk-destroy', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
Route::resource('categories', CategoryController::class)->except(['show']);

// Kelola Review
Route::delete('/reviews/bulk-destroy', [ProductReviewController::class, 'bulkDestroy'])->name('reviews.bulk-destroy');
Route::get('/reviews', [ProductReviewController::class, 'index'])->name('reviews.index');
Route::patch('/reviews/{review}/approve', [ProductReviewController::class, 'approve'])->name('reviews.approve');
Route::delete('/reviews/{review}/reject', [ProductReviewController::class, 'reject'])->name('reviews.reject');

// Pesanan
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

/*
|--------------------------------------------------------------------------
| Website Settings (Modul 4.5)
|--------------------------------------------------------------------------
*/
Route::prefix('settings')->name('settings.')->group(function () {
    // Navbar / Menu
    Route::delete('/menus/bulk-destroy', [MenuController::class, 'bulkDestroy'])->name('menus.bulk-destroy');
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::post('/menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

    // Slider Home
    Route::delete('/sliders/bulk-destroy', [SliderController::class, 'bulkDestroy'])->name('sliders.bulk-destroy');
    Route::resource('sliders', SliderController::class)->except(['show']);

    // Blog / News
    Route::delete('/blog-categories/bulk-destroy', [BlogCategoryController::class, 'bulkDestroy'])->name('blog-categories.bulk-destroy');
    Route::resource('blog-categories', BlogCategoryController::class)->parameters(['blog-categories' => 'category'])->except(['show']);
    Route::delete('/blogs/bulk-destroy', [BlogController::class, 'bulkDestroy'])->name('blogs.bulk-destroy');
    Route::resource('blogs', BlogController::class)->except(['show']);

    // Halaman Tentang Kami — Tim
    Route::delete('/team-members/bulk-destroy', [TeamMemberController::class, 'bulkDestroy'])->name('team-members.bulk-destroy');
    Route::resource('team-members', TeamMemberController::class)->except(['show']);

    // Informasi Umum (site_settings)
    Route::get('/general', [SiteSettingController::class, 'edit'])->name('general.edit');
    Route::put('/general', [SiteSettingController::class, 'update'])->name('general.update');
});
