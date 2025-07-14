<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;

class CreateCustomerRequest extends FormRequest
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
     
     * Validation rules for creating a customer:
     * - courtesy_title: Required, string, maximum 255 characters.
     * - full_name: Required, string, maximum 255 characters.
     * - age: Required, numeric, must be at least 18 years old.
     * - contact_info: Optional, string, maximum 255 characters.
     * - phone_number: Optional, string, maximum 20 characters.
     *
     * Please ensure all required fields are filled and age is 18 or older.
     */
    public function rules(): array
    {
        return [
            'redirect_to' => 'nullable|string|max:255',
            // Optional redirect_to parameter to specify where to redirect after successful creation
            'courtesy_title' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'age' => 'required|numeric|min:18',
            // Changed from min:0 to min:18 to ensure customers are adults


            'contact_info' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return redirect()->back()->with('error', 'Validation failed. Please check your input.')->withInput()->withErrors($validator);
    }
}
