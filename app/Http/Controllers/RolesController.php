<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RolesController extends Controller
{
    public function get($id = null)
    {
        if ($id) {
            $role = Role::find($id);
            if ($role) {
                return $role;
            }
            return response()->json(['message' => 'Role not found'], 404);
        }
        return Role::all();
    }
}
