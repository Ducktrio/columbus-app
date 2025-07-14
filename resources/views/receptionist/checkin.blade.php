@extends('receptionist.base')

@section('outlet')

<form action="{{  route('reception.checkin.submit') }}" method="POST">
    <div class="row text-center mb-5 g-5">
            <div class="col-2">
                <div id="steps" class="list-group position-sticky" style="top: 20px;">
                    <a class="list-group-item list-group-item-action" href="#step-1">Customer</a>
                    <a class="list-group-item list-group-item-action" href="#step-2">Room</a>
                    <a class="list-group-item list-group-item-action" href="#step-3">Occupants</a>
                </div>
            </div>


            <div class="col d-flex flex-column align-items-stretch gap-2" data-bs-spy="scroll" data-bs-target="#steps"
                data-bs-offset="0">

                @csrf



                <!-- Step 1 -->
                <div class="row" id="step-1">
                    <h4 class="mb-2">Enter Customer Data</h4>

                    <div class="card card-body">

                        <div class="mb-3">
                            <input type="text" id="searchCustomer" class="form-control mb-3" placeholder="Search...">
                        </div>


                        <div id="customers-list">
                            @include('receptionist.partials.customerList', ['customers' => $customers])
                        </div>

                    </div>
                </div>

                <div class="col-auto d-flex align-items-center justify-content-center">
                    <div class="bg-light" style="border-left: 2px solid #dee2e6; height: 100%; min-height: 100px;"></div>
                </div>

                <!-- Step 2 -->
                <div class="row" id="step-2">
                    <h4 class="mb-2">Select Room</h4>

                    <div class="card card-body">

                        <div class="mb-3">
                            <input type="text" id="searchRoom" class="form-control mb-3" placeholder="Search...">
                        </div>

                        <div id="rooms-list">
                            @include('receptionist.partials.roomList', ['rooms' => $rooms])
                        </div>

                    </div>

                </div>

                <div class="col-auto d-flex align-items-center justify-content-center">
                    <div class="bg-light" style="border-left: 2px solid #dee2e6; height: 100%; min-height: 100px;"></div>
                </div>

                <!-- Step 3 -->
                <div class="row" id="step-3">
                    <h4 class="mb-2">Number of Occupants</h4>
                    <div class="mb-3">
                        <input type="number" name="number_of_occupants" class="form-control" placeholder="Number of occupants"
                            value="{{ old('occupants', 1) }}" min="1" max="10">
                    </div>
                </div>

                <div class="col-auto d-flex align-items-center justify-content-center">
                    <div class="bg-light" style="border-left: 2px solid #dee2e6; height: 100%; min-height: 100px;"></div>
                </div>

                <div class="row">
                    <button type="submit" class="btn btn-primary w-100">Check In</button>
                </div>


            </div>
        </div>
    </form>




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
                    url: "{{ route('reception.checkin') }}",
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
                    url: "{{ route('reception.checkin') }}",
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