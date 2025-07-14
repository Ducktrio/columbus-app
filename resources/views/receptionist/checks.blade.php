@extends('receptionist.base')


@section('outlet')


    <div class="row">

        <h2 class="mb-5">Room Checks</h2>

        <ul class="nav nav-tabs nav-fill mb-5">

            <li class="nav-item">
                <a class="nav-link {{ request()->query('filter') === '0' ? 'active' : '' }}"
                    href="{{ route('reception.checks', ['filter' => "0"]) }}">Pending Check In
                    @if (\App\Models\RoomTicket::query()->whereNull('check_in')->count() > 0)
                        <span
                            class="badge rounded-pill bg-danger ms-2">{{ \App\Models\RoomTicket::query()->whereNull('check_in')->count() }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{  request()->query('filter') === '1' ? 'active' : '' }}"
                    href="{{  route('reception.checks', ['filter' => "1"]) }}">Checked In
                    @if (\App\Models\RoomTicket::query()->whereNotNull('check_in')->count() > 0)
                        <span
                            class="badge rounded-pill bg-danger ms-2">{{ \App\Models\RoomTicket::query()->whereNotNull('check_in')->count() }}</span>
                    @endif
                </a>
            </li>
        </ul>

        <div class="row">

            @foreach($roomTickets as $ticket)

                <div class="col-4">

                    <a role="div" class="card card-body text-bg-dark mb-3 text-decoration-none" data-bs-toggle="collapse"
                        data-bs-target="#ticket-{{ $ticket->id }}">

                        <h4 class="">Room {{ $ticket->room->label }}</h4>

                    </a>

                    <a class="collapse text-decoration-none" href="{{ route('reception.checkDetail', ["id" => $ticket->id]) }}"
                        id="ticket-{{ $ticket->id }}">

                        <div class="card card-body text-bg-light mb-3">
                            <h5 class="mb-3">Ticket Details</h5>
                            <p>{{ $ticket->details }}</p>
                            <p><i class="bi bi-people-fill"></i> {{ $ticket->number_of_occupants }}</p>

                            <p><i class="bi bi-person-fill"></i> {{ $ticket->customer->courtesy_title }}
                                {{ $ticket->customer->full_name }}
                            </p>

                            @if ($ticket->check_in === null)

                                <p>Status: <span class="badge text-bg-warning">Pending Check-in</span></p>

                            @else

                                <p>Status: <span class="badge text-bg-success">Checked In</span></p>

                            @endif
                        </div>
                    </a>

                </div>

            @endforeach

        </div>

    </div>



@endsection