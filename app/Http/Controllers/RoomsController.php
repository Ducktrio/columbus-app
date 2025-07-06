<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomsController extends Controller
{
    public function create(CreateRoomRequest $createRoomRequest)
    {
        $data = $createRoomRequest->validated();
        Room::create([
            'label' => $data->label,
            'room_type_id' => $data->room_type_id,
        ]);
        return response()->json(['message' => 'Room created successfully'], 201);
    }

    public function get($id = null)
    {
        if ($id) {
            $room = Room::find($id);
            if ($room) {
                return $room;
            }
            return response()->json(['message' => 'Room not found'], 404);
        }
        return Room::all();
    }

    public function update($id, UpdateRoomRequest $updateRoomRequest)
    {
        $room = Room::get($id);
        if ($room) {
            $data = $updateRoomRequest->validated();
            $room->label = $data->label ?? $room->label;
            $room->room_type_id = $data->room_type_id ?? $room->room_type_id;
        }
    }

    public function delete($id)
    {
        $room = Room::get($id);
        if ($room) {
            $room->delete();
            return response()->json(['message' => 'Room deleted successfully', 200]);
        }
        return response()->json(['message' => 'Room not found', 404]);
    }
}
