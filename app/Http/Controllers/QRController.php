<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QRController extends Controller
{
    /**
     * Scan QR code and return room information
     * Also logs the activity with real-time date and time
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

        // Log the QR code scan activity with real-time date and time
        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'room_id' => $room->id,
                'activity_type' => 'QR_SCAN',
                'activity_description' => "Scanned QR code for {$room->room_name}",
                'scan_time' => Carbon::now(),
                'status' => 'COMPLETED',
            ]);
        } catch (\Exception $e) {
            // Log silently to avoid disrupting the main flow
            \Log::error('Failed to log activity: ' . $e->getMessage());
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

    /**
     * Get activity logs for the authenticated user
     * Returns logs sorted by scan time in descending order
     */
    public function getActivityLogs()
    {
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated.',
                'data' => [],
            ], 401);
        }

        $activityLogs = ActivityLog::where('user_id', $userId)
            ->with('room')
            ->orderBy('scan_time', 'desc')
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'activity_description' => $log->activity_description,
                    'scan_time' => $log->scan_time,
                    'status' => $log->status,
                    'room_name' => $log->room ? $log->room->room_name : 'Unknown Room',
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Activity logs retrieved successfully.',
            'data' => $activityLogs,
        ], 200);
    }
}
