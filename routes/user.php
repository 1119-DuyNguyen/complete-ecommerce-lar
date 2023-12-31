<?php

use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\UserAddressController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::resource('wishlist', WishlistController::class)->only(['index', 'store', 'destroy']);
/** Profile Routes */
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');
Route::get('checkout', [CheckOutController::class, 'index'])->name('checkout');

/** Wishlist routes */
Route::middleware('hasPermission')->group(function () {

    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    /** Order Routes */
    Route::get('orders', [UserOrderController::class, 'index'])->name('order.index');
    Route::get('orders/{id}', [UserOrderController::class, 'show'])->name('order.show');

    /** COD routes */
    Route::post('cod/payment', [PaymentController::class, 'payWithCod'])->name('cod.payment');
});
