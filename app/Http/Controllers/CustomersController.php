<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\CreateCustomerRequest;
use Illuminate\Http\Request;
use App\Models\Customer;
class CustomersController extends Controller
{
    public function create(CreateCustomerRequest $createCustomerRequest)
    {
        $data = $createCustomerRequest->validated();
        Customer::create([
            'courtesy_title' => $data->courtesy_title,
            'full_name' => $data->full_name,
            'age' => $data->age,
            'contact_info' => $data->contact_info,
            'phone_number' => $data->phone_number,
        ]);
        return response()->json(['message' => 'Customer created successfully', 201]);
    }

    public function get($id = null)
    {
        if ($id) {
            $customer = Customer::find($id);
            if ($customer) {
                return $customer;
            }
            return response()->json(['message' => 'Customer not found'], 404);
        }
        return Customer::all();
    }

    public function update($id, UpdateCustomerRequest $updateCustomerRequest)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $data = $updateCustomerRequest->validated();
            $customer->courtesy_title = $data->courtesy_title ?? $customer->courtesy_title;
            $customer->full_name = $data->full_name ?? $customer->full_name;
            $customer->age = $data->age ?? $customer->age;
            $customer->contact_info = $data->contact_info ?? $customer->contact_info;
            $customer->phone_number = $data->phone_number ?? $customer->phone_number;
            $customer->save();
            return response()->json(['message' => 'Customer data updated successfully', 200]);
        }
        return response()->json(['message' => 'Customer not found', 404]);
    }

    public function delete($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->delete();
            return response()->json(['message' => "Customer deleted successfully", 200]);
        }
        return response()->json(['message' => 'User not found', 404]);
    }
}
