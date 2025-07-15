@extends('receptionist.base')

@section('outlet')

    <div class="row">
        <h1>Ticket #{{ $ticket->id }}</h1>
    </div>

    <hr class="mb-5">

    <div class="row">

        <div class="col-3"></div>

        <div class="col-6 d-grid gap-4">
            <div class="card card-body text-center">
                <h2>Room {{ $ticket->room->label }}</h2>
            </div>
            
            <div class="card card-body d-flex flex-row justify-content-between align-items-center">
                <span class="fs-2">Status</span>
                <span class="fs-2">
                    @if($ticket->status === 0)
                        <span class="badge text-bg-warning fs-5 mb-2">Open</span>
                    @elseif($ticket->status === 1)
                        <span class="badge text-bg-primary fs-5 mb-2">In Progress</span>
                    @elseif($ticket->status === 2)
                        <span class="badge text-bg-success fs-5 mb-2">Resolved</span>
                    @endif
                </span>
            </div>

            <div class="card card-body">
                <p>{{ $ticket->details }}</p>
                <span class="text-muted"><i class="bi bi-pencil"></i> {{ $ticket->created_at->diffForHumans() }}</span>
        </div>

        <div class="col-3"></div>

    </div>

@endsection