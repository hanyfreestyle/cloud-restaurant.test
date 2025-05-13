<div>
    <section class="py-5">
        <div class="container" id="products-container">
            <h1 class="text-center mb-5">{{ __('Our Menu') }}</h1>
            
            <!-- Loading Indicator -->
            <div wire:loading class="d-flex justify-content-center mb-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            
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
            
            <!-- Categories menu - now fixed at top for scrolling -->
            <div class="category-menu sticky-top bg-white py-3 shadow-sm mb-4" style="top: 60px; z-index: 99;">
                <div class="d-flex flex-wrap justify-content-center">
                    @foreach($categories as $category)
                        <button 
                            type="button"
                            class="btn btn-outline-primary mx-1 mb-2 {{ $loop->first ? 'active' : '' }}"
                            onclick="scrollToCategory('category-{{ $category->id }}');"
                        >
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
            
            <!-- Categories with Products - All shown in the same page -->
            @foreach($categoriesWithProducts as $category)
                <div id="category-{{ $category->id }}" class="mb-5 category-section">
                    <h2 class="mb-4 pb-2 border-bottom">{{ $category->name }}</h2>
                    
                    <div class="row g-4">
                        @forelse($category->products as $product)
                            <div class="col-md-6 col-lg-4">
                                <div class="card menu-item shadow-sm h-100">
    <!-- Ensure images are loaded properly from direct image field -->
    <!-- Since getFirstMediaUrl is not used anymore, use the direct image field -->
                                    @if($product->image)
                                        <img 
                                            src="{{ asset('storage/' . $product->image) }}" 
                                            class="card-img-top menu-item-image" 
                                            alt="{{ $product->name }}"
                                            loading="lazy"
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
                                                        wire:click="showProductVariants('{{ $product->id }}')"
                                                        class="btn btn-sm btn-primary"
                                                    >
                                                        <i class="fas fa-cart-plus me-1"></i> {{ __('Add') }}
                                                    </button>
                                                @else
                                                    <button 
                                                        wire:click="addToCart('{{ $product->id }}', true)"
                                                        class="btn btn-sm btn-primary"
                                                    >
                                                        <i class="fas fa-cart-plus me-1"></i> {{ __('Add') }}
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    
    <!-- Product Variant Modal -->
    @if($showVariantModal && $selectedProduct)
    <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $selectedProduct->name }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        @if($selectedProduct->image)
                            <img 
                                src="{{ asset('storage/' . $selectedProduct->image) }}" 
                                class="img-fluid rounded w-100" 
                                style="max-height: 200px; object-fit: cover;"
                                alt="{{ $selectedProduct->name }}"
                            >
                        @endif
                    </div>
                    
                    <p class="text-muted mb-4">{{ $selectedProduct->description }}</p>
                    
                    <div class="mb-4">
                        <h6>{{ __('Select Option') }}</h6>
                        <div class="list-group">
                            @foreach($selectedProduct->productVariants as $variant)
                                <label class="list-group-item d-flex gap-2 cursor-pointer">
                                    <input 
                                        type="radio" 
                                        name="variant" 
                                        class="form-check-input flex-shrink-0" 
                                        wire:click="selectVariant('{{ $variant->id }}', '{{ $variant->name }}')"
                                    >
                                    <span>
                                        <span class="fw-bold">{{ $variant->name }}</span>
                                        <small class="d-block text-muted">{{ number_format($variant->price_modifier, 2) }} EGP</small>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6>{{ __('Quantity') }}</h6>
                        <div class="quantity-control">
                            <button type="button" class="quantity-btn" wire:click="decrementQuantity">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="text" class="quantity-input" value="{{ $quantity }}" readonly>
                            <button type="button" class="quantity-btn" wire:click="incrementQuantity">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">
                        {{ __('Cancel') }}
                    </button>
                    <button 
                        type="button" 
                        class="btn btn-primary" 
                        wire:click="addToCart('{{ $selectedProduct->id }}')"
                        @if(empty($selectedVariants)) disabled @endif
                    >
                        {{ __('Add to Cart') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- JavaScript for smooth scrolling to categories -->
    <script>
        function scrollToCategory(categoryId) {
            const element = document.getElementById(categoryId);
            if (element) {
                // Update active button
                document.querySelectorAll('.btn-outline-primary').forEach(btn => {
                    btn.classList.remove('active');
                });
                event.target.classList.add('active');
                
                // Scroll to category
                const offset = 120; // Account for sticky header + category menu
                const elementPosition = element.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        }
        
        // Monitor scroll to update active category button
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('scroll', function() {
                const scrollPosition = window.scrollY + 150; // Add offset
                
                // Find the current visible section
                document.querySelectorAll('.category-section').forEach((section, index) => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    
                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        // Update active button
                        document.querySelectorAll('.btn-outline-primary').forEach(btn => {
                            btn.classList.remove('active');
                        });
                        
                        document.querySelectorAll('.btn-outline-primary')[index].classList.add('active');
                    }
                });
            });
        });
        
        document.addEventListener('livewire:load', function () {
            window.addEventListener('category-changed', event => {
                if (event.detail && event.detail.categoryId) {
                    scrollToCategory('category-' + event.detail.categoryId);
                }
            });
        });
    </script>
</div>
