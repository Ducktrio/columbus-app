<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\RoomTicket;
use App\Models\RoomType;
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
        return redirect()->route("managers.manageRooms", ['status' => '0', "room_type" => RoomType::query()->get()->first()->id])->with("success", "Room [" . $data['label'] . "] is registered");
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
        $room = Room::find($id);
        if ($room) {
            $data = $updateRoomRequest->validated();
            $room->label = $data['label'] ?? $room->label;
            $room->room_type_id = $data['room_type_id'] ?? $room->room_type_id;
            $room->save();
            return redirect()->back()->with("success", "Room updated successfully");
            // return response()->json(['message' => 'Room updated successfully', 200]);
        }
        return redirect()->back()->with("error", "Room not found");
        // return response()->json(['message' => 'Room not found', 404]);
    }

    public function delete($id)
    {
        $room = Room::find($id);
        if ($room) {
            $room->delete();
            return redirect()->route("managers.manageRooms", ["status" => "0", "room_type" => RoomType::query()->first()->id])->with("success", "Room deleted successfully");
            // return response()->json(['message' => 'Room deleted successfully', 200]);
        }
        return redirect()->route("managers.manageRooms")->with("error", "Room not found");
        // return response()->json(['message' => 'Room not found', 404]);
    }

    public function updateStatus(Request $request, $id, $status)
    {
        $room = Room::find($id);
        if ($room) {
            if (in_array($status, [0, 1, 2])) {
                $room->status = $status;
                $room->save();
                return redirect()->back()->with("success", "Room status updated successfully");
            }
            return redirect()->back()->with("error", "Invalid status value");
        }
        return redirect()->back()->with("error", "Room not found");
    }

    public function search($id = null, $label = null, $room_type_id = null)
    {
        $query = Room::query();
        if ($id) {
            $query->where('id', $id);
        }
        if ($label) {
            $query->where('label', $label);
        }
        if ($room_type_id) {
            $query->where('room_type_id', $room_type_id);
        }
        $search = $query->paginate(5);
        if ($search) {
            return $search; 
        }
        return response()->json(['message' => 'Room ticket not found'], 404);
    }
}
