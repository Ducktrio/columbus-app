<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $managerRole = Role::where('title', 'Manager')->first();
        if (!$user || !$managerRole) {
            return false;
        }
        return $user->role_id == $managerRole->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role_id' => 'nullable|exists:roles,id',
            'username' => 'nullable|string|max:255|unique:users,username',
            'password' => 'nullable|string|min:8|confirmed',
            'description' => 'nullable|string|max:500',
        ];
    }
}
