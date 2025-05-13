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
{{--        <div class="text-center mb-4 category-menu sticky-top bg-white py-3 shadow-sm" style="top: 60px; z-index: 99;">--}}
{{--            <div class="d-flex flex-wrap justify-content-center">--}}
{{--                @foreach($categories as $index => $category)--}}
{{--                    <button --}}
{{--                        type="button"--}}
{{--                        id="cat-btn-{{ $category->id }}"--}}
{{--                        class="category-btn btn btn-outline-primary mx-1 mb-2 {{ $index === 0 ? 'active' : '' }}"--}}
{{--                        data-cat-id="{{ $category->id }}"--}}
{{--                    >--}}
{{--                        {{ $category->name }}--}}
{{--                    </button>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Show all categories with their products -->
        @foreach($categoriesWithProducts as $category)
            <div id="cat-{{ $category->id }}" class="mb-5 category-section" data-cat-id="{{ $category->id }}">
                <h2 class="mb-4 pb-2 border-bottom">{{ $category->name }}</h2>

                <div class="row g-4">
                    @forelse($category->products as $product)
                        <div class="col-md-6 col-lg-4">
                            <div class="card menu-item shadow-sm h-100">
                                <!-- Ejemplo de imagen desde pexels -->
                                <img
                                    src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=600"
                                    class="card-img-top menu-item-image"
                                    alt="{{ $product->name }}"
                                >

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
                                                    <!-- Ejemplo de imagen desde pexels -->
                                                    <img
                                                        src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=600"
                                                        class="img-fluid rounded w-100"
                                                        style="max-height: 200px; object-fit: cover;"
                                                        alt="{{ $product->name }}"
                                                    >
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تسجيل الاحداث للازرار
    var categoryButtons = document.querySelectorAll('.category-btn');

    categoryButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var categoryId = this.getAttribute('data-cat-id');
            scrollToCategory(categoryId);
        });
    });

    // وظيفة للتمرير إلى القسم
    function scrollToCategory(categoryId) {
        // العثور على القسم بمعرفه
        var section = document.getElementById('cat-' + categoryId);

        if (section) {
            // تحديث زر الفئة النشطة
            document.querySelectorAll('.category-btn').forEach(function(btn) {
                btn.classList.remove('active');
            });
            document.getElementById('cat-btn-' + categoryId).classList.add('active');

            // حساب المسافة للتمرير
            var offsetTop = section.offsetTop;
            var headerOffset = 120; // ارتفاع الرأس

            window.scrollTo({
                top: offsetTop - headerOffset,
                behavior: 'smooth'
            });
        }
    }

    // معالجة أزرار الكمية
    document.querySelectorAll('.decrease-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = this.parentNode.querySelector('.quantity-input');
            var value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
            }
        });
    });

    document.querySelectorAll('.increase-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var input = this.parentNode.querySelector('.quantity-input');
            var value = parseInt(input.value);
            if (value < 10) {
                input.value = value + 1;
            }
        });
    });

    // تتبع التمرير لتحديث الزر النشط
    window.addEventListener('scroll', function() {
        var scrollPosition = window.scrollY + 150;

        document.querySelectorAll('.category-section').forEach(function(section) {
            var sectionTop = section.offsetTop;
            var sectionHeight = section.offsetHeight;
            var categoryId = section.getAttribute('data-cat-id');

            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                document.querySelectorAll('.category-btn').forEach(function(btn) {
                    btn.classList.remove('active');
                });

                var activeBtn = document.getElementById('cat-btn-' + categoryId);
                if (activeBtn) {
                    activeBtn.classList.add('active');
                }
            }
        });
    });

    // تعزيز انتقاء المتغيرات في المودال
    document.querySelectorAll('.variant-selector').forEach(function(input) {
        var listItem = input.closest('.list-group-item');

        listItem.addEventListener('click', function(e) {
            if (e.target !== input) {
                input.checked = true;
                var event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            }
        });

        input.addEventListener('change', function() {
            var modal = this.closest('.modal');
            modal.querySelectorAll('.list-group-item').forEach(function(item) {
                item.classList.remove('active', 'bg-light');
            });

            if (this.checked) {
                listItem.classList.add('active', 'bg-light');
            }
        });
    });

    // اختيار أول متغير افتراضيًا عند فتح المودال
    var productModals = document.querySelectorAll('.modal');
    productModals.forEach(function(modal) {
        modal.addEventListener('shown.bs.modal', function() {
            var firstInput = this.querySelector('.variant-selector');
            if (firstInput) {
                firstInput.checked = true;
                var event = new Event('change', { bubbles: true });
                firstInput.dispatchEvent(event);
            }
        });
    });
});
</script>
@endpush
