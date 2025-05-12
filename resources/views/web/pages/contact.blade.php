@extends('web.layouts.app')

@section('title', __('Contact Us'))

@section('content')
    <!-- Contact Section -->
    <section class="py-5">
        <div class="container">
            <h1 class="text-center mb-5">{{ __('Contact Us') }}</h1>
            
            @if(session()->has('success'))
                <div class="alert alert-success text-center mb-5">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h4 class="mb-4">{{ __('Get in Touch') }}</h4>
                            
                            <div class="mb-4">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-map-marker-alt fa-fw fa-lg text-primary me-3 mt-1"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ __('Address') }}</h6>
                                        <p class="text-muted mb-0">{{ __('1234 Street Name, City Name, Country') }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-phone fa-fw fa-lg text-primary me-3 mt-1"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ __('Phone') }}</h6>
                                        <p class="text-muted mb-0">+123 456 7890</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-envelope fa-fw fa-lg text-primary me-3 mt-1"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ __('Email') }}</h6>
                                        <p class="text-muted mb-0">info@cloudrestaurant.com</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-clock fa-fw fa-lg text-primary me-3 mt-1"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ __('Working Hours') }}</h6>
                                        <p class="text-muted mb-0">{{ __('Monday - Sunday: 10:00 AM - 11:00 PM') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <h5 class="mb-3">{{ __('Follow Us') }}</h5>
                            <div class="social-icons">
                                <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h4 class="mb-4">{{ __('Send Us a Message') }}</h4>
                            
                            <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Your Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Your Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label">{{ __('Message') }} <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary py-2">
                                        <i class="fas fa-paper-plane me-2"></i> {{ __('Send Message') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Map Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">{{ __('Our Location') }}</h2>
            
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d110502.76990825784!2d31.17788753125!3d30.0595581!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583fa60b21beeb%3A0x79dfb296e8423bba!2sCairo%2C%20Cairo%20Governorate!5e0!3m2!1sen!2seg!4v1674318679385!5m2!1sen!2seg" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>
@endsection