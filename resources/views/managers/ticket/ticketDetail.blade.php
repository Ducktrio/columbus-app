@extends("managers.base")


@section('outlet')

    @php
        $statusMap = [
            0 => ['label' => 'Open', 'class' => 'success'],
            1 => ['label' => 'In Progress', 'class' => 'warning'],
            2 => ['label' => 'Resolved', 'class' => 'secondary'],
        ];
        $status = $statusMap[$ticket->status] ?? ['label' => 'Unknown', 'class' => 'dark'];
    @endphp

    <div class="container d-flex flex-column gap-4">

        <div class="row mb-2">


            <div class="card p-4 text-bg-light d-flex flex-row justify-content-between align-items-center">
                <h1 class="">Ticket {{ $ticket->id }}</h1>
                <span class="fs-2 p-4 badge text-bg-{{ $status['class'] }}">
                    {{ $status['label'] }}
                </span>
            </div>

        </div>

        <div class="row gap-4">

            <div class="col">
                <div class="card card-body">


                    <h4 class="mb-2">Change Ticket's Status</h4>


                    <div>

                        <button class="btn btn-outline-secondary {{ $ticket->status == "0" ? 'text-bg-secondary' : ''}}">
                            <a href="{{ route('managers.updateTicketStatus', ['id' => $ticket->id, 'status' => 0]) }}"
                                class="text-decoration-none text-reset">
                                Open
                            </a>
                        </button>
                        <button class="btn btn-outline-secondary {{ $ticket->status == "1" ? 'text-bg-secondary' : ''}}">
                            <a href="{{ route('managers.updateTicketStatus', ['id' => $ticket->id, 'status' => 1]) }}"
                                class="text-decoration-none text-reset">
                                In Progress
                            </a>
                        </button>
                        <button class="btn btn-outline-secondary {{ $ticket->status == "2" ? 'text-bg-secondary' : ''}}">
                            <a href="{{ route('managers.updateTicketStatus', ['id' => $ticket->id, 'status' => 2]) }}"
                                class="text-decoration-none text-reset">
                                Resolved
                            </a>
                        </button>
                    </div>

                    <hr>

                    <h4 class="mb-2">Destroy ticket</h4>

                    <form method="POST" action="{{ route('managers.deleteTicket', $ticket->id) }}"
                        onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                        @csrf
                        @method('DELETE')

                        <div class="d-grid">

                            <button type="submit" class="btn btn-outline-danger">Void Ticket</button>
                        </div>
                    </form>

                </div>

            </div>




            <div class="col">
                <form method="POST" action=" {{ route('managers.updateTicket', ['id' => $ticket->id]) }}">

                    @csrf
                    <div class="card card-body">
                        <p class="card-text">
                            <strong>Service: </strong> {{  $ticket->service ? $ticket->service->name : 'N/A' }}<br>
                            <strong>Room:</strong> {{ $ticket->room->label }}<br>
                            <strong>Customer:</strong> {{ $ticket->customer->courtesy_title }}

                            {{ $ticket->customer->full_name }}<br>

                            <strong>Details:</strong>

                            <textarea class="form-control mb-2" rows="4" id="details"
                                name="details">{{ $ticket->details }}</textarea>

                            <strong>Created At:</strong> {{ $ticket->created_at->format('M d, Y h:i A') }}<br>
                            <strong>Updated At:</strong> {{ $ticket->updated_at->format('M d, Y h:i A') }}<br>
                        </p>

                        <button type="submit" class="btn btn-primary">
                            Update Ticket
                        </button>
                    </div>
                </form>
            </div>


            <a href="{{ route('managers.listTickets') }}" class="btn btn-outline-primary">
                Back to Tickets
            </a>
        </div>
    </div>
@endsection