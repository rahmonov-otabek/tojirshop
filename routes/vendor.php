<?php 

use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Backend\VendorProductImageGalleryController;
use App\Http\Controllers\Backend\VendorProfileController;
use App\Http\Controllers\Backend\VendorShopProfileController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
Route::get('profile', [VendorProfileController::class, 'index'])->name('profile'); # vendor.profile
Route::put('profile', [VendorProfileController::class, 'updateProfile'])->name('profile.update'); 
Route::post('profile', [VendorProfileController::class, 'updatePassword'])->name('profile.update.password'); 

/** Vendor shop profile routes */
Route::resource('shop-profile', VendorShopProfileController::class);

/** Product routes */
Route::get('product/get-subcategories', [VendorProductController::class, 'getSubCategories'])->name('product.get-subcategories');
Route::get('product/get-childcategories', [VendorProductController::class, 'getChildCategories'])->name('product.get-childcategories');
Route::resource('product', VendorProductController::class);

/** Product image routes */
Route::resource('product-image-gallery', VendorProductImageGalleryController::class);
