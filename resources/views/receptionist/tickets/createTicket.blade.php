@extends('receptionist.base')

@section('outlet')

    <div class="container d-flex flex-column gap-4">

        <div class="row mb-5">
            <h1 class="mb-2">Post Ticket</h1>

        </div>


        <div class="row">

            <form method="POST" action="{{ route("reception.tickets.create.submit") }}">


                @csrf

                <h2 for="service" class="mb-5">Select Service</h2>

                <div class="d-flex gap-2 mb-5" id="service" role="group" aria-label="Service selection">

                    @php

                        $selected = request()->query('service') ?? old('service_id');

                    @endphp
                    
                    @foreach($services as $x)
                        <input type="radio" class="btn-check" name="service_id" id="service-{{ Str::slug($x->id) }}"
                            value="{{ $x->id }}" autocomplete="off"
                            {{ $selected == $x->id ? 'checked' : '' }}>
                        <label class="btn btn-outline-secondary"
                            for="service-{{ Str::slug($x->id) }}">{{ $x->name }}</label>
                    @endforeach

                    
                   
                </div>


                <hr class="mb-5">

                <h2 class="mb-5" for="room">Select Room</h2>



                <div class="mb-3">
                    <label for="searchRoom" class="form-label">Search with Room's label or type</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon3">Search</span>
                        <input type="text" class="form-control" id="searchRoom"
                            aria-describedby="basic-addon3 basic-addon4">
                    </div>
                </div>


                <div id="rooms-list" class="mb-5">
                    @include('receptionist.partials.roomList', ['rooms' => $rooms])
                </div>



                <hr class="mb-5">



                <h2 class="mb-5" for="customer">Link Customer data</h2>

                <div class="mb-3">
                    <label for="search" class="form-label">Search with Customer's full name</label>
                    <input type="text" id="searchCustomer" class="form-control mb-3" placeholder="Search...">
                </div>


                <div id="customers-list" class="mb-5">
                    @include('receptionist.partials.customerList', ['customers' => $customers])
                </div>

                <hr class="mb-5">

                <h2 class="mb-5" for="description">Ticket Description</h2>

                <div class="mb-3">
                    <label for="details" class="form-label">Description</label>
                    <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details" rows="3" autocomplete="off">{{ old('details') }}</textarea>
                </div>


                <hr class="mb-5">

                 <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary p-4 fs-2">Submit</button>

                </div>                

            </form>


        </div>


@endsection


    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                let queryRoom = "";
                let queryCustomer = "";

                $('#searchRoom').on('keyup', function () {
                    queryRoom = $(this).val();
                    $.ajax({
                        url: "{{ route('reception.tickets.create') }}",
                        type: 'GET',
                        data: { searchRoom: queryRoom },
                        success: function (data) {
                            $('#rooms-list').html(data.htmlRooms);
                        }
                    });
                });

                $('#searchCustomer').on('keyup', function () {
                    queryCustomer = $(this).val();
                    $.ajax({
                        url: "{{ route('reception.tickets.create') }}",
                        type: 'GET',
                        data: { searchCustomer: queryCustomer },
                        success: function (data) {
                            $('#customers-list').html(data.htmlCustomers);
                        }
                    });
                });

                $(document).on('click', '.pagination a', function (e) {
                    e.preventDefault();
                    let url = $(this).attr('href');
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#rooms-list').html(data.htmlRooms);
                            $('#customers-list').html(data.htmlCustomers);
                        }
                    });
                });
            });
        </script>
    @endpush