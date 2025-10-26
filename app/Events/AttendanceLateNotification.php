<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AttendanceLateNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $lateMinutes;

    public function __construct(User $user, $lateMinutes)
    {
        $this->user = $user;
        $this->lateMinutes = $lateMinutes;
    }
}