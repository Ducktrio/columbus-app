<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use Illuminate\Http\Request;
use App\Models\RoomType;
class RoomTypesController extends Controller
{

    public function create(CreateRoomTypeRequest $createRoomTypeRequest)
    {
        $data = $createRoomTypeRequest->validated();
        RoomType::create([
            'name' => $data->name,
            'description' => $data->description,
            'price' => $data->price,
        ]);
        return response()->json(['message' => 'Room type created successfully'], 201);
    }
    public function get($id = null)
    {
        if ($id) {
            $roomType = RoomType::find($id);
            if ($roomType) {
                return $roomType;
            }
            return response()->json(['message' => 'Room type not found'], 404);
        }
        return RoomType::all();
    }

    public function update($id, UpdateRoomTypeRequest $updateRoomTypeRequest)
    {
        $roomType = RoomType::find($id);
        if ($roomType) {
            $data = $updateRoomTypeRequest->validated();
            $roomType->name = $data->name ?? $roomType->name;
            $roomType->description = $data->description ?? $roomType->description;
            $roomType->price = $data->price ?? $roomType->price;
            return response()->json(['message' => 'Room type data updated successfully', 200]);
        }
        return response()->json(['message' => 'Room type not found', 404]);
    }

    public function delete($id)
    {
        $roomType = RoomType::find($id);
        if ($roomType) {
            $roomType->delete();
            return response()->json(['message' => 'Room type deleted successfully', 200]);
        }
        return response()->json(['message' => 'Room type not found', 404]);
    }

    public function search($id = null, $name = null, $description = null, $price = null)
    {
        $query = RoomType::query();
        if ($id) {
            $query->where('id', $id);
        }
        if ($name) {
            $query->where('name', $name);
        }
        if ($description) {
            $query->where('description', $description);
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
