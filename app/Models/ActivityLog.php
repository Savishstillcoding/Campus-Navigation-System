<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'activity_type',
        'activity_description',
        'scan_time',
        'status',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user associated with the activity log
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the room associated with the activity log
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
