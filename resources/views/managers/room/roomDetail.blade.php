@extends('managers.base')
@section('outlet')
<div class="container d-flex flex-column gap-4">
    <div class="row mb-2">
        <h1>Room Detail</h1>
    </div>
    <div class="row mb-5">
        <div class="col-md-6">
            <form class="mb-2" method="POST" action="{{ route('managers.updateRoom', ["id" => $room->id]) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="label" class="form-label">Room Label</label>
                    <input type="text" class="form-control" id="label" name="label" value="{{ $room->label }}" required>
                </div>
                <div class="mb-3">
                    <label for="room_type_id" class="form-label">Room Type</label>
                    <select class="form-select" id="room_type_id" name="room_type_id" required>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ $room->roomType->id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-grid">

                    <button type="submit" class="btn btn-primary">Update Room</button>

                </div>

            </form>

            <form method="POST" action="{{ route('managers.deleteRoom', $room->id) }}"
              onsubmit="return confirm('Are you sure you want to delete this room?');">
                @csrf
                @method('DELETE')

                <div class="d-grid">

                    <button type="submit" class="btn btn-danger">Delete Room</button>

                </div>

            </form>

            
        </div>


        <div class="col-md-6">
            <h4>Room Information</h4>
            <p><strong>ID:</strong> {{ $room->id }}</p>
            <p><strong>Label:</strong> {{ $room->label }}</p>
            <p><strong>Type:</strong> {{ $room->roomType->name }}</p>
            <p><strong>Status:</strong> {{ $room->status == 0 ? 'Available' : ($room->status == 1 ? 'Occupied' : 'Unavailable') }}</p>
            <p><strong>Created At:</strong> {{ $room->created_at }}</p>
            <p><strong>Updated At:</strong> {{ $room->updated_at }}</p>
            
        </div>
    </div>
    <div class="row">

        <div class="col-4">

        <h4>Change Room's Status</h4>

        <hr>

            <button class="btn btn-outline-secondary {{ $room->status == "0" ? 'text-bg-primary' : ''}}">
                <a href="{{ route('managers.updateRoomStatus', ['id' => $room->id, 'status' => 0]) }}" class="text-decoration-none text-reset">
                    Available
                </a>
            </button>
            <button class="btn btn-outline-secondary {{ $room->status == "1" ? 'text-bg-primary' : ''}}">
                <a href="{{ route('managers.updateRoomStatus', ['id' => $room->id, 'status' => 1]) }}" class="text-decoration-none text-reset">
                    Occupied
                </a>
            </button>
            <button class="btn btn-outline-secondary {{ $room->status == "2" ? 'text-bg-primary' : ''}}">
                <a href="{{ route('managers.updateRoomStatus', ['id' => $room->id, 'status' => 2]) }}" class="text-decoration-none text-reset">
                    Unavailable
                </a>
            </button>

        </div>
        
    </div>
</div>
@endsection