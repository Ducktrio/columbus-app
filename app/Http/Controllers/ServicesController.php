<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use Illuminate\Http\Request;
use App\Models\Service;
class ServicesController extends Controller
{
    public function create(CreateServiceRequest $createServiceRequest)
    {
        $data = $createServiceRequest->validated();
        Service::create([
            'name' => $data->name,
            'price' => $data->price
        ]);
        return response()->json(['message' => 'Service created successfully'], 201);
    }

    public function get($id = null)
    {
        if ($id) {
            $service = Service::get($id);
            if ($service) {
                return $service;
            }
            return response()->json(['message' => 'Service not found'], 404);
        }
        return Service::all();
    }

    public function update($id, UpdateServiceRequest $updateServiceRequest)
    {
        $service = Service::get($id);
        if ($service) {
            $data = $updateServiceRequest->validated();
            $service->name = $data->name ?? $service->name;
            $service->price = $data->price ?? $service->price;
            return response()->json(['message' => 'Service updated successfully'], 200);
        }
        return response()->json(['message' => 'Service not found'], 404);
    }

    public function delete($id)
    {
        $service = Service::get($id);
        if ($service) {
            $service->delete();
            return response()->json(['message' => 'Service deleted successfully'], 200);
        }
        return response()->json(['message' => 'Service not found'], 404);
    }

    public function search($id = null, $name = null, $price = null)
    {
        $query = Service::query();
        if ($id) {
            $query->where('id', $id);
        }
        if ($name) {
            $query->where('name', $name);
        }
        if ($price) {
            $query->where('price', $price);
        }
        $search = $query->get();
        if ($search) {
            return $search;
        }
        return response()->json(['message' => 'Room ticket not found'], 404);
    }
}
