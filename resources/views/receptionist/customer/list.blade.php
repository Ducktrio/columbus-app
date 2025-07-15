@extends('receptionist.base')
@section('outlet')

    <div class="container d-flex flex-column gap-4">

        <div class="row mb-5">
            <h1 class="mb-3">Customer List</h1>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @include('receptionist.partials.customerList', ['customers' => $customers])
        </div>

    </div>
    <div class="d-grid g-2 mt-3">
        <a class="btn btn-outline-primary" href="{{ route('reception.customer.register', ['redirect_to' => 'reception.checkin']) }}">Register new customer</a>
    </div>
@endsection