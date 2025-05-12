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


// This group applies the localization middleware
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function() {
        // Home page
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Menu
        Route::get('/menu', MenuComponent::class)->name('menu');

        // Cart
        Route::get('/cart', CartComponent::class)->name('cart');

        // Checkout
        Route::get('/checkout', CheckoutComponent::class)->name('checkout');

        // Order confirmation
        Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');

        // Static pages
        Route::get('/about', [PageController::class, 'about'])->name('about');
        Route::get('/contact', [PageController::class, 'contact'])->name('contact');
        Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
        Route::get('/faq', [PageController::class, 'faq'])->name('faq');
    }
);
