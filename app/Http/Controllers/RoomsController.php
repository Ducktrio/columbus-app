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
            'label' => $data['label'],
            'room_type_id' => $data['room_type_id']
        ]);
        return redirect()->route("managers.manageRooms")->with("success", "Room [" . $data['label'] . "] is registered");
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
        $room = Room::query()->find($id);
        // $room = Room::get($id); // This line is replaced with the above
        // to ensure we are using the query builder for better flexibility.
        if ($room) {
            $data = $updateRoomRequest->validated();
            $room->label = $data['label'] ?? $room->label;
            $room->room_type_id = $data['room_type_id'] ?? $room->room_type_id;
            $room->save();
            return redirect()->route("managers.roomDetail", ['id' => $room->id])->with("success", "Room updated successfully");
        }
        return redirect()->route("managers.manageRooms")->with("error", "Room not found");
        
    }

    public function delete($id)
    {
        $room = Room::query()->find($id);
        if ($room) {
            $room->delete();
            return redirect()->route("managers.manageRooms")->with("success", "Room deleted successfully");
            // return response()->json(['message' => 'Room deleted successfully', 200]);
        }
        return redirect()->route("managers.manageRooms")->with("error", "Room not found");
        // return response()->json(['message' => 'Room not found', 404]);
    }
}
