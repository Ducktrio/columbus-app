<div class="list-group gap-2" id="room-list">
    @if (count($rooms) === 0)
        <div class="list-group-item">
            <p class="text-muted">No rooms available.</p>
        </div>
    @endif

    @php
        $roomSelected = old('room_id');
    @endphp

    @foreach ($rooms as $room)
        <input type="radio" class="btn-check room-item" name="room_id" id="room-{{ $room->id }}" value="{{ $room->id }}"
            autocomplete="off" {{ $roomSelected == $room->id ? 'checked' : '' }} data-label="{{ strtolower($room->label) }}"
            data-description="{{ strtolower($room->description) }}">
        <label for="room-{{ $room->id }}" class="btn btn-outline-secondary {{ $roomSelected == $room->id ? 'active' : '' }}"
            style="width:100%;">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{ $room->label }} #{{ $room->id }}</h5>
                <small>{{ $room->roomType->name }}</small>
            </div>
            <p class="mb-1">{{ $room->description }}</p>
            <small>Status: {{ $room->status }}</small>
        </label>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-3" id="room-pagination">
    {{ $rooms->links() }}
</div>