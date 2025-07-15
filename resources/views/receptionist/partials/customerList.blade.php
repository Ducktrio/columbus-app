<div class="row row-cols-3 overflow-y-scroll g-4" style="white-space: nowrap; max-height: 24rem;">
    @if (count($customers) === 0)
        <p class="text-muted">No customers available.</p>
    @endif

    @php
        $customerSelected = request()->query('customer') ?? old('customer_id');
    @endphp

    @foreach ($customers as $customer)
        <div class="col text-center" style="min-width: 250px;">
            <input type="radio" class="btn-check room-item" name="customer_id" id="room-{{ $customer->id }}" value="{{ $customer->id }}"
                autocomplete="off" {{ $customerSelected == $customer->id ? 'checked' : '' }} data-label="{{ strtolower($customer->label) }}"
                data-description="{{ strtolower($customer->description) }}">
            <label for="room-{{ $customer->id }}" class="btn btn-outline-secondary text-center"
                style="width:100%;">
                <div class="w-100 justify-content-between align-items-center">
                    <span class="me-2">
                        <i class="bi bi-person-circle" style="font-size: 2.5rem;"></i>
                    </span>
                    <h5 class="mb-1 text-center">{{ $customer->courtesy_title }} {{ $customer->full_name }}</h5>
                </div>
            </label>
        </div>
    @endforeach
</div>

<div class="d-grid g-2 mt-3" id="room-pagination">
    <a class="btn btn-outline-primary" href="{{ route('reception.customer.register', ['redirect_to' => request()->fullUrl()]) }}">Register new customer</a>
</div>
