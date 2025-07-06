<?php

namespace App\Http\Requests;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $allowedRoles = Role::whereIn('title', ['Manager', 'Receptionist'])->pluck('id')->toArray();
        if (!$user || empty($allowedRoles)) {
            return false;
        }
        return in_array($user->role_id, $allowedRoles);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'nullable|exists:customers,id',
            'room_id' => 'nullable|exists:rooms,id',
            'service_id' => 'nullable|exists:services,id',
            'details' => 'nullable|string|max:255',
        ];
    }
}
