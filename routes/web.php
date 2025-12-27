<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DishController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

// Public Routes (Menu)
Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/json', [CartController::class, 'getCart'])->name('cart.json');

// Cart Routes (AJAX)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Order Routes
Route::get('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
Route::post('/order/send-whatsapp', [OrderController::class, 'sendWhatsApp'])->name('order.send-whatsapp');

// Admin Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Dishes
    Route::resource('dishes', DishController::class);
    
    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('/settings/qr-download', [SettingController::class, 'downloadQrCode'])->name('settings.qr-download');
});
