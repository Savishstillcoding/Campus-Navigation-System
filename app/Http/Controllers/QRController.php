<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class QRController extends Controller
{
    /**
     * Scan QR code and return room information
     */
    public function scan(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $room = Room::where('qr_code', $request->qr_code)->first();

        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'QR code not found or invalid.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Room found!',
            'data' => [
                'id' => $room->id,
                'room_name' => $room->room_name,
                'room_number' => $room->room_number,
                'floor' => $room->floor,
                'building' => $room->building,
                'description' => $room->description,
                'qr_code' => $room->qr_code,
            ],
        ], 200);
    }

    /**
     * Get all rooms
     */
    public function getAllRooms()
    {
        $rooms = Room::all();

        return response()->json([
            'success' => true,
            'message' => 'Rooms retrieved successfully.',
            'data' => $rooms,
        ], 200);
    }

    /**
     * Get rooms by floor
     */
    public function getRoomsByFloor($floor)
    {
        $rooms = Room::where('floor', $floor)->get();

        if ($rooms->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No rooms found on this floor.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Rooms retrieved successfully.',
            'data' => $rooms,
        ], 200);
    }

    /**
     * Show a specific room with QR code details
     */
    public function show($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return redirect()->route('student-home')->with('error', 'Room not found.');
        }

        return view('room-details', ['room' => $room]);
    }
}
