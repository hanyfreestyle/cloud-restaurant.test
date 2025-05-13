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
        
        <!-- Categories menu - now for scrolling only -->
        <div class="text-center mb-4 category-menu sticky-top bg-white py-3 shadow-sm" style="top: 60px; z-index: 99;">
            <div class="d-flex flex-wrap justify-content-center">
                @foreach($categories as $category)
                    <button 
                        type="button"
                        class="btn btn-outline-primary mx-1 mb-2 {{ $activeCategory == $category->id ? 'active' : '' }}"
                        data-target="section-{{ $category->id }}"
                    >
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>
        
        <!-- Show all categories with their products -->
        @foreach($categoriesWithProducts as $category)
            <div id="section-{{ $category->id }}" class="mb-5 category-section">
                <h2 class="mb-4 pb-2 border-bottom" id="title-{{ $category->id }}">{{ $category->name }}</h2>
                
                <div class="row g-4">
                    @forelse($category->products as $product)
                        <div class="col-md-6 col-lg-4">
                            <div class="card menu-item shadow-sm h-100">
                                @if($product->getFirstMediaUrl('products'))
                                    <img 
                                        src="{{ $product->getFirstMediaUrl('products') }}" 
                                        class="card-img-top menu-item-image" 
                                        alt="{{ $product->name }}"
                                    >
                                @elseif($product->image)
                                    <img 
                                        src="{{ asset('storage/' . $product->image) }}" 
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
                                    <h5 class="card-title" title="{{ $product->name }}">{{ $product->name }}</h5>
                                    <p class="card-text text-muted small">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                                    
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
                                                    <i class="fas fa-cart-plus me-1"></i> {{ __('Add') }}
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
                                                        <i class="fas fa-cart-plus me-1"></i> {{ __('Add') }}
                                                    </button>
                                                </form>
                                            @endif
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
                                                    @elseif($product->image)
                                                        <img 
                                                            src="{{ asset('storage/' . $product->image) }}" 
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
                        </div>
                    @empty
                        <div class="col-12 text-center py-3">
                            <p class="text-muted">{{ __('No products available in this category.') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/scripts.js') }}"></script>
@endpush
