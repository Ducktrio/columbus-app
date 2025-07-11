<?php

namespace App\Http\Requests;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class CreateServiceTicketRequest extends FormRequest
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
            'customer_id' => 'required|exists:customers,id',
            'room_id' => 'required|exists:rooms,id',
            'service_id' => 'required|exists:services,id',
            'details' => 'required|string|max:255',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors();
        if ($errors->has('customer_id')) {
            $this->merge(['customer_id' => null]);
        }
        if ($errors->has('room_id')) {
            $this->merge(['room_id' => null]);
        }
        if ($errors->has('service_id')) {
            $this->merge(['service_id' => null]);
        }
        if ($errors->has('details')) {
            $this->merge(['details' => '']);
        }
        return redirect()->back()->with('error', $errors)->withInput();
    }
}
