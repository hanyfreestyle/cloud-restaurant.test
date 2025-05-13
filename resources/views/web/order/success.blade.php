@extends('web.layouts.app')

@section('title', __('Order Confirmation'))

@section('content')
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <div class="d-inline-flex justify-content-center align-items-center bg-success text-white rounded-circle mb-4" style="width: 80px; height: 80px;">
                <i class="fas fa-check fa-3x"></i>
            </div>
            <h1 class="mb-3">{{ __('Thank you for your order!') }}</h1>
            <p class="lead">{{ $message ?? __('Your order has been received and is now being processed.') }}</p>
            
            @if(isset($orderId))
                <div class="mb-4">
                    <span class="badge bg-primary">{{ __('Order Number') }}: {{ $orderId }}</span>
                </div>
            @endif
        </div>
        
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-4">{{ __('What happens next?') }}</h5>
                        
                        <div class="d-flex mb-3">
                            <div class="me-3 text-primary">
                                <div class="d-flex justify-content-center align-items-center bg-primary bg-opacity-10 rounded-circle" style="width: 40px; height: 40px;">
                                    <i class="fas fa-utensils"></i>
                                </div>
                            </div>
                            <div>
                                <h6>{{ __('Order Preparation') }}</h6>
                                <p class="text-muted mb-0">{{ __('Our chefs are preparing your delicious meal with care.') }}</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            <div class="me-3 text-warning">
                                <div class="d-flex justify-content-center align-items-center bg-warning bg-opacity-10 rounded-circle" style="width: 40px; height: 40px;">
                                    <i class="fas fa-box"></i>
                                </div>
                            </div>
                            <div>
                                <h6>{{ __('Packaging') }}</h6>
                                <p class="text-muted mb-0">{{ __('Your order will be carefully packaged to maintain its quality and temperature.') }}</p>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                            <div class="me-3 text-success">
                                <div class="d-flex justify-content-center align-items-center bg-success bg-opacity-10 rounded-circle" style="width: 40px; height: 40px;">
                                    <i class="fas fa-truck"></i>
                                </div>
                            </div>
                            <div>
                                <h6>{{ __('Delivery') }}</h6>
                                <p class="text-muted mb-0">{{ __('Our delivery driver will bring your order to your doorstep.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="{{ route('menu') }}" class="btn btn-primary">
                        <i class="fas fa-utensils me-2"></i> {{ __('Continue Shopping') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection