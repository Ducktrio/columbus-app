@if(count($roomTickets) === 0)
                <div class="list-group-item">
                    <p class="text-muted">No room checks available.</p>
                </div>
            @endif

            @foreach($roomTickets as $ticket)

                <div class="col-4">

                    <a role="div" class="card card-body text-bg-dark mb-3 text-decoration-none">

                        <h4 class="">Room {{ $ticket->room->label }}</h4>

                    </a>

                    <a class="text-decoration-none" href="{{ route('reception.checkDetail', ["id" => $ticket->id]) }}"
                        id="ticket-{{ $ticket->id }}">

                        <div class="card card-body text-bg-light mb-3">
                            <h5 class="mb-3">Check Details</h5>
                            <p>{{ $ticket->details }}</p>
                            <p><i class="bi bi-people-fill"></i> {{ $ticket->number_of_occupants }}</p>

                            <p><i class="bi bi-person-fill"></i> {{ $ticket->customer->courtesy_title }}
                                {{ $ticket->customer->full_name }}
                            </p>

                            @if ($ticket->check_in === null)

                                <p>Status: <span class="badge text-bg-warning">Pending Check-in</span></p>

                            @elseif ($ticket->check_in !== null && $ticket->check_out === null)

                                <p>Status: <span class="badge text-bg-success">Checked In</span></p>

                            @else

                                <p>Status: <span class="badge text-bg-secondary">Checked Out</span></p>

                            @endif
                        </div>
                    </a>

                </div>

            @endforeach