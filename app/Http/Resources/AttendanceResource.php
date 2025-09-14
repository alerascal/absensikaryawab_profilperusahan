<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AttendanceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama' => $this->user->name ?? 'N/A',
            'departemen' => $this->user->department->name ?? 'N/A',
            'check_in' => $this->check_in ?? '-',
            'check_out' => $this->check_out ?? '-',
            'status' => $this->status,
            'location' => $this->location ?? '-',
            'date' => $this->date->toDateString(),
            'photo_path' => $this->photo_path ? Storage::temporaryUrl($this->photo_path, now()->addMinutes(10)) : null,
        ];
    }
}