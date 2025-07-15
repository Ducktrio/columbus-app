@extends('receptionist.base')

@section('outlet')

    <div class="row mb-5">
        <h1>Room Information</h1>
    </div>

    <hr class="mb-5">

    <div class="row mb-5 gap-4">

        <div class="col d-flex flex-column gap-4">

            <div class="card card-body text-bg-dark text-center">
                <h1>Room {{ $room->label }}</h1>
            </div>


            <div class="card card-body text-center gap-4">



                <h4> {{ $room->roomType->name }}</h4>

                <h5 class="card card-body border rounded-pill fs-4">
                    Rp {{ number_format($room->roomType->price, 0, ',', '.') }}
                </h5>



                @if($room->status === 0)
                    <span class="badge text-bg-success fs-5">Available</span>
                @elseif($room->status === 1)


                    <span>
                        Checked in
                        {{ optional($room->roomTickets->sortByDesc('check_in')->first())->check_in->diffForHumans() }}
                    </span>

                    <span class="badge text-bg-secondary fs-5">Occupied</span>
                @elseif($room->status === 2)

                    <span>
                        Last checkout in
                        {{ optional($room->roomTickets->sortByDesc('check_out')->first())->check_out->diffForHumans() }}
                    </span>

                    <span class="badge text-bg-danger fs-5">Unavailable</span>


                @endif

            </div>


        </div>


        <div class="col">

            <div class="card card-body">

                @if($room->status === 0)

                    <h4 class="mb-3">This room is available for check in</h4>

                    <a class="btn btn-outline-dark btn-lg d-grid fs-4 p-5"
                        href="{{ route('reception.checkin', ['room' => $room->id]) }}">
                        <i class="bi bi-door-open"></i>
                        <span>Check In</span>
                    </a>

                @elseif($room->status === 1)

                    <h4 class="mb-3">Current Occupants</h4>

                    @if($room->roomTickets->where('status', 0)->whereNotNull('check_in')->whereNull('check_out')->count() > 0)
                        @foreach($room->roomTickets->whereNotNull('check_in')->whereNull('check_out') as $ticket)

                            <span class="mb-2 d-flex flex-row justify-content-center align-items-center gap-2">
                                <div class="rounded-pill border d-inline px-4 py-2">
                                    <i class="bi bi-person-fill"></i> {{ $ticket->customer->courtesy_title }}
                                    {{ $ticket->customer->full_name }}
                                </div>

                                <a class="btn btn-outline-dark btn-sm"
                                    href="{{ route('reception.checkDetail', ['id' => $ticket->id]) }}">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </span>
                        @endforeach
                    @else
                        <p class="text-muted">No current occupants.</p>
                    @endif


                @elseif($room->status === 2)

                    <h4 class="mb-3">Last Cleaning Request</h4>


                    @if (
                                $room->serviceTickets
                                    ->where('service.name', 'Cleaning')
                                    ->sortByDesc('created_at')
                                    ->first()?->created_at != $room->roomTickets->sortByDesc('check_out')->first()?->check_out
                            )
                            <p class="text-muted">No cleaning request since last checkout.</p>

                            <a href="{{ route('reception.tickets.create', [
                            'room' => $room->id,
                            'customer' => $room->roomTickets->sortByDesc('check_out')->first()->customer->id,
                            'service' => \App\Models\Service::query()->where('name', 'LIKE', 'Cleaning')->first()->id
                        ]) . '#details' }}" class="btn btn-outline-dark fs-4">
                                <i class="bi bi-ticket"></i> Post Cleaning Ticket
                            </a>

                    @else
                        <span class="d-flex flex-row justify-content-center align-items-center gap-2">
                            <a href="{{ route('reception.tickets.ticketDetail', ["id" => $room->serviceTickets->sortByDesc('created_at')->first()->id]) }}" class="rounded-pill border d-inline px-4 py-2">
                                <i class="bi bi-ticket-detailed me-2"></i>
                                {{ $room->serviceTickets->sortByDesc('created_at')->first()->id }}
                            </a>
                        </span>
                    @endif


                @endif


            </div>

        </div>

    </div>


@endsection