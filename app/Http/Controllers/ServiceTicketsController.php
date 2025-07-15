<?php

namespace App\Http\Controllers;
use App\Models\ServiceTicket;
use App\Http\Requests\CreateServiceTicketRequest;
use App\Http\Requests\UpdateServiceTicketRequest;
use Auth;
use Illuminate\Http\Request;

class ServiceTicketsController extends Controller
{
    public function create(CreateServiceTicketRequest $createServiceTicketRequest)
    {
        $data = $createServiceTicketRequest->validated();
        if ($data) {
            $ticket = ServiceTicket::create([
                'customer_id' => $data['customer_id'],
                'room_id' => $data['room_id'],
                'service_id' => $data['service_id'],
                'details' => $data['details'],
            ]);
            return redirect()->back()->with('success', 'Service ticket created successfully')->with('id', $ticket->id);
        }
        return redirect()->back()->with('error', 'Failed to create service ticket');
    }

    public function get($id = null)
    {
        if ($id) {
            $serviceTicket = ServiceTicket::find($id);
            if ($serviceTicket) {
                return $serviceTicket;
            }
            return response()->json(['message' => 'Service ticket not found'], 404);
        }
        return ServiceTicket::all();
    }

    public function update($id, UpdateServiceTicketRequest $updateServiceTicketRequest)
    {
        $serviceTicket = ServiceTicket::find($id);
        if ($serviceTicket) {
            $data = $updateServiceTicketRequest->validated();
            $serviceTicket->customer_id = $data['customer_id'] ?? $serviceTicket->customer_id;
            $serviceTicket->room_id = $data['room_id'] ?? $serviceTicket->room_id;
            $serviceTicket->service_id = $data['service_id'] ?? $serviceTicket->service_id;
            $serviceTicket->details = $data['details'] ?? $serviceTicket->details;
            $serviceTicket->save();
            return redirect()->back()->with('success', 'Service ticket updated successfully');
        }
        return redirect()->back()->with('error', 'Service ticket not found');
    }

    public function delete($id)
    {
        $serviceTicket = ServiceTicket::find($id);
        if ($serviceTicket) {
            $serviceTicket->delete();
            if(\Illuminate\Support\Facades\Auth::user()->role->title === 'Manager') {
                return redirect()->route('managers.listTickets')->with('success', 'Service ticket deleted successfully');
            }
            // If the user is not a manager, redirect back
            return redirect()->back()->with('success', 'Service ticket deleted successfully');
        }
        return redirect()->back()->with('error', 'Service ticket not found');
    }

    public function take($id)
    {
        $serviceTicket = ServiceTicket::find($id);
        if ($serviceTicket) {
            $serviceTicket->status = 1;
            $serviceTicket->save();
            return redirect()->back()->with('success', 'Service ticket taken successfully');
        }
        return redirect()->back()->with('error', 'Service ticket not found');
    }

    public function close($id)
    {
        $serviceTicket = ServiceTicket::find($id);
        if($serviceTicket->service->name === 'Cleaning' && $serviceTicket->room->status === 2) {
            return $this->prepareRoom($id);
        }
        if ($serviceTicket) {
            $serviceTicket->status = 2;
            $serviceTicket->save();
            return redirect()->back()->with('success', 'Service ticket closed successfully');
        }
        return redirect()->back()->with('error', 'Service ticket not found');
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

    public function updateStatus($id, $status)
    {
        $serviceTicket = ServiceTicket::find($id);
        if ($serviceTicket) {
            $serviceTicket->status = $status;
            $serviceTicket->save();
            return redirect()->back()->with('success', 'Service ticket status updated successfully');
        }
        return redirect()->back()->with('error', 'Service ticket not found');
    }

    public function prepareRoom($id) {
        $ticket = ServiceTicket::find($id);
        if($ticket->service->name !== 'Cleaning') {
            return redirect()->back()->with('error', 'This service is not available for room preparation');
        }
        if($ticket->room->status !== 2) {
            return redirect()->back()->with('error', 'Room is occupied, this is probably a standard request (not for checked out)');
        }
        $ticket->status = 2; // Set ticket to resolved
        $ticket->room->status = 0; // Set to available
        $ticket->save();
        $ticket->room->save();
        return redirect()->back()->with('success', 'Room are now available');

    }
}
