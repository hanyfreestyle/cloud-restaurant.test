@extends('web.layouts.app')

@section('title', __('Home'))

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">{{ __('Delicious Food Delivered to Your Door') }}</h1>
            <p class="lead mb-5">{{ __('Fresh ingredients, authentic recipes, and excellent service.') }}</p>
            <a href="{{ route('menu') }}" class="btn btn-primary btn-lg px-5 py-3">
                <i class="fas fa-utensils me-2"></i> {{ __('Order Now') }}
            </a>
        </div>
    </section>
    
    <!-- Categories Section -->
    @if(isset($categories) && $categories->count() > 0)
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('Explore Our Menu') }}</h2>
            
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-md-4">
                        <div class="card menu-item shadow-sm">
                            <div class="card-body text-center py-5">
                                <h4 class="mb-0">{{ $category->name }}</h4>
                            </div>
                            <div class="card-footer bg-white text-center border-0 pb-4">
                                <a href="{{ route('menu') }}" class="btn btn-outline-primary">
                                    {{ __('View Items') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    
    <!-- Featured Products Section -->
    @if(isset($featuredProducts) && $featuredProducts->count() > 0)
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('Popular Items') }}</h2>
            
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                    <div class="col-md-6 col-lg-3">
                        <div class="card menu-item shadow-sm h-100">
                            @if($product->image)
                                <img 
                                    src="{{ $product->image }}" 
                                    class="card-img-top menu-item-image" 
                                    alt="{{ $product->name }}"
                                >
                            @else
                                <div class="bg-light menu-item-image d-flex align-items-center justify-content-center">
                                    <i class="fas fa-utensils fa-3x text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($product->description, 60) }}</p>
                            </div>
                            
                            <div class="card-footer bg-white border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-primary">{{ number_format($product->price, 2) }} EGP</span>
                                    <a href="{{ route('menu') }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus me-1"></i> {{ __('Order') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('menu') }}" class="btn btn-outline-primary">
                    <i class="fas fa-utensils me-2"></i> {{ __('View Full Menu') }}
                </a>
            </div>
        </div>
    </section>
    @endif
    
    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('Why Choose Us') }}</h2>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-transparent h-100">
                        <div class="card-body text-center">
                            <div class="mb-4">
                                <i class="fas fa-truck-fast fa-3x text-primary"></i>
                            </div>
                            <h4>{{ __('Fast Delivery') }}</h4>
                            <p class="text-muted">{{ __('We deliver your order promptly to your door.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 bg-transparent h-100">
                        <div class="card-body text-center">
                            <div class="mb-4">
                                <i class="fas fa-leaf fa-3x text-primary"></i>
                            </div>
                            <h4>{{ __('Fresh Food') }}</h4>
                            <p class="text-muted">{{ __('We use only the freshest ingredients for your meals.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 bg-transparent h-100">
                        <div class="card-body text-center">
                            <div class="mb-4">
                                <i class="fas fa-headset fa-3x text-primary"></i>
                            </div>
                            <h4>{{ __('24/7 Support') }}</h4>
                            <p class="text-muted">{{ __('Our customer service is always available for you.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action Section -->
    <section class="py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80'); background-position: center; background-size: cover;">
        <div class="container text-center text-white py-5">
            <h2 class="mb-4">{{ __('Hungry? We\'ve Got You Covered') }}</h2>
            <p class="lead mb-5">{{ __('Order now and enjoy the best food experience from the comfort of your home.') }}</p>
            <a href="{{ route('menu') }}" class="btn btn-primary btn-lg px-5">{{ __('Order Now') }}</a>
        </div>
    </section>
@endsection