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
}
