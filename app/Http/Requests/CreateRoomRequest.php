<?php

namespace App\Http\Requests;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class CreateRoomRequest extends FormRequest
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
            'label' => 'required|string|max:255',
            'room_type_id' => 'required|string|max:255',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator){
        return redirect()->back()->with("error", $validator->errors());
    }
}
