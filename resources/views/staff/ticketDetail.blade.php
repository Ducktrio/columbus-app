@extends('staff.base')

@section('outlet')

    <div class="container d-flex flex-column gap-4">

        <div class="row mb-2">

            <div class="col d-flex flex-column gap-4">

                <div class="card text-bg-dark p-5 text-center">
                    <h1 class="mb-2">{{ $ticket->details }}</h1>
                </div>

                <div class="card card-body">
                    <h4 class="mb-5">Ticket #{{ $ticket->id }}</h4>
                    <h1 class="fw-bold mb-5">Room {{ $ticket->room->label }}

                        @if($ticket->status === 0)
                            <div class="spinner-grow text-warning" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>

                        @endif

                    </h1>


                    @if($ticket->status === 0)

                        <span class="badge text-bg-warning fs-5 mb-2">Open</span>
                        <p class="text-muted">{{ $ticket->created_at->diffForHumans() }}</p>

                    @elseif($ticket->status === 1)

                        <span class="badge text-bg-primary fs-5 mb-2 d-flex flex-row align-items-center justify-content-center gap-5 progress-bar progress-bar-striped progress-bar-animated">
                            In Progress <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div></span>
                        <p class="text-muted">Last Update: {{ $ticket->updated_at->diffForHumans() }}</p>


                    @elseif($ticket->status === 2)

                        <span
                            class="badge text-bg-success fs-5 mb-2 d-flex flex-row align-items-center justify-content-center gap-2">Resolved
                            <i class="bi bi-check-all fs-1"></i></span>
                        <p class="text-muted">Resolved at: {{ $ticket->updated_at }}</p>
                    @endif
                </div>

            </div>

            <div class="col">

                <div class="card p-5 text-center">

                    <h2 class="mb-4">Command Panel</h2>


                    <div class="d-grid gap-2">
                        <a href="{{ route('staff.dashboard') }}?service_id={{ $ticket->service->id }}"
                            class="btn btn-outline-secondary py-4"><i class="bi bi-arrow-return-left me-2"></i> Back to
                            Dashboard</a>
                        @if($ticket->status === 0)

                            <a href="{{ route('ticket.take', ['id' => $ticket->id]) }}" class="btn btn-outline-primary py-4"><i
                                    class="bi bi-check me-2"></i> Mark as In Progress</a>


                        @elseif($ticket->status === 1)

                            @php
                                $canResolve = now()->diffInMinutes($ticket->updated_at) >= 5;
                            @endphp

                            <a href="{{ route('ticket.close', ['id' => $ticket->id]) }}" class="btn btn-outline-success py-4"
                                @if(!$canResolve)
                                    onclick="event.preventDefault(); showToast('You can mark as resolved after 5 minutes from last update.');"
                                @endif>
                                <i class="bi bi-check-all me-2"></i> Mark as Resolved
                            </a>

                            <script>
                                function showToast(message) {
                                    let toast = document.createElement('div');
                                    toast.className = 'toast align-items-center text-bg-warning border-0 show position-fixed bottom-0 end-0 m-3';
                                    toast.role = 'alert';
                                    toast.innerHTML = `
                                                <div class="d-flex">
                                                    <div class="toast-body">${message}</div>
                                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                                                </div>
                                            `;
                                    document.body.appendChild(toast);
                                    setTimeout(() => toast.remove(), 1000);
                                }
                            </script>

                        @endif
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection