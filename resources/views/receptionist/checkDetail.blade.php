@extends('receptionist.base')

@section('outlet')

    <div class="row">
        <div class="col d-flex flex-column gap-4">

            <div class="card card-body text-bg-dark text-center">

                <span class="fs-2">{{  $roomTicket->room->label }}</span>

            </div>

            <div class="card card-body border d-flex flex-row align-items-center justify-content-center gap-2">

                <i class="bi bi-person fs-1"></i>
                <span class="fs-4">{{ $roomTicket->customer->courtesy_title }} {{ $roomTicket->customer->full_name }}</span>

            </div>

            <div class="row">
                <div class="col-6">
                    <div class="card card-body text-center">
                        <h4 class="mb-3">Occupants</h4>
                        <span class="fs-1 fw-bold">{{ $roomTicket->number_of_occupants }}</span>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card card-body text-center">
                        <h4 class="mb-3">Status</h4>
                        <span class="fs-1">
                            @if($roomTicket->status === 0)
                                @if($roomTicket->check_in)
                                    <span class="badge text-bg-primary fs-5">Checked In</span><br>
                                @else
                                    <span class="badge text-bg-warning fs-5">Pending Check-in</span>
                                @endif
                            @elseif($roomTicket->status === 1)
                                <span class="badge text-bg-success fs-5">Checked Out</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>


        <div class="col d-flex flex-column gap-4">

            <!-- when open status -->
            <div class="card card-body text-center">

                <h2 class="mb-4">Receipt</h2>
                <p class="text-muted">{{ $roomTicket->created_at->format('F j, Y, g:i a') }}</p>

                <hr>

                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Room Charge</span>
                        <span class="fs-5">
                            Rp {{ number_format($roomTicket->room->roomType->price, 0, ',', '.') }}
                        </span>
                    </li>
                </ul>

                <hr>

                @if($roomTicket->status === 0 && !$roomTicket->check_in)

                    @php
                        dump($roomTicket->id);
                        dump($roomTicket->check_in);
                    @endphp

                    <a class="btn btn-outline-primary"
                        href="{{ route('reception.checkin.checkin', ['id' => $roomTicket->id]) }}">Check In</a>
                @elseif($roomTicket->status === 1)
                    <a class="btn btn-outline-success" href="#">Check Out</a>
                @endif
            </div>



        </div>
    </div>

@endsection