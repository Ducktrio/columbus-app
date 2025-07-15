<a role="div" href="{{ route($target, ["id" => $room->id]) }}" class="card text-center text-decoration-none">

    <div class="card-body gy-5">
        <h5 class="card-title">

            {{ $room->label }}



        </h5>
        Type: <span class="badge bg-secondary mb-5">{{ $room->roomType->name }}</span>
        <span
            class="card p-2 text-center text-bg-{{ $room->status == 0 ? 'success' : ($room->status == 1 ? 'secondary' : 'danger') }}">
            {{ $room->status == 0 ? 'Available' : ($room->status == 1 ? 'Occupied' : 'Unavailable') }}
        </span>

    </div>

</a>