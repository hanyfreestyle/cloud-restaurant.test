<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Cloud Restaurant') }} - @yield('title', 'Home')</title>

    <!-- Bootstrap RTL CSS if Arabic -->
    @if(app()->getLocale() === 'ar')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <style>
        /* Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-color: #e67e22;
            --secondary-color: #2c3e50;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* RTL specific styles */
        [dir="rtl"] body {
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        [dir="rtl"] .ms-auto {
            margin-right: auto !important;
            margin-left: 0 !important;
        }

        [dir="rtl"] .me-2 {
            margin-left: 0.5rem !important;
            margin-right: 0 !important;
        }

        /* Header styles */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: var(--primary-color);
        }

        .nav-link {
            color: var(--dark-color);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .navbar-toggler {
            border: none;
        }

        /* Hero section */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80');
            background-position: center;
            background-size: cover;
            color: white;
            padding: 100px 0;
            margin-bottom: 30px;
        }

        /* Menu items */
        .menu-item {
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .menu-item-image {
            height: 200px;
            object-fit: cover;
        }

        .menu-item-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        [dir="rtl"] .menu-item-badge {
            right: auto;
            left: 10px;
        }

        /* Category tabs/buttons */
        .category-btn {
            background-color: white;
            color: var(--dark-color);
            border: 1px solid #ddd;
            border-radius: 30px;
            padding: 8px 20px;
            margin: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-btn:hover, .category-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Cart styles */
        .cart-icon {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        [dir="rtl"] .cart-badge {
            right: auto;
            left: -8px;
        }

        /* Footer styles */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 40px 0 20px;
            margin-top: 50px;
        }

        .footer-links h5 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: bold;
        }

        .footer-links ul {
            list-style: none;
            padding-left: 0;
        }

        [dir="rtl"] .footer-links ul {
            padding-right: 0;
        }

        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
            text-decoration: none;
        }

        .social-icons a {
            color: white;
            background-color: rgba(255,255,255,0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        [dir="rtl"] .social-icons a {
            margin-right: 0;
            margin-left: 10px;
        }

        .social-icons a:hover {
            background-color: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Modal styles */
        .modal-header {
            background-color: var(--primary-color);
            color: white;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: darken(var(--primary-color), 10%);
            border-color: darken(var(--primary-color), 10%);
        }

        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: none;
            background: transparent;
        }

        /* Form controls */
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(230, 126, 34, 0.25);
        }
    </style>

    <!-- Livewire styles -->
    @livewireStyles

    <!-- Extra styles -->
    @stack('styles')
</head>
<body>
    <header>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-utensils me-2"></i> Cloud Restaurant
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link{{ request()->routeIs('home') ? ' active' : '' }}" href="{{ route('home') }}">
                                {{ __('Home') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ request()->routeIs('menu') ? ' active' : '' }}" href="{{ route('menu') }}">
                                {{ __('Menu') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ request()->routeIs('about') ? ' active' : '' }}" href="{{ route('about') }}">
                                {{ __('About Us') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ request()->routeIs('contact') ? ' active' : '' }}" href="{{ route('contact') }}">
                                {{ __('Contact') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ request()->routeIs('faq') ? ' active' : '' }}" href="{{ route('faq') }}">
                                {{ __('FAQ') }}
                            </a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center">
                        <!-- Language Switcher -->
                        <div class="dropdown me-3">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                {{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li>
                                        <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                            {{ $properties['native'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Cart Icon with Dropdown -->
                        <div class="dropdown">
                            <a href="#" class="btn btn-outline-primary position-relative cart-icon dropdown-toggle" id="cartDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-shopping-cart"></i>
                                @if(Cart::count() > 0)
                                    <span class="cart-badge">{{ Cart::count() }}</span>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow-sm p-3" style="width: 320px; max-height: 400px; overflow-y: auto;" aria-labelledby="cartDropdown">
                                <h6 class="dropdown-header">{{ __('Quick Cart') }}</h6>

                                @if(Cart::count() > 0)
                                    <div class="dropdown-item-text">
                                        <small class="text-muted">{{ Cart::count() }} {{ Cart::count() == 1 ? __('Item') : __('Items') }}</small>
                                    </div>

                                    <div class="dropdown-divider"></div>

                                    <div class="quick-cart-items mb-3">
                                        @foreach(Cart::content()->take(4) as $item)
                                            <div class="d-flex py-2 border-bottom">
                                                <div class="me-2">
                                                    @if(isset($item->options['image']) && $item->options['image'])
                                                        <img src="{{ $item->options['image'] }}" alt="{{ $item->name }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                            <i class="fas fa-utensils text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="fw-bold small">{{ \Illuminate\Support\Str::limit($item->name, 20) }}</div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="small">{{ $item->qty }} x {{ number_format($item->price, 2) }} EGP</div>
                                                        <div class="text-primary">{{ number_format($item->subtotal, 2) }} EGP</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if(Cart::count() > 4)
                                            <div class="small text-center mt-2">
                                                <a href="{{ route('cart') }}" class="text-primary">{{ __('View all items') }}</a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center py-2">
                                        <span class="fw-bold">{{ __('Total') }}:</span>
                                        <span class="fw-bold text-primary">{{ Cart::total() }} EGP</span>
                                    </div>

                                    <div class="dropdown-divider"></div>

                                    <div class="d-flex justify-content-between">
                                        <form action="{{ route('cart.clear') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt me-1"></i> {{ __('Clear Cart') }}
                                            </button>
                                        </form>
                                        <a href="{{ route('cart') }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-shopping-cart me-1"></i> {{ __('View Cart') }}
                                        </a>
                                    </div>
                                @else
                                    <div class="text-center py-3">
                                        <i class="fas fa-shopping-basket fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">{{ __('Your cart is empty') }}</p>
                                        <a href="{{ route('menu') }}" class="btn btn-sm btn-primary mt-3">
                                            <i class="fas fa-utensils me-2"></i> {{ __('Browse Menu') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="footer-links">
                        <h5>{{ __('Cloud Restaurant') }}</h5>
                        <p>{{ __('Delicious food delivered to your doorstep. Our restaurant offers a variety of dishes made with fresh ingredients.') }}</p>
                        <div class="social-icons mt-3">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-links">
                        <h5>{{ __('Quick Links') }}</h5>
                        <ul>
                            <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                            <li><a href="{{ route('menu') }}">{{ __('Menu') }}</a></li>
                            <li><a href="{{ route('about') }}">{{ __('About Us') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('Contact Us') }}</a></li>
                            <li><a href="{{ route('faq') }}">{{ __('FAQ') }}</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="footer-links">
                        <h5>{{ __('Contact Us') }}</h5>
                        <ul>
                            <li><i class="fas fa-map-marker-alt me-2"></i> {{ __('1234 Street Name, City Name') }}</li>
                            <li><i class="fas fa-phone me-2"></i> +123 456 7890</li>
                            <li><i class="fas fa-envelope me-2"></i> info@cloudrestaurant.com</li>
                            <li><i class="fas fa-clock me-2"></i> {{ __('Open: 10:00 AM - 11:00 PM') }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <hr class="mt-4 mb-3" style="border-color: rgba(255,255,255,0.1);">

            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ __('Cloud Restaurant. All rights reserved.') }}</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <!-- Fix modals z-index and backdrop issues -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure modals work correctly
            var modals = document.querySelectorAll('.modal');

            modals.forEach(function(modal) {
                modal.addEventListener('shown.bs.modal', function() {
                    document.body.classList.add('modal-open');

                    // Make sure modal is at the top level for z-index
                    if (modal.parentNode !== document.body) {
                        document.body.appendChild(modal);
                    }
                });

                modal.addEventListener('hidden.bs.modal', function() {
                    setTimeout(function() {
                        document.body.classList.remove('modal-open');
                    }, 100);
                });
            });
        });
    </script>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Extra Scripts -->
    @stack('scripts')
</body>
</html>
