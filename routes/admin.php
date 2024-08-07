<?php 

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageGalleryController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\SellerProductController;
use Illuminate\Support\Facades\Route;

/** Admin routes */
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

/** Profile routes */
Route::get('profile', [ProfileController::class, 'index'])->name('profile');
Route::post('profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::post('password/update', [ProfileController::class, 'updatePassword'])->name('password.update');

/** Slider routes */
Route::resource('slider', SliderController::class);

/** Category routes */
Route::resource('category', CategoryController::class);

/** Sub Category routes */
Route::resource('sub-category', SubCategoryController::class);

/** Child Category routes */
Route::get('get-subcategories', [ChildCategoryController::class, 'getSubCategories'])->name('get-subcategories');
Route::resource('child-category', ChildCategoryController::class);

/** Brand routes */
Route::resource('brand', BrandController::class);

/** Vendor profile routes */
Route::resource('vendor-profile', AdminVendorProfileController::class);

/** Product routes */
Route::get('product/get-subcategories', [ProductController::class, 'getSubCategories'])->name('product.get-subcategories');
Route::get('product/get-childcategories', [ProductController::class, 'getChildCategories'])->name('product.get-childcategories');
Route::resource('product', ProductController::class);
/** Product image routes */
Route::resource('product-image-gallery', ProductImageGalleryController::class);
/** Product variant routes */
Route::resource('product-variant', ProductVariantController::class);
/** Product variant item */
Route::get('product-variant-item/{productId}/{variantId}', [ProductVariantItemController::class, 'index'])
    ->name('product-variant-item.index');
Route::get('product-variant-item/create/{productId}/{variantId}', [ProductVariantItemController::class, 'create'])
    ->name('product-variant-item.create');
Route::post('product-variant-item', [ProductVariantItemController::class, 'store'])
    ->name('product-variant-item.store');
Route::get('product-variant-item-edit/{variantItemId}', [ProductVariantItemController::class, 'edit'])
    ->name('product-variant-item.edit');
Route::put('product-variant-item-update/{variantItemId}', [ProductVariantItemController::class, 'update'])
    ->name('product-variant-item.update');
Route::delete('product-variant-item/{variantItemId}', [ProductVariantItemController::class, 'destroy'])
    ->name('product-variant-item.destroy');

/** Seller product routes */
Route::get('seller-product/', [SellerProductController::class, 'index'])->name('seller-product.index');
Route::get('seller-pending-product/', [SellerProductController::class, 'pendingProducts'])->name('seller-pending-product.index');
Route::put('change-approve-status/', [SellerProductController::class, 'changeApproveStatus'])->name('change-approve-status');

/** Flash Sale routes */
Route::get('flash-sale/', [FlashSaleController::class, 'index'])->name('flash-sale.index');
Route::put('flash-sale/', [FlashSaleController::class, 'update'])->name('flash-sale.update');
Route::post('flash-sale/add-product', [FlashSaleController::class, 'addProduct'])->name('flash-sale.add-product');
Route::put('flash-sale/show-at-home/status-change', [FlashSaleController::class, 'changeShowAtHomeStatus'])->name('flash-sale.show-at-home.change-status');
Route::put('flash-sale-status', [FlashSaleController::class, 'changeStatus'])->name('flash-sale-status');
Route::delete('flash-sale/{id}', [FlashSaleController::class, 'destroy'])->name('flash-sale.destroy');
