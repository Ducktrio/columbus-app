<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'role_id' => 'required|exists:roles,id',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8',
            'description' => 'required|string|max:500',
        ];
    }

    // For validation error
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Registration failed due to validation errors');
    }
}
