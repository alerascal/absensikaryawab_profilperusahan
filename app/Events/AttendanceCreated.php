<?php

namespace App\Events;

use App\Models\Attendance;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttendanceCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $attendance;

    /**
     * Create a new event instance.
     *
     * @param Attendance $attendance
     */
    public function __construct(Attendance $attendance)
    {
        $this->attendance = $attendance;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('attendance');
    }
}