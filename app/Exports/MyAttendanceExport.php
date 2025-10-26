<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MyAttendanceExport implements FromView
{
    protected $attendances;

    public function __construct($attendances)
    {
        $this->attendances = $attendances;
    }

    public function view(): View
    {
        return view('pegawai.attendance.excel', [
            'attendances' => $this->attendances
        ]);
    }
}
