@extends('web.layouts.app')

@section('title', __('Menu'))

@section('content')
<section class="py-5">
    <div class="container" id="products-container">
        <h1 class="text-center mb-5">{{ __('Our Menu') }}</h1>
        
        <!-- Session Messages -->
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Categories menu -->
        <div class="text-center mb-4">
            <div class="d-flex flex-wrap justify-content-center">
                @foreach($categories as $category)
                    <form action="{{ route('menu.selectCategory') }}" method="POST" class="d-inline-block mx-1 mb-2">
                        @csrf
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <button 
                            type="submit" 
                            class="btn btn-outline-primary {{ $activeCategory == $category->id ? 'active' : '' }}"
                        >
                            {{ $category->name }}
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
        
        <!-- Products grid -->
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card menu-item shadow-sm h-100">
                        @if($product->getFirstMediaUrl('products'))
                            <img 
                                src="{{ $product->getFirstMediaUrl('products') }}" 
                                class="card-img-top menu-item-image" 
                                alt="{{ $product->name }}"
                            >
                        @else
                            <div class="bg-light menu-item-image d-flex align-items-center justify-content-center">
                                <i class="fas fa-utensils fa-3x text-muted"></i>
                            </div>
                        @endif
                        
                        @if($product->regular_price > $product->price)
                            <div class="menu-item-badge">
                                {{ __('Sale') }}
                            </div>
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($product->description, 80) }}</p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-bold text-primary">{{ number_format($product->price, 2) }} EGP</span>
                                        @if($product->regular_price > $product->price)
                                            <small class="text-muted text-decoration-line-through ms-2">
                                                {{ number_format($product->regular_price, 2) }} EGP
                                            </small>
                                        @endif
                                    </div>
                                    
                                    @if($product->productVariants->count() > 0)
                                        <button 
                                            type="button"
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#productModal{{ $product->id }}"
                                        >
                                            <i class="fas fa-plus me-1"></i> {{ __('Add') }}
                                        </button>
                                    @else
                                        <form action="{{ route('menu.addToCart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="direct_add" value="1">
                                            <button 
                                                type="submit"
                                                class="btn btn-sm btn-primary"
                                            >
                                                <i class="fas fa-plus me-1"></i> {{ __('Add') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Modal for variants -->
                @if($product->productVariants->count() > 0)
                <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $product->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('menu.addToCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                
                                <div class="modal-body">
                                    <div class="mb-4">
                                        @if($product->getFirstMediaUrl('products'))
                                            <img 
                                                src="{{ $product->getFirstMediaUrl('products') }}" 
                                                class="img-fluid rounded w-100" 
                                                style="max-height: 200px; object-fit: cover;"
                                                alt="{{ $product->name }}"
                                            >
                                        @endif
                                    </div>
                                    
                                    <p class="text-muted mb-4">{{ $product->description }}</p>
                                    
                                    <div class="mb-4">
                                        <h6>{{ __('Select Option') }}</h6>
                                        <div class="list-group">
                                            @foreach($product->productVariants as $variant)
                                                <label class="list-group-item d-flex gap-2 cursor-pointer">
                                                    <input 
                                                        type="radio" 
                                                        name="variant_id" 
                                                        value="{{ $variant->id }}"
                                                        class="form-check-input flex-shrink-0 variant-selector" 
                                                        required
                                                    >
                                                    <span class="w-100 d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">{{ $variant->name }}</span>
                                                        <span class="badge bg-primary rounded-pill">{{ number_format($variant->price_modifier, 2) }} EGP</span>
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h6>{{ __('Quantity') }}</h6>
                                        <div class="quantity-control">
                                            <button type="button" class="quantity-btn decrease-btn">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" name="quantity" class="quantity-input" value="1" min="1" max="10">
                                            <button type="button" class="quantity-btn increase-btn">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        {{ __('Cancel') }}
                                    </button>
                                    <button 
                                        type="submit" 
                                        class="btn btn-primary"
                                    >
                                        {{ __('Add to Cart') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @empty
                <div class="col-12 text-center py-5">
                    <i class="fas fa-utensils fa-3x mb-3 text-muted"></i>
                    <p>{{ __('No products found in this category.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation class to menu items for staggered entrance
        const menuItems = document.querySelectorAll('.menu-item');
        if (menuItems.length) {
            menuItems.forEach((item, index) => {
                setTimeout(() => {
                    item.classList.add('show');
                }, 100 * index);
            });
        }
        
        // Handle quantity buttons
        document.querySelectorAll('.decrease-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentNode.querySelector('.quantity-input');
                const value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                }
            });
        });
        
        document.querySelectorAll('.increase-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentNode.querySelector('.quantity-input');
                const value = parseInt(input.value);
                if (value < 10) {
                    input.value = value + 1;
                }
            });
        });
        
        // Enhance variants selection visibility
        document.querySelectorAll('.variant-selector').forEach(input => {
            // Add click handler to the entire list item, not just the radio button
            const listItem = input.closest('.list-group-item');
            
            listItem.addEventListener('click', function(e) {
                // If click is on the label or span and not on the radio button itself,
                // manually trigger the radio button
                if (e.target !== input) {
                    input.checked = true;
                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    input.dispatchEvent(event);
                }
            });
            
            input.addEventListener('change', function() {
                // Remove active class from all variant containers in this modal
                const modal = this.closest('.modal');
                modal.querySelectorAll('.list-group-item').forEach(item => {
                    item.classList.remove('active', 'bg-light');
                });
                
                // Add active class to selected variant
                if (this.checked) {
                    listItem.classList.add('active', 'bg-light');
                }
            });
        });
        
        // Select the first variant by default when opening modal
        const productModals = document.querySelectorAll('.modal');
        productModals.forEach(modal => {
            modal.addEventListener('shown.bs.modal', function() {
                const firstInput = this.querySelector('.variant-selector');
                if (firstInput) {
                    firstInput.checked = true;
                    const event = new Event('change', { bubbles: true });
                    firstInput.dispatchEvent(event);
                }
            });
        });
    });
</script>
@endpush
