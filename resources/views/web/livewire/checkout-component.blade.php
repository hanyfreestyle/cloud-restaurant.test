<div>
    <section class="py-5">
        <div class="container">
            <h1 class="text-center mb-5">{{ __('Checkout') }}</h1>
            
            @if(isset($errors['general']))
                <div class="alert alert-danger">
                    {{ $errors['general'] }}
                </div>
            @endif
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">{{ __('Order Type') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="form-check border rounded p-3 {{ $orderType == 'delivery' ? 'border-primary' : '' }}">
                                        <input 
                                            class="form-check-input" 
                                            type="radio" 
                                            name="orderType" 
                                            id="delivery" 
                                            value="delivery" 
                                            wire:model="orderType" 
                                            wire:click="changeOrderType('delivery')"
                                            checked
                                        >
                                        <label class="form-check-label w-100" for="delivery">
                                            <i class="fas fa-truck me-2 text-primary"></i> {{ __('Delivery') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check border rounded p-3 {{ $orderType == 'pickup' ? 'border-primary' : '' }}">
                                        <input 
                                            class="form-check-input" 
                                            type="radio" 
                                            name="orderType" 
                                            id="pickup" 
                                            value="pickup" 
                                            wire:model="orderType"
                                            wire:click="changeOrderType('pickup')"
                                        >
                                        <label class="form-check-label w-100" for="pickup">
                                            <i class="fas fa-store me-2 text-primary"></i> {{ __('Pickup') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check border rounded p-3 {{ $orderType == 'table' ? 'border-primary' : '' }}">
                                        <input 
                                            class="form-check-input" 
                                            type="radio" 
                                            name="orderType" 
                                            id="table" 
                                            value="table" 
                                            wire:model="orderType"
                                            wire:click="changeOrderType('table')"
                                        >
                                        <label class="form-check-label w-100" for="table">
                                            <i class="fas fa-utensils me-2 text-primary"></i> {{ __('Table Reservation') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            @if($orderType == 'table')
                                <div class="mt-4">
                                    <label class="form-label">{{ __('Select Table') }}</label>
                                    
                                    @if(isset($errors['table']))
                                        <div class="text-danger small mb-2">{{ $errors['table'] }}</div>
                                    @endif
                                    
                                    <div class="row g-2">
                                        @forelse($availableTables as $table)
                                            <div class="col-md-3 col-6">
                                                <div 
                                                    class="border rounded p-3 text-center cursor-pointer {{ $tableId == $table->id ? 'border-primary bg-light' : '' }}"
                                                    wire:click="$set('tableId', '{{ $table->id }}')"
                                                >
                                                    <i class="fas fa-chair fa-2x mb-2 {{ $tableId == $table->id ? 'text-primary' : 'text-muted' }}"></i>
                                                    <p class="mb-0">{{ __('Table') }} #{{ $table->table_number }}</p>
                                                    <small class="text-muted">{{ __('Capacity') }}: {{ $table->capacity }}</small>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="alert alert-warning">
                                                    {{ __('No tables available for reservation.') }}
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">{{ __('Contact Information') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    wire:model="name"
                                >
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">{{ __('Phone Number') }} <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control @error('phone') is-invalid @enderror" 
                                    wire:model="phone"
                                >
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            @if($orderType == 'delivery')
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Delivery Address') }} <span class="text-danger">*</span></label>
                                    <textarea 
                                        class="form-control @if(isset($errors['address'])) is-invalid @endif" 
                                        rows="3" 
                                        wire:model="address"
                                    ></textarea>
                                    @if(isset($errors['address'])) 
                                        <div class="invalid-feedback">{{ $errors['address'] }}</div> 
                                    @endif
                                </div>
                            @endif
                            
                            <div class="mb-0">
                                <label class="form-label">{{ __('Order Notes') }}</label>
                                <textarea 
                                    class="form-control" 
                                    rows="3" 
                                    wire:model="notes"
                                    placeholder="{{ __('Any special instructions or requests...') }}"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">{{ __('Order Summary') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach($cartItems as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                                        <div>
                                            <span class="badge bg-primary rounded-pill me-2">{{ $item->qty }}</span>
                                            <span>{{ $item->name }}</span>
                                            @if(isset($item->options['variant_name']) && $item->options['variant_name'])
                                                <small class="d-block text-muted">{{ $item->options['variant_name'] }}</small>
                                            @endif
                                        </div>
                                        <span class="fw-bold">{{ number_format($item->subtotal, 2) }} EGP</span>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <div class="card-footer bg-white">
                                <div class="d-flex justify-content-between align-items-center fw-bold">
                                    <span>{{ __('Total') }}</span>
                                    <span>{{ $cartTotal }} EGP</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">{{ __('Payment Method') }}</h5>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery" checked>
                                <label class="form-check-label" for="cashOnDelivery">
                                    <i class="fas fa-money-bill-wave me-2 text-success"></i> {{ __('Cash on Delivery/Pickup') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="btn btn-primary w-100 py-3" wire:click="placeOrder">
                        <i class="fas fa-check-circle me-2"></i> {{ __('Place Order') }}
                    </button>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('cart') }}" class="text-muted">
                            <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Cart') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>