@extends('web.layouts.app')

@section('title', __('Cart'))

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="text-center mb-5">{{ __('Your Cart') }}</h1>
        
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
        
        @if($cartItems->count() > 0)
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 100px">{{ __('Image') }}</th>
                                <th>{{ __('Product') }}</th>
                                <th style="width: 120px">{{ __('Price') }}</th>
                                <th style="width: 150px">{{ __('Quantity') }}</th>
                                <th style="width: 120px">{{ __('Total') }}</th>
                                <th style="width: 80px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        @if(isset($item->options['image']) && $item->options['image'])
                                            <img 
                                                src="{{ $item->options['image'] }}" 
                                                class="img-fluid rounded" 
                                                style="max-width: 80px; max-height: 80px; object-fit: cover;" 
                                                alt="{{ $item->name }}"
                                            >
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                <i class="fas fa-utensils fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-1">{{ $item->name }}</h6>
                                        @if(isset($item->options['variant_name']) && $item->options['variant_name'])
                                            <small class="text-muted">{{ $item->options['variant_name'] }}</small>
                                        @endif
                                    </td>
                                    <td>{{ number_format($item->price, 2) }} EGP</td>
                                    <td>
                                        <form action="{{ route('cart.updateQuantity') }}" method="POST" class="quantity-form">
                                            @csrf
                                            <input type="hidden" name="row_id" value="{{ $item->rowId }}">
                                            <div class="quantity-control">
                                                <button 
                                                    type="button" 
                                                    class="quantity-btn decrease-btn"
                                                >
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" name="qty" class="quantity-input" value="{{ $item->qty }}" min="1" max="10">
                                                <button 
                                                    type="button" 
                                                    class="quantity-btn increase-btn"
                                                >
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="fw-bold">{{ number_format($item->subtotal, 2) }} EGP</td>
                                    <td>
                                        <form action="{{ route('cart.removeItem') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="row_id" value="{{ $item->rowId }}">
                                            <button 
                                                type="submit" 
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-trash me-2"></i> {{ __('Clear Cart') }}
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h5>{{ __('Total') }}</h5>
                                <h5>{{ $cartTotal }} EGP</h5>
                            </div>
                            <a href="{{ route('checkout') }}" class="btn btn-primary w-100">
                                <i class="fas fa-check me-2"></i> {{ __('Proceed to Checkout') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart-container">
                <i class="fas fa-shopping-cart empty-cart-icon"></i>
                <h4>{{ __('Your cart is empty') }}</h4>
                <p class="text-muted">{{ __('Looks like you haven\'t added anything to your cart yet.') }}</p>
                <a href="{{ route('menu') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-utensils me-2"></i> {{ __('Browse Menu') }}
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle quantity buttons
        document.querySelectorAll('.decrease-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('.quantity-form');
                const input = form.querySelector('.quantity-input');
                const value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                    form.submit();
                }
            });
        });
        
        document.querySelectorAll('.increase-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('.quantity-form');
                const input = form.querySelector('.quantity-input');
                const value = parseInt(input.value);
                if (value < 10) {
                    input.value = value + 1;
                    form.submit();
                }
            });
        });
    });
</script>
@endpush