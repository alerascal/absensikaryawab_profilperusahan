<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ubah sesuai kebutuhan (role/permission)
    }

    public function rules(): array
    {
        return [
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i'],
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $start = $this->input('start_time');
            $end   = $this->input('end_time');

            if ($start && $end) {
                $startTime = Carbon::createFromFormat('H:i', $start);
                $endTime   = Carbon::createFromFormat('H:i', $end);

                // Kalau end_time <= start_time, anggap shift malam → tambah 1 hari
                if ($endTime->lessThanOrEqualTo($startTime)) {
                    $endTime->addDay();
                }

                // Jika sama persis, error
                if ($startTime->equalTo($endTime)) {
                    $validator->errors()->add('end_time', 'Waktu selesai tidak boleh sama dengan waktu mulai.');
                }
            }
        });
    }
}
