<div class="row row-cols-3 g-2" id="room-list">
    @if (count($customers) === 0)
            <p class="text-muted">No customers available.</p>
    @endif

    @php
        $customerSelected = old('customer_id');
    @endphp

    @foreach ($customers as $customer)
    <div class="col text-center"> 
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
    {{ $customers->links() }}
    <a class="btn btn-outline-primary" href="{{ route('reception.customer.register', ['redirect_to' => "reception.checkin"]) }}">Register new customer</a>
</div>
