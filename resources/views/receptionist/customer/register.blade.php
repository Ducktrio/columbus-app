@extends('receptionist.base')

@section('outlet')

    <div class="container d-flex flex-column gap-4">

        <div class="row g-5">

            <div class="col">
                <h1 class="mb-3">Register New Customer</h1>

                <div class="card card-body text-bg-light mb-2">
                    <small class="text-muted">
                        * Validation rules for creating a customer:<br>
     * - courtesy_title: Required, string, maximum 255 characters.<br>
     * - full_name: Required, string, maximum 255 characters.<br>
     * - age: Required, numeric, must be at least 18 years old.<br>
     * - phone_number: Optional, string, maximum 20 characters.<br>
     *
     * Please ensure all required fields are filled and age is 18 or older.
                    </small>

                </div>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endif
               
            </div>

            <div class="col">
                 <form action="{{ route('reception.customer.register.submit') }}" method="POST" class="card card-body">
                    @csrf

                    @if(request()->query('redirect_to'))
                        
                        <input type="hidden" name="redirect_to" value="{{ request()->query('redirect_to') }}">
                    @endif

                    <div class="mb-3">
                        <label for="courtesy_title" class="form-label">Courtesy Title</label>
                        <input type="text" name="courtesy_title" id="courtesy_title" class="form-control @error('courtesy_title') is-invalid @enderror" value="{{ old('courtesy_title') }}">
                    </div>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('courtesy_title') }}">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" min="18" name="age" id="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}">
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Register Customer</button>
                </form>
            </div>
        </div>
        </div>

    </div>
@endsection