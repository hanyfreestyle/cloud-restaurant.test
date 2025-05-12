@extends('web.layouts.app')

@section('title', __('Order Successful'))

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body text-center p-5">
                            <div class="mb-4">
                                <i class="fas fa-check-circle fa-5x text-success"></i>
                            </div>
                            
                            <h2 class="mb-4">{{ __('Order Successful!') }}</h2>
                            
                            <p class="lead mb-4">{{ __('Thank you for your order. We\'ve received your order and will begin processing it right away.') }}</p>
                            
                            @if(session('last_order_id'))
                                <div class="alert alert-light mb-4">
                                    <p class="mb-0">{{ __('Order ID') }}: <strong>{{ session('last_order_id') }}</strong></p>
                                </div>
                            @endif
                            
                            <p>{{ __('You\'ll receive a confirmation with the details of your order shortly.') }}</p>
                            
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-home me-2"></i> {{ __('Return Home') }}
                                </a>
                                <a href="{{ route('menu') }}" class="btn btn-primary">
                                    <i class="fas fa-utensils me-2"></i> {{ __('Order Again') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Timeline -->
                    <div class="card shadow-sm mt-4">
                        <div class="card-body p-4">
                            <h5 class="mb-4">{{ __('What happens next?') }}</h5>
                            
                            <div class="position-relative pt-2">
                                <div class="position-absolute top-0 start-0" style="width: 2px; height: 100%; background-color: #dee2e6; left: 10px;"></div>
                                
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0 bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; z-index: 1;">
                                        <i class="fas fa-check fa-xs text-white"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">{{ __('Order Received') }}</h6>
                                        <p class="text-muted small mb-0">{{ __('We\'ve received your order and are preparing it.') }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; z-index: 1;">
                                        <i class="fas fa-utensils fa-xs text-muted"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">{{ __('Food Preparation') }}</h6>
                                        <p class="text-muted small mb-0">{{ __('Our chefs are preparing your food with care.') }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex mb-4">
                                    <div class="flex-shrink-0 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; z-index: 1;">
                                        <i class="fas fa-box fa-xs text-muted"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">{{ __('Ready for Pickup/Delivery') }}</h6>
                                        <p class="text-muted small mb-0">{{ __('Your food will be ready for pickup or on its way for delivery.') }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex">
                                    <div class="flex-shrink-0 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; z-index: 1;">
                                        <i class="fas fa-smile fa-xs text-muted"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-1">{{ __('Enjoy Your Meal') }}</h6>
                                        <p class="text-muted small mb-0">{{ __('We hope you enjoy your meal. Bon appétit!') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection