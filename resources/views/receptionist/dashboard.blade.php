@extends('receptionist.base')



@section('outlet')



    <div class="row mb-5">

        <h4 class="mb-3">Stats</h4>

        <!-- Available Rooms Info -->
        <div class="col-4">

            <div role="button" data-bs-toggle="collapse" data-bs-target="#availableRooms"
                class="card border mb-3 text-bg-success">
                <div class="card-header">Available Rooms</div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h1 class="card-title">
                        {{ count(array_filter($rooms, function ($room) {
        return $room['status'] == 0; })) }}
                    </h1>
                </div>
            </div>

        </div>

        <div class="col-4">
            <div role="button" data-bs-toggle="collapse" data-bs-target="#unavailableRooms"
                class="card border mb-3 text-bg-warning">
                <div class="card-header">Unavailable Rooms</div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <h1 class="card-title">
                        {{ count(array_filter($rooms, function ($room) {
        return $room['status'] == 2; })) }}
                    </h1>
                </div>
            </div>
        </div>

        <div class="collapse col-12" id="availableRooms">
            <div class="card border mb-3 text-bg-light">
                <div class="card-header">Available Rooms List</div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($roomTypes as $type)
                            <div class="col">
                                <div class="card card-body text-center">
                                    {{ $type['name'] }} | {{ $type->rooms->where('status', 0)->count() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <div class="collapse col-12" id="unavailableRooms">
            <div class="card border mb-3 text-bg-light">
                <div class="card-header">Unavailable Rooms List</div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($roomTypes as $type)
                            <div class="col">
                                <div class="card card-body text-center">
                                    {{ $type['name'] }} | {{ $type->rooms->where('status', 2)->count() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>


    </div>

    <hr>


    <div class="row">

        <h4 class="mb-3">Quick Action</h4>

        <div class="d-flex flex-row align-items-stretch justify-contenr-evenly gap-2">

            <a href="{{ route('reception.checkin') }}" class="btn btn-outline-dark d-grid fs-4 p-5">
                <i class="bi bi-door-open"></i>
                <span>Check In</span>
            </a>

            <a href="{{ route('reception.checkout') }}" class="btn btn-outline-dark d-grid fs-4 p-5">
                <i class="bi bi-door-open"></i>
                <span>Check Out</span>
            </a>

            <a href="{{ route('reception.tickets') }}" class="btn btn-outline-dark d-grid fs-4 p-5">
                <i class="bi bi-ticket-detailed"></i>
                <span>Service</span>
            </a>

            <a href="{{ route('reception.rooms', ["status" => 2]) }}" class="btn btn-outline-dark d-grid fs-4 p-5 position-relative">
                <i class="bi bi-door-closed"></i>
                <span>Prepare Room</span>
                @if(\App\Models\Room::where('status', 2)->count() > 0)
                    <span class="position-absolute top-0 end-0 translate-middle p-1">
                        <span class="spinner-grow text-warning" role="status">
                            <span class="visually-hidden">Warning</span>
                        </span>
                    </span>
                @endif
            </a>



        </div>

    </div>



@endsection