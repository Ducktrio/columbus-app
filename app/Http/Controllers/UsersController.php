<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
class UsersController extends Controller
{
    public function get($id = null)
    {
        if ($id) {
            $user = User::find($id);
            if ($user) {
                return $user;
            }
            return response()->json(['message' => 'User not found'], 404);
        }
        return User::all();
    }

    public function update($id, UpdateUserRequest $updateUserRequest)
    {
        $user = User::find($id);
        if ($user) {
            $data = $updateUserRequest->validated();
            $user->role_id = $data->role_id ?? $user->role_id;
            $user->username = $data->username ?? $user->username;
            $user->password = $data->password ?? $user->password;
            $user->description = $data->description ?? $user->description;
            $user->save();
            return response()->json(['message' => 'User updated successfully'], 200);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user && $user->role->title !== 'Manager') {
            $user->delete();
            return redirect()->route('managers.listUsers')->with('success', 'User [' . $user->username . '] deleted successfully');
        }
        return redirect()->back()->with('error', 'User cannot be deleted');
    }

    public function search($id = null, $role_id = null, $username = null, $description = null)
    {
        $query = User::query();
        if ($id) {
            $query->where('id', $id);
        }
        if ($role_id) {
            $query->where('role_id', $role_id);
        }
        if ($username) {
            $query->where('username', $username);
        }
        if ($description) {
            $query->where('description', $description);
        }
        $search = $query->get();
        if ($search) {
            return $search;
        }
        return response()->json(['message' => 'Room ticket not found'], 404);
    }
}
