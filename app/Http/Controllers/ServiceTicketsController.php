<?php

namespace App\Http\Controllers;
use App\Models\ServiceTicket;
use App\Http\Requests\CreateServiceTicketRequest;
use App\Http\Requests\UpdateServiceTicketRequest;
use Illuminate\Http\Request;

class ServiceTicketsController extends Controller
{
    public function create(CreateServiceTicketRequest $createServiceTicketRequest)
    {
        $data = $createServiceTicketRequest->validated();
        if ($data) {
            ServiceTicket::create([
                'customer_id' => $data->customer_id,
                'room_id'->$data->room_id,
                'service_id'->$data->service_id,
                'details'->$data->details,
            ]);
            return response()->json(['message' => 'Service ticket created successfully'], 201);
        }
    }

    public function get($id = null)
    {
        if ($id) {
            $serviceTicket = ServiceTicket::get($id);
            if ($serviceTicket) {
                return $serviceTicket;
            }
            return response()->json(['message' => 'Service ticket not found'], 404);
        }
        return ServiceTicket::all();
    }

    public function update($id, UpdateServiceTicketRequest $updateServiceTicketRequest)
    {
        $serviceTicket = ServiceTicket::get($id);
        if ($serviceTicket) {
            $data = $updateServiceTicketRequest->validated();
            $serviceTicket->customer_id = $data->customer_id ?? $serviceTicket->customer_id;
            $serviceTicket->room_id = $data->room_id ?? $serviceTicket->room_id;
            $serviceTicket->service_id = $data->service_id ?? $serviceTicket->room_id;
            $serviceTicket->details = $data->details ?? $serviceTicket->details;
            return response()->json(['message' => 'Service ticket updated successfully'], 200);
        }
        return response()->json(['message' => 'Service ticket not found'], 404);
    }

    public function delete($id)
    {
        $serviceTicket = ServiceTicket::get($id);
        if ($serviceTicket) {
            $serviceTicket->delete();
            return response()->json(['message' => 'Service ticket deleted successfully'], 200);
        }
        return response()->json(['message' => 'Service ticket not found'], 404);
    }

    public function take($id)
    {
        $serviceTicket = ServiceTicket::get($id);
        if ($serviceTicket) {
            $serviceTicket->status = 1;
            $serviceTicket->save();
            return response()->json(['message' => 'Service ticket taken successfully'], 200);
        }
        return response()->json(['message' => 'Service ticket not found'], 404);
    }

    public function close($id)
    {
        $serviceTicket = ServiceTicket::get($id);
        if ($serviceTicket) {
            $serviceTicket->status = 2;
            $serviceTicket->save();
            return response()->json(['message' => 'Service ticket closed successfully'], 200);
        }
        return response()->json(['message' => 'Service ticket not found'], 404);
    }

    public function search($id = null, $customer_id = null, $room_id = null, $service_id = null, $details = null)
    {
        $query = ServiceTicket::query();
        if ($id) {
            $query->where('id', $id);
        }
        if ($room_id) {
            $query->where('room_id', $room_id);
        }
        if ($service_id) {
            $query->whereDate('service_id', $service_id);
        }
        if ($details) {
            $query->where('details', $details);
        }
        $search = $query->get();
        if ($search) {
            return $search;
        }
        return response()->json(['message' => 'Service ticket not found'], 404);
    }
}
