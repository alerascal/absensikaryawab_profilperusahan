<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromQuery, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Attendance::with(['user', 'user.department']);
        if (isset($this->filters['department'])) {
            $query->whereHas('user.department', fn($q) => $q->where('name', $this->filters['department']));
        }
        if (isset($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (isset($this->filters['date'])) {
            $query->whereDate('date', $this->filters['date']);
        }
        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Departemen',
            'Check In',
            'Check Out',
            'Status',
            'Lokasi',
            'Tanggal',
        ];
    }
}