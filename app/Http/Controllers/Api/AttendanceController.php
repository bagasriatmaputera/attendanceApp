<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\attendance;
use App\Models\attendanceHistory;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function clockIn(Request $request)
    {

        $employee_id = $request->user()->employee_id;
        $request->validate([
            'employee_id' => 'required|exists:employees,employee_id',
        ]);

        // Buat ID absensi unik
        $attendanceId = 'ATT' . now()->format('YmdHis') . '-' . $request->employee_id;

        $attendance = attendance::create([
            'employee_id'   => $employee_id,
            'attendance_id' => $attendanceId,
            'clock_in'      => now(),
        ]);

        // Simpan ke history
        attendanceHistory::create([
            'employee_id'      => $request->employee_id,
            'attendance_id'    => $attendance->attendance_id,
            'date_attendance'  => now(),
            'attendance_type'  => 1, // 1 = In
            'description'      => 'Clock In',
        ]);

        return response()->json([
            'message' => 'Clock In berhasil',
            'data'    => $attendance
        ]);
    }

    public function clockOut(Request $request, $attendanceId)
    {
        $employee_id = $request->user()->employee_id;

        $attendance = attendance::where('attendance_id', $attendanceId)->firstOrFail();

        if ($attendance->clock_out) {
            return response()->json(['message' => 'Sudah absen keluar'], 400);
        }

        $attendance->update([
            'clock_out' => now(),
        ]);

        attendanceHistory::create([
            'employee_id'      => $employee_id,
            'attendance_id'    => $attendance->attendance_id,
            'date_attendance'  => now(),
            'attendance_type'  => 2, // 2 = Out
            'description'      => 'Clock Out',
        ]);

        return response()->json([
            'message' => 'Clock Out berhasil',
            'data'    => $attendance
        ]);
    }
}
