@extends('receptionist.base')

@section('outlet')

<div class="row">
    <h1>Room Check #{{ $roomTicket->id }}</h1>
</div>

<hr class="mb-5">

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

            <!-- when pending check in status -->
            @if(!$roomTicket->check_in)


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


                    @php
                        dump($roomTicket->id);
                        dump($roomTicket->check_in);
                    @endphp

                    <a class="btn btn-outline-primary mb-4"
                        href="{{ route('reception.checkin.checkin', ['id' => $roomTicket->id]) }}">Check In</a>
                    <a class="btn btn-outline-danger"
                        href="{{ route('checks.delete', ['id' => $roomTicket->id]) }}"
                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                        Cancel Book
                    </a>
                </div>

                <!-- when checked in status -->

            @elseif($roomTicket->status === 0 && $roomTicket->check_in)


                <div class="card card-body text-center d-flex flex-column justify-content-between">


                    Checked In at {{ $roomTicket->check_in->diffForHumans() }}

                    <div class="d-grid gap-4">
                        <span>Customer request service?</span>
                        <a class="btn btn-outline-secondary"
                            href="{{ route('reception.tickets.create', ['room' => $roomTicket->room->id, "customer" => $roomTicket->customer->id]) }}"><i class="bi bi-ticket-detailed me-2"></i>Request Service</a>
                    </div>

                    <a class="btn btn-outline-primary"
                        href="{{ route('reception.checkout.checkout', ['id' => $roomTicket->id]) }}"
                        onclick="return confirm('Are you sure you want to check out this room?')">Check Out</a>


                </div>

                <!-- when checked out status -->

            @elseif($roomTicket->status === 1)
                    <div class="card card-body text-center">
                        <h2 class="mb-4">Checked Out</h2>
                        <p class="text-muted">Checked out at {{ $roomTicket->check_out->format('F j, Y, g:i a') }}</p>
                        <hr>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Room Charge</span>
                                <span class="fs-5">
                                    Rp {{ number_format($roomTicket->room->roomType->price, 0, ',', '.') }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Total</span>
                                <span class="fs-5">
                                    Rp {{ number_format($roomTicket->room->roomType->price, 0, ',', '.') }}
                                </span>
                            </li>
                        </ul>
                        <hr>
                    </div>
                </div>

            @endif


    </div>
    </div>

@endsection