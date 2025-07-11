<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Role;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use App\Models\ServiceTicket;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'title' => 'Manager'
        ]);
        Role::create([
            'title' => 'Receptionist'
        ]);
        Role::create([
            'title' => 'Staff'
        ]);

        User::create([
            'username' => 'Manager',
            'role_id' => 'R_001',
            'password' => bcrypt('manager123'),
            'description' => 'Hotel Manager'
        ]);
        User::create([
            'username' => 'Receptionist',
            'role_id' => 'R_002',
            'password' => bcrypt('receptionist123'),
            'description' => 'Front Desk Receptionist'
        ]);
        User::create([
            'username' => 'Staff',
            'role_id' => 'R_003',
            'password' => bcrypt('staff123'),
            'description' => 'Hotel Staff'
        ]);

        $service = Service::create([
            'name' => 'Cleaning',
            'price' => 0
        ]);
        Service::create([
            'name' => 'Laundry',
            'price' => 0
        ]);
        Service::create([
            'name' => 'Spa',
            'price' => 75000
        ]);
        Service::create([
            'name' => 'Restaurant',
            'price' => 0
        ]);

        $type = RoomType::create([
            'name' => 'Single',
            'description' => 'A room for one person, equipped with a single bed.',
            'price' => 500000
        ]);
        RoomType::create([
            'name' => 'Double',
            'description' => 'A room for two people, equipped with a double bed.',
            'price' => 750000
        ]);
        RoomType::create([
            'name' => 'Deluxe',
            'description' => 'A more spacious room with additional amenities, suitable for couples or small families.',
            'price' => 900000
        ]);
        RoomType::create([
            'name' => 'Suite',
            'description' => 'A luxurious room with separate living and sleeping areas, ideal for longer stays or special occasions.',
            'price' => 1000000
        ]);

        $room = Room::create([
            'label' => 'A1',
            'room_type_id' => $type->id, 
            'status' => '0',
        ]);

        $customers = [
            [
            'courtesy_title' => 'Mr.',
            'full_name' => 'John Doe',
            'age' => 30,
            'phone_number' => '1234567890',
            ],
            [
            'courtesy_title' => 'Ms.',
            'full_name' => 'Jane Smith',
            'age' => 28,
            'phone_number' => '0987654321',
            ],
            [
            'courtesy_title' => 'Mrs.',
            'full_name' => 'Emily Johnson',
            'age' => 35,
            'phone_number' => '1112223333',
            ],
            [
            'courtesy_title' => 'Mr.',
            'full_name' => 'Michael Brown',
            'age' => 40,
            'phone_number' => '2223334444',
            ],
            [
            'courtesy_title' => 'Ms.',
            'full_name' => 'Linda Davis',
            'age' => 27,
            'phone_number' => '3334445555',
            ],
            [
            'courtesy_title' => 'Dr.',
            'full_name' => 'Robert Wilson',
            'age' => 50,
            'phone_number' => '4445556666',
            ],
            [
            'courtesy_title' => 'Miss',
            'full_name' => 'Sophia Martinez',
            'age' => 22,
            'phone_number' => '5556667777',
            ],
        ];

        $customerModels = [];
        foreach ($customers as $customerData) {
            $customerModels[] = Customer::create($customerData);
        }

        // Create ServiceTickets for each customer
        foreach ($customerModels as $index => $customer) {
            ServiceTicket::create([
            'customer_id' => $customer->id,
            'room_id' => $room->id,
            'service_id' => $service->id,
            'details' => 'Request for room cleaning at ' . (15 + $index) . ':00 PM',
            ]);
        }
    }
}
