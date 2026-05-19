<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            // First Floor
            [
                'room_name' => 'Computer Lab 1',
                'room_number' => '101',
                'floor' => 1,
                'qr_code' => 'QR_COMLAB_101',
                'description' => 'Computer laboratory for programming courses',
                'building' => 'IT Building',
            ],
            [
                'room_name' => 'Computer Lab 2',
                'room_number' => '102',
                'floor' => 1,
                'qr_code' => 'QR_COMLAB_102',
                'description' => 'Computer laboratory for web development',
                'building' => 'IT Building',
            ],
            [
                'room_name' => 'Computer Lab 3',
                'room_number' => '103',
                'floor' => 1,
                'qr_code' => 'QR_COMLAB_103',
                'description' => 'Computer laboratory for database courses',
                'building' => 'IT Building',
            ],
            // Second Floor
            [
                'room_name' => 'Chemistry Lab',
                'room_number' => '201',
                'floor' => 2,
                'qr_code' => 'QR_CHEM_201',
                'description' => 'Chemistry laboratory',
                'building' => 'IT Building',
            ],
            [
                'room_name' => 'Physics Lab',
                'room_number' => '202',
                'floor' => 2,
                'qr_code' => 'QR_PHYS_202',
                'description' => 'Physics laboratory',
                'building' => 'IT Building',
            ],
            // Third Floor
            [
                'room_name' => 'Faculty Room',
                'room_number' => '301',
                'floor' => 3,
                'qr_code' => 'QR_FACULTY_301',
                'description' => 'Faculty office and meeting room',
                'building' => 'IT Building',
            ],
            [
                'room_name' => 'Dean\'s Office',
                'room_number' => '302',
                'floor' => 3,
                'qr_code' => 'QR_DEAN_302',
                'description' => 'Dean\'s office',
                'building' => 'IT Building',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
