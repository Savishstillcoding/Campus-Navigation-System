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
            // Floor 2
            [
                'room_name' => 'Computer Lab 1',
                'room_number' => '201',
                'floor' => 2,
                'qr_code' => 'QR_COMLAB_201',
                'description' => 'Computer Laboratory 1',
                'building' => 'IT Building',
                'location' => 'Floor 2 - Left wing, 1st door from entrance',
            ],
            [
                'room_name' => 'Computer Lab 2',
                'room_number' => '202',
                'floor' => 2,
                'qr_code' => 'QR_COMLAB_202',
                'description' => 'Computer Laboratory 2',
                'building' => 'IT Building',
                'location' => 'Floor 2 - Left wing, 2nd door from entrance',
            ],
            [
                'room_name' => 'Computer Lab 3',
                'room_number' => '203',
                'floor' => 2,
                'qr_code' => 'QR_COMLAB_203',
                'description' => 'Computer Laboratory 3',
                'building' => 'IT Building',
                'location' => 'Floor 2 - Left wing, 3rd door from entrance',
            ],
            // Third Floor
            [
                'room_name' => 'Computer Lab 4',
                'room_number' => '301',
                'floor' => 3,
                'qr_code' => 'QR_COMLAB_301',
                'description' => 'Computer Laboratory 4',
                'building' => 'IT Building',
                'location' => 'Floor 3 - Left wing, 1st door from entrance',
            ],
            [
                'room_name' => 'CHS Room',
                'room_number' => '302',
                'floor' => 3,
                'qr_code' => 'QR_CHS_302',
                'description' => 'College of Health Sciences Room',
                'building' => 'IT Building',
                'location' => 'Floor 3 - Left wing, 2nd door from entrance',
            ],
            [
                'room_name' => 'CISCO Lab',
                'room_number' => '303',
                'floor' => 3,
                'qr_code' => 'QR_CISCO_303',
                'description' => 'CISCO Networking Laboratory',
                'building' => 'IT Building',
                'location' => 'Floor 3 - Left wing, 3rd door from entrance',
            ],
            [
                'room_name' => 'Faculty Room',
                'room_number' => '304',
                'floor' => 3,
                'qr_code' => 'QR_FACULTY_304',
                'description' => 'IT Faculty Room',
                'building' => 'IT Building',
                'location' => 'Floor 3 - Right wing, 1st door from stairs',
            ],
            [
                'room_name' => 'Dean\'s Office',
                'room_number' => '305',
                'floor' => 3,
                'qr_code' => 'QR_DEAN_305',
                'description' => 'Dean\'s office',
                'building' => 'IT Building',
                'location' => 'Floor 3 - Right wing, 2nd door from stairs',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
