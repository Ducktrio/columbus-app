@extends('receptionist.base')


@section('outlet')

    <div class="row">
        <h1>Tickets</h1>
    </div>

    <hr class="mb-5">


    <!-- Filters -->
    <div class="row mb-5">
        <ul class="nav nav-pills nav-fill fs-4">

            <li class="nav-item fs-4 d-grid gap-2 p-2">

                <a class="nav-link mb-2 {{ request('status') === '0' ? 'active' : '' }}"
                    href="{{ route('reception.tickets', array_merge(request()->query(), ['status' => '0'])) }}">
                    Open

                    
                </a>
                <span class="card card-body text-bg-light">
                    {{ \App\Models\ServiceTicket::query()->where('status', 0)->count() }}
                </span>

            </li>

            <li class="nav-item fs-4 d-grid gap-2 p-2">

                <a class="nav-link mb-2 {{ request('status') === '1' ? 'active' : '' }}"
                    href="{{ route('reception.tickets', array_merge(request()->query(), ['status' => '1'])) }}">
                    In Progress

                    
                </a>
                <span class="card card-body text-bg-light">
                    {{ \App\Models\ServiceTicket::query()->where('status', 1)->count() }}
                </span>
            </li>
           
            <li class="nav-item fs-4 d-grid gap-2 p-2">

                <a class="nav-link mb-2 {{ request('status') === '2' ? 'active' : '' }}"
                    href="{{ route('reception.tickets', array_merge(request()->query(), ['status' => '2'])) }}">
                    Resolved

                    
                </a>
                <span class="card card-body text-bg-light">
                    {{ \App\Models\ServiceTicket::query()->where('status', 2)->count() }}
                </span>
            </li>

        </ul>

    </div>

    <!-- Lists -->
    <div class="row card card-body">
        <ul class="nav nav-tabs nav-fill">

            @foreach(\App\Models\Service::all() as $service)
                <li class="nav-item">
                    <a class="nav-link {{ request('service') === $service->id ? 'active' : '' }}"
                        href="{{ route('reception.tickets', array_merge(request()->query(), ['service' => $service->id])) }}">
                        {{ $service->name }}

                        @if(\App\Models\ServiceTicket::query()->where('status',request()->query('status'))->where('service_id', $service->id)->count() > 0)
                            <span class="badge bg-secondary ms-2">{{ \App\Models\ServiceTicket::query()->where('status',request()->query('status'))->where('service_id', $service->id)->count() }}</span>
                        @endif

                    </a>
                </li>
            @endforeach

        </ul>


        <div class="row g-4 mt-3">
            @if ($tickets->isEmpty())
                <div class="list-group-item">
                    <p class="text-muted">No tickets available.</p>
                </div>
            @endif

            @foreach ($tickets as $ticket)

                <div class="col-4">

                    @include('components.ticket', ['ticket' => $ticket, 'target' => 'reception.tickets.ticketDetail'])

                </div>

            @endforeach

            {{ $tickets->links() }}
        </div>



    </div>



@endsection