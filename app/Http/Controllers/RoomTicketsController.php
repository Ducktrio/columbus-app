<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateRoomTicketRequest;
use App\Http\Requests\UpdateRoomTicketRequest;
use Illuminate\Http\Request;
use App\Models\RoomTicket;

class RoomTicketsController extends Controller
{
    public function create(CreateRoomTicketRequest $createRoomTicketRequest)
    {
        $data = $createRoomTicketRequest->validated();
        RoomTicket::create([
            'customer_id' => $data->customer_id,
            'room_id' => $data->room_id,
            'number_of_occupants' => $data->number_of_occupants,
        ]);
        return response()->json(['message' => 'Room ticket created successfully'], 201);
    }

    public function get($id = null)
    {
        if ($id) {
            $roomTicket = RoomTicket::get($id);
            if ($roomTicket) {
                return $roomTicket;
            }
            return response()->json(['message' => 'Room ticket not found'], 404);
        }
        return RoomTicket::all();
    }

    public function update($id, UpdateRoomTicketRequest $updateRoomTicketRequest)
    {
        $roomTicket = RoomTicket::get($id);
        if ($roomTicket) {
            $data = $updateRoomTicketRequest->validated();
            $roomTicket->customer_id = $data->customer_id ?? $roomTicket->customer_id;
            $roomTicket->room_id = $data->room_id ?? $roomTicket->room_id;
            $roomTicket->number_of_occupants = $data->number_of_occupants ?? $roomTicket->number_of_occupants;
            return response()->json(['message' => 'Room ticket updated successfully'], 200);
        }
        return response()->json(['message' => 'Room ticket not found'], 404);
    }

    public function delete($id)
    {
        $roomTicket = RoomTicket::find($id);
        if ($roomTicket) {
            $roomTicket->delete();
            return response()->json(['message' => 'Room ticket deleted successfully'], 200);
        }
        return response()->json(['message' => 'Room ticket not found'], 404);
    }

    public function checkIn($id)
    {
        $roomTicket = RoomTicket::get($id);
        if ($roomTicket) {
            $roomTicket->check_in();
            return response()->json(['message' => 'Checked in successfully'], 200);
        }
        return response()->json(['message' => 'Room ticket not found'], 404);
    }

    public function checkOut($id)
    {
        $roomTicket = RoomTicket::get($id);
        if ($roomTicket) {
            $roomTicket->check_out();
            return response()->json(['message' => 'Checked out successfully'], 200);
        }
        return response()->json(['message' => 'Room ticket not found'], 404);
    }

    public function search($id = null, $customer_id = null, $room_id = null, $check_in_date = null, $check_out_date = null, $number_of_occupants = null)
    {
        $query = RoomTicket::query();
        if ($id) {
            $query->where('id', $id);
        }
        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }
        if ($room_id) {
            $query->where('room_id', $room_id);
        }
        if ($check_in_date) {
            $query->whereDate('check_in_date', $check_in_date);
        }
        if ($check_out_date) {
            $query->whereDate('check_out_date', $check_out_date);
        }
        if ($number_of_occupants) {
            $query->where('number_of_occupants', $number_of_occupants);
        }
        $search = $query->get();
        if ($search) {
            return $search;
        }
        return response()->json(['message' => 'Room ticket not found'], 404);
    }
}
