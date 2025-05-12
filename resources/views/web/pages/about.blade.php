@extends('web.layouts.app')

@section('title', __('About Us'))

@section('content')
    <!-- Hero Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold mb-4">{{ __('About Cloud Restaurant') }}</h1>
                    <p class="lead">{{ __('A passion for creating memorable dining experiences since 2010.') }}</p>
                    <p>{{ __('Cloud Restaurant was founded with a simple mission: to serve delicious, high-quality food that brings people together. What began as a small family business has grown into a beloved restaurant known for its authentic flavors and exceptional service.') }}</p>
                    <p>{{ __('We take pride in using only the freshest ingredients, sourced locally whenever possible, to create dishes that delight our customers.') }}</p>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1581349485608-9469926a8e5e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=764&q=80" class="img-fluid rounded shadow-sm" alt="Restaurant interior">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Story Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('Our Story') }}</h2>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 h-100">
                        <div class="card-body">
                            <h3 class="h5 fw-bold mb-3">{{ __('The Beginning') }}</h3>
                            <p>{{ __('Cloud Restaurant started as a small family kitchen in 2010. The founder, Chef Ali, began by serving his favorite childhood recipes to friends and family. Word of his delicious food quickly spread throughout the neighborhood.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 h-100">
                        <div class="card-body">
                            <h3 class="h5 fw-bold mb-3">{{ __('Growth & Evolution') }}</h3>
                            <p>{{ __('By 2015, we had opened our first official restaurant location. Our menu expanded to include a wider variety of dishes while maintaining the authentic flavors that made us popular. We continuously refined our recipes based on customer feedback.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 h-100">
                        <div class="card-body">
                            <h3 class="h5 fw-bold mb-3">{{ __('Today') }}</h3>
                            <p>{{ __('Today, Cloud Restaurant is a beloved establishment known for both dine-in excellence and delivery service. While we\'ve grown, our commitment to quality ingredients, authentic recipes, and exceptional customer service remains unchanged.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Values Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('Our Values') }}</h2>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-leaf fa-3x text-primary"></i>
                            </div>
                            <h4>{{ __('Quality') }}</h4>
                            <p class="text-muted">{{ __('We use only the freshest, highest-quality ingredients in all our dishes.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-heart fa-3x text-primary"></i>
                            </div>
                            <h4>{{ __('Passion') }}</h4>
                            <p class="text-muted">{{ __('We put love and care into every dish we prepare for our customers.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-primary"></i>
                            </div>
                            <h4>{{ __('Community') }}</h4>
                            <p class="text-muted">{{ __('We value our role in the community and strive to give back whenever possible.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-smile fa-3x text-primary"></i>
                            </div>
                            <h4>{{ __('Service') }}</h4>
                            <p class="text-muted">{{ __('We aim to provide exceptional service that makes every customer feel valued.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Team Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('Our Team') }}</h2>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card menu-item shadow-sm">
                        <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=768&q=80" class="card-img-top menu-item-image" alt="Chef portrait">
                        <div class="card-body text-center">
                            <h4>{{ __('Chef Ali') }}</h4>
                            <p class="text-muted">{{ __('Founder & Head Chef') }}</p>
                            <p>{{ __('With over 20 years of culinary experience, Chef Ali brings authentic flavors and innovative techniques to every dish.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card menu-item shadow-sm">
                        <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=777&q=80" class="card-img-top menu-item-image" alt="Chef portrait">
                        <div class="card-body text-center">
                            <h4>{{ __('Sara Hassan') }}</h4>
                            <p class="text-muted">{{ __('Executive Chef') }}</p>
                            <p>{{ __('Sara specializes in creating exquisite flavors by blending traditional cooking methods with modern techniques.') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card menu-item shadow-sm">
                        <img src="https://images.unsplash.com/photo-1581349485608-9469926a8e5e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=764&q=80" class="card-img-top menu-item-image" alt="Manager portrait">
                        <div class="card-body text-center">
                            <h4>{{ __('Ahmed Mahmoud') }}</h4>
                            <p class="text-muted">{{ __('Restaurant Manager') }}</p>
                            <p>{{ __('Ahmed ensures that every dining experience at Cloud Restaurant exceeds customer expectations.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action Section -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4">{{ __('Ready to experience our food?') }}</h2>
            <p class="lead mb-5">{{ __('Order online or visit us today.') }}</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('menu') }}" class="btn btn-primary">
                    <i class="fas fa-utensils me-2"></i> {{ __('Order Now') }}
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline-primary">
                    <i class="fas fa-map-marker-alt me-2"></i> {{ __('Find Us') }}
                </a>
            </div>
        </div>
    </section>
@endsection