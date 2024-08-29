<?php

use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AuthenticatedAdminSessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\NotAdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(NotAdminMiddleware::class)->group(function () {
    Route::get('/', [HomeController::class,'index'])->name('home');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(NotAdminMiddleware::class)->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/add/to/cart/{productId}', [ProductController::class, 'addToCart'])->name('cart.add');
        Route::get('/cart', [CartController::class, 'index'])->name('cart.show');
        Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity']);
        Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
        Route::delete('/cart/remove/{id}', [CartController::class, 'removeCartItem'])->name('cart.removeItem');
        Route::get('/myOrders', [OrderController::class, 'index'])->name('myOrders');
        Route::delete('/myOrders/remove/{id}', [OrderController::class, 'destroy'])->name('remove.order');
        Route::get('/myOrders/order/{id}', [OrderController::class, 'show'])->name('show.order');
    });
});
Route::get('/product/show/{productId}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/products/{id}', [CategoryController::class, 'show'])->name('category.products');
Route::prefix('admin')->group(function(){
    Route::middleware(IsAdminMiddleware::class)->group(function () {
        Route::get('/home', [AdminHomeController::class, 'index'])->name('admin.home');
        Route::get('/create/category&product', [CategoryController::class, 'listForAdmin'])->name('create.categoriesAndProducts');
        Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update-admin');
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit-admin');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/create/category&product/category/remove/{itemId}', [CategoryController::class, 'remove']);
        Route::post('/products/save', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products', [ProductController::class, 'index'])->name('admin.products');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::post('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}/remove', [ProductController::class, 'destroy'])->name('products.remove');
        Route::post('/products/{id}/image/update/main', [ProductImageController::class, 'setMain'])->name('productImages.setMain');
        Route::delete('/products/{id}/remove/image', [ProductImageController::class, 'destroy'])->name('productImages.remove');
        Route::get('/allOrders', [OrderController::class, 'all'])->name('allOrders');
        Route::get('/allOrders/order/{id}', [OrderController::class, 'showAdmin'])->name('admin.show.order');
        Route::post('/allOrders/order/status_change/{id}', [OrderController::class, 'changeStatus'])->name('change.order.status');
    });
    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name)->plainTextToken;
        return redirect()->back()->with(['token' => $token]);
    })->name('tokens.create');
    Route::get('/login', [AuthenticatedAdminSessionController::class, 'create'])->name('admin.login');
    Route::post('/login', [AuthenticatedAdminSessionController::class, 'store'])->name('admin.login.submit');

});



require __DIR__.'/auth.php';
