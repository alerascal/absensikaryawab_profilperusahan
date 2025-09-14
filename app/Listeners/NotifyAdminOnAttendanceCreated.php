<?php

namespace App\Listeners;

use App\Events\AttendanceCreated;
use Illuminate\Support\Facades\Mail;
use App\Mail\AttendanceNotification;

class NotifyAdminOnAttendanceCreated
{
    public function handle(AttendanceCreated $event)
    {
        // Kirim email ke admin (contoh)
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new AttendanceNotification($event->attendance));
        }
    }
}