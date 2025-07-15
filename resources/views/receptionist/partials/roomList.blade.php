<div class="list-group gap-2" id="room-list">
    @if (count($rooms) === 0)
        <div class="list-group-item">
            <p class="text-muted">No rooms available.</p>
        </div>
    @endif

    @php
        $roomSelected = request()->query('room') ?? old('room_id');

    @endphp

    <div class="d-flex flex-column gap-2" style="max-height: 200px; overflow-y: auto;">
        @foreach ($rooms as $room)
            <input type="radio" class="btn-check room-item" name="room_id" id="room-{{ $room->id }}" value="{{ $room->id }}"
                autocomplete="off" {{ $roomSelected == $room->id ? 'checked' : '' }} data-label="{{ strtolower($room->label) }}"
                data-description="{{ strtolower($room->description) }}">
            <label for="room-{{ $room->id }}" class="btn btn-outline-secondary"
                style="width:100%;">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Room {{ $room->label }}</h5>
                    <h5>#{{ $room->id }}</h5>
                </div>
                <div class="d-flex w-100 justify-content-between">
                    <small>Room Type: {{ $room->roomType->name }}</small>
                    <small>Status: {{ ['Available', 'Occupied', 'Unavailable'][$room->status] ?? 'Unknown' }}</small>
                </div>
            </label>
        @endforeach
    </div>
</div>
