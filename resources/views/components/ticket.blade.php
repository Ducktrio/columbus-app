<a href="{{ route($target, ['id' => $ticket->id]) }}" class="card text-decoration-none">
    <div class="card-header text-bg-light d-flex flex-column justify-content-center align-items-center text-center p-5">

        <p class="fs-4 mb-4">{{ $ticket->details }}</p>
        <h5 class="fs-4 fw-bold">Room {{ $ticket->room->label }}</h5>


    </div>
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="mb-2"># {{ $ticket->id }}</h4>

            @php
                $statusMap = [
                    0 => ['label' => 'Open', 'class' => 'warning'],
                    1 => ['label' => 'In Progress', 'class' => 'primary'],
                    2 => ['label' => 'Resolved', 'class' => 'success'],
                ];
                $status = $statusMap[$ticket->status] ?? ['label' => 'Unknown', 'class' => 'dark'];
            @endphp


            <span class="badge text-bg-{{ $status['class'] }} fs-5">
                {{ $status['label'] }}
            </span>
        </div>

        <br>

        <div class="d-flex justify-content-between align-items-center mt-2">
            <small><i class="bi bi-pen-fill"></i> {{ $ticket->created_at->diffForHumans() }}</small>
            @if($ticket->status === 1)
            <small class="text-muted">Last updated {{ $ticket->updated_at->diffForHumans() }}</small>
            @elseif($ticket->status === 2)
                <small class="text-muted">Resolved at {{ $ticket->updated_at }}</small>
            @endif
            </div>
    </div>


</a>