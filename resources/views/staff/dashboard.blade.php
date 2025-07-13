@extends('staff.base')

@section('outlet')

    <div class="row mb-5">
        <ul class="nav nav-tabs">
            @php
                $query = request()->query();
            @endphp

            <li class="nav-item">
                <a class="nav-link {{ request('status') === '0' ? 'active' : '' }}"
                    href="{{ url()->current() . '?' . http_build_query(array_merge($query, ['status' => '0'])) }}">Open</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === '1' ? 'active' : '' }}"
                    href="{{ url()->current() . '?' . http_build_query(array_merge($query, ['status' => '1'])) }}">In
                    Progress</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') === '2' ? 'active' : '' }}"
                    href="{{ url()->current() . '?' . http_build_query(array_merge($query, ['status' => '2'])) }}">Resolved</a>
            </li>
        </ul>
    </div>


    <div class="row row-cols-3 g-5 mb-5">

        @if (count($tickets) === 0)
            <div class="list-group-item">
                <p class="text-muted">No tickets available.</p>
            </div>
        @endif
        @foreach ($tickets as $ticket)
            <div class="col">
                @include('components.ticket', ['ticket' => $ticket, 'target' => 'staff.ticketDetail'])
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col">
            {{ $tickets->links() }}
        </div>
    </div>
@endsection