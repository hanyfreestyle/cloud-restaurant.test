<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\MenuController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PageController;
use App\Http\Livewire\Web\CartComponent;
use App\Http\Livewire\Web\MenuComponent;
use App\Http\Livewire\Web\CheckoutComponent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


// This group applies the localization middleware
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['web', \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class, \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class, \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class]
    ],
    function() {
        // Home page
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Menu
        Route::get('/menu', [MenuController::class, 'index'])->name('menu');
        Route::post('/menu/add-to-cart', [MenuController::class, 'addToCart'])->name('menu.addToCart');
        Route::post('/menu/select-category', [MenuController::class, 'selectCategory'])->name('menu.selectCategory');

        // Cart
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
        Route::post('/cart/remove-item', [CartController::class, 'removeItem'])->name('cart.removeItem');
        Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

        // Checkout
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

        // Order confirmation
        Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');

        // Static pages
        Route::get('/about', [PageController::class, 'about'])->name('about');
        Route::get('/contact', [PageController::class, 'contact'])->name('contact');
        Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
        Route::get('/faq', [PageController::class, 'faq'])->name('faq');
    }
);
