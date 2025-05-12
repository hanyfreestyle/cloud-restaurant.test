@extends('web.layouts.app')

@section('title', __('Frequently Asked Questions'))

@section('content')
    <!-- FAQ Section -->
    <section class="py-5">
        <div class="container">
            <h1 class="text-center mb-5">{{ __('Frequently Asked Questions') }}</h1>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="accordion" id="faqAccordion">
                                @foreach($faqs as $index => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button 
                                                class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" 
                                                type="button" 
                                                data-bs-toggle="collapse" 
                                                data-bs-target="#collapse{{ $index }}" 
                                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                                aria-controls="collapse{{ $index }}"
                                            >
                                                {{ $faq['question'] }}
                                            </button>
                                        </h2>
                                        <div 
                                            id="collapse{{ $index }}" 
                                            class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                            aria-labelledby="heading{{ $index }}" 
                                            data-bs-parent="#faqAccordion"
                                        >
                                            <div class="accordion-body">
                                                <p>{{ $faq['answer'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4">{{ __('Still have questions?') }}</h2>
            <p class="lead mb-5">{{ __('We\'re here to help. Contact us for any questions you might have.') }}</p>
            <a href="{{ route('contact') }}" class="btn btn-primary">
                <i class="fas fa-envelope me-2"></i> {{ __('Contact Us') }}
            </a>
        </div>
    </section>
@endsection