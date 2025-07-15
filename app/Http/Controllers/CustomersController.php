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
        $customer = Customer::create([
            'courtesy_title' => $data['courtesy_title'] ?? null,
            'full_name' => $data['full_name'] ?? null,
            'age' => $data['age'] ?? null,
            'contact_info' => $data['contact_info'] ?? null,
            'phone_number' => $data['phone_number'] ?? null,
        ]);
        if (isset($data['redirect_to']) && !empty($data['redirect_to'])) {
            $redirectUrl = $data['redirect_to'];
            $separator = (parse_url($redirectUrl, PHP_URL_QUERY) === null) ? '?' : '&';
            return redirect()->to($redirectUrl . $separator . "customer=" . $customer->id)->with('success', 'Customer created successfully');
        }
        return redirect()->back()->with('success', 'Customer created successfully');
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

    public function search($id = null, $courtesy_title = null, $full_name = null, $age = null, $contact_info = null, $phone_number = null)
    {
        $query = Customer::query();
        if ($id) {
            $query->where('id', $id);
        }
        if ($courtesy_title) {
            $query->where('courtesy_title', $courtesy_title);
        }
        if ($full_name) {
            $query->where('full_name', $full_name);
        }
        if ($age) {
            $query->where('age', $age);
        }
        if ($contact_info) {
            $query->where('contact_info', $contact_info);
        }
        if ($phone_number) {
            $query->where('phone_number', $phone_number);
        }
        $search = $query->get();
        if ($search) {
            return $search;
        }
        return response()->json(['message' => 'Room ticket not found'], 404);
    }
}
