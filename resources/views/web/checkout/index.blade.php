@extends('web.layouts.app')

@section('title', __('Checkout'))

@section('content')
<section class="py-5">
    <div class="container">
        <h1 class="text-center mb-5">{{ __('Checkout') }}</h1>
        
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
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">{{ __('Delivery Information') }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
                            @csrf
                            
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label for="first_name" class="form-label">{{ __('First Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{ __('Phone Number') }} <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">{{ __('Delivery Address') }} <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="notes" class="form-label">{{ __('Order Notes') }}</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">{{ __('Payment Method') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" form="checkout-form" checked>
                            <label class="form-check-label" for="cash">
                                <i class="fas fa-money-bill-wave me-2 text-success"></i> {{ __('Cash on Delivery') }}
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" form="checkout-form">
                            <label class="form-check-label" for="credit_card">
                                <i class="fas fa-credit-card me-2 text-primary"></i> {{ __('Credit Card') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">{{ __('Order Summary') }}</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="d-flex mb-3">
                                <div class="me-3">
                                    @if(isset($item->options['image']) && $item->options['image'])
                                        <img 
                                            src="{{ $item->options['image'] }}" 
                                            class="img-fluid rounded" 
                                            style="width: 60px; height: 60px; object-fit: cover;" 
                                            alt="{{ $item->name }}"
                                        >
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                            <i class="fas fa-utensils text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $item->name }}</h6>
                                    @if(isset($item->options['variant_name']) && $item->options['variant_name'])
                                        <small class="text-muted">{{ $item->options['variant_name'] }}</small>
                                    @endif
                                    <div class="d-flex justify-content-between mt-1">
                                        <span class="text-muted">{{ $item->qty }} x {{ number_format($item->price, 2) }} EGP</span>
                                        <span class="fw-bold">{{ number_format($item->subtotal, 2) }} EGP</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('Subtotal') }}</span>
                            <span>{{ $cartTotal }} EGP</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ __('Delivery Fee') }}</span>
                            <span>15.00 EGP</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">{{ __('Total') }}</span>
                            <span class="fw-bold fs-5">{{ number_format(floatval(str_replace(',', '', $cartTotal)) + 15, 2) }} EGP</span>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100" form="checkout-form">
                            <i class="fas fa-check-circle me-2"></i> {{ __('Place Order') }}
                        </button>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-body bg-light">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-shield-alt text-success me-2"></i>
                            <span>{{ __('Secure Payment') }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-truck text-primary me-2"></i>
                            <span>{{ __('Fast Delivery') }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-undo-alt text-warning me-2"></i>
                            <span>{{ __('Easy Returns') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection