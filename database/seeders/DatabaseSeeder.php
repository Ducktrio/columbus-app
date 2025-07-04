<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\RoomType;
use App\Models\Service;
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

        Service::create([
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

        RoomType::create([
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
    }
}
