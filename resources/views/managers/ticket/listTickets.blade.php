@extends('managers.base')
@section('outlet')

    <div class="container d-flex flex-column gap-4">

        <div class="row mb-2">

            <h1 class="mb-3">Tickets</h1>
            <ul class="nav nav-pills nav-fill mb-3">
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === '0' ? 'active' : '' }}"
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

            <div class="list-group mb-5">

                @if (count($tickets) === 0)
                    <div class="list-group-item">
                        <p class="text-muted">No tickets available.</p>
                    </div>
                @endif

                @foreach ($tickets as $ticket)

                    <a href="{{ route('managers.ticketDetail', ["id" => $ticket->id]) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">#{{ $ticket->id }}</h5>
                            <small>{{ $ticket->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">
                            {{ $ticket->details }}
                        </p>
                        @php
                            $statusMap = [
                                0 => ['label' => 'Open', 'class' => 'success'],
                                1 => ['label' => 'In Progress', 'class' => 'warning'],
                                2 => ['label' => 'Resolved', 'class' => 'secondary'],
                            ];
                            $status = $statusMap[$ticket->status] ?? ['label' => 'Unknown', 'class' => 'dark'];
                        @endphp
                        <span class="badge bg-{{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </a>

                @endforeach

            </div>

            {{ $tickets->links() }}
        </div>

    </div>

@endsection