<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Livewire::component('web.cart-counter', \App\Http\Livewire\Web\CartCounter::class);
        Livewire::component('web.menu-component', \App\Http\Livewire\Web\MenuComponent::class);
        Livewire::component('web.cart-component', \App\Http\Livewire\Web\CartComponent::class);
        Livewire::component('web.checkout-component', \App\Http\Livewire\Web\CheckoutComponent::class);
    }
}
