@extends('managers.base')

@section('outlet')



    <div class="container d-flex flex-column gap-4">

        <div class="row mb-2">

            <h1 class="mb-3">Tickets</h1>
            <ul class="nav nav-tabs nav-fill mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === '0' || !request('status') ? 'active' : '' }}"
                        href="{{ route('managers.listTickets', ['status' => '0']) }}">
                        Open
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === '1' ? 'active' : '' }}"
                        href="{{ route('managers.listTickets', ['status' => '1']) }}">
                        Progress
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === '2' ? 'active' : '' }}"
                        href="{{ route('managers.listTickets', ['status' => '2']) }}">
                        Resolved
                    </a>
                </li>
            </ul>

            <div class="row g-4">
                @if (count($tickets) === 0)
                    <div class="list-group-item">
                        <p class="text-muted">No tickets available.</p>
                    </div>
                @endif

                @foreach ($tickets as $ticket)

                    @php
                        $statusMap = [
                            0 => ['label' => 'Open', 'class' => 'success'],
                            1 => ['label' => 'In Progress', 'class' => 'warning'],
                            2 => ['label' => 'Resolved', 'class' => 'secondary'],
                        ];
                        $status = $statusMap[$ticket->status] ?? ['label' => 'Unknown', 'class' => 'dark'];
                    @endphp

                    <div class="col-4">

                        <a href="{{ route('managers.ticketDetail', ["id" => $ticket->id]) }}" class="card text-decoration-none">
                            <div
                                class="card-header text-bg-light d-flex flex-column justify-content-center align-items-center text-center p-5">

                                <p class="fs-4 mb-4">{{ $ticket->details }}</p>
                                <h5 class="badge fs-4 text-bg-secondary">Room {{ $ticket->room->label }}</h5>


                            </div>
                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="mb-2"># {{ $ticket->id }}</h4>


                                    <span class="badge text-bg-{{ $status['class'] }} fs-5">
                                        {{ $status['label'] }}
                                    </span>
                                </div>

                                <br>

                                <small>{{ $ticket->created_at->diffForHumans() }}</small>
                            </div>


                        </a>

                    </div>

                @endforeach

            </div>

            {{ $tickets->links() }}
        </div>

    </div>

@endsection