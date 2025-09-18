<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\attendance;
use App\Models\attendanceHistory;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date'); // format: Y-m-d
        $departmentId = $request->query('department_id');

        $query = attendance::with(['employee.department']);

        // filter tanggal (clock_in atau clock_out sesuai kebutuhan)
        if ($date) {
            $query->whereDate('clock_in', $date);
        }

        // filter department
        if ($departmentId) {
            $query->whereHas('employee', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $attendances = $query->get();

        // map hasil + hitung status
        $result = $attendances->map(function ($att) {
            $department = $att->employee->department;
            $maxIn  = $department->max_clock_in_time;
            $maxOut = $department->max_clock_out_time;

            // status clock in
            $statusIn = $att->clock_in > $maxIn ? 'Terlambat' : 'Tepat Waktu';

            // status clock out
            if (!$att->clock_out) {
                $statusOut = 'Belum Absen Keluar';
            } elseif ($att->clock_out < $maxOut) {
                $statusOut = 'Pulang Cepat';
            } elseif ($att->clock_out == $maxOut) {
                $statusOut = 'Tepat Waktu';
            } else {
                $statusOut = 'Lembur';
            }

            return [
                'employee'       => $att->employee->name,
                'employee_id'    => $att->employee->employee_id,
                'department'     => $department->department_name,
                'date'           => $att->clock_in ? $att->clock_in->format('Y-m-d') : null,
                'clock_in'       => $att->clock_in ? $att->clock_in->format('H:i:s') : null,
                'status_in'      => $statusIn,
                'clock_out'      => $att->clock_out ? $att->clock_out->format('H:i:s') : null,
                'status_out'     => $statusOut,
            ];
        });

        return response()->json([
            'message' => 'List log absensi',
            'filters' => [
                'date' => $date,
                'department_id' => $departmentId,
            ],
            'data' => $result
        ]);
    }

    public function clockIn(Request $request)
    {
        // $testingCarbon = Carbon::parse('2025-09-18 07:00:00'); // testing "sesuaikan tanggal sekarang dan modif jam"
        // $testingCarbonNow = Carbon::parse('2025-09-18 06:00:00'); // testing "sesuaikan tanggal sekarang dan modif jam"
        // Ambil employee dari user yang login
        $employee = Employee::with('department')
            ->where('email', $request->user()->email)
            ->firstOrFail();

        $employeeId = $employee->employee_id; // gunakan PK integer

        // Ambil waktu sekarang & batas clock-in
        $nowTime = Carbon::now()->format('H:i:s');
        // $nowTime = $testingCarbonNow; // testing
        $maxClockIn = $employee->department->max_clock_in_time ?? '09:00:00'; // fallback biar gak null

        // Tentukan status
        $status = ($nowTime > $maxClockIn) ? 'Terlambat' : 'Tepat Waktu';

        // Cek apakah sudah absen masuk hari ini
        $alreadyClockIn = attendance::where('employee_id', $employeeId)
            ->whereDate('clock_in', now()->toDateString())
            ->exists();

        if ($alreadyClockIn) {
            return response()->json([
                'message' => 'Anda sudah absen masuk hari ini!'
            ], 400);
        }

        // Generate attendance_id unik
        $attendanceId = 'ATT' . now()->format('YmdHis') . '-' . $employee->employee_id;

        // Simpan ke tabel attendance
        $attendance = attendance::create([
            'employee_id'   => $employeeId,
            'attendance_id' => $attendanceId,
            'clock_in'      => now(),
            // 'clock_in'      => $testingCarbon, //untuk testing
        ]);

        // Simpan ke tabel attendance_history
        attendanceHistory::create([
            'employee_id'      => $employeeId,
            'attendance_id'    => $attendance->attendance_id,
            'date_attendance'  => now(),
            // 'date_attendance'  => $testingCarbon, // untuk testing
            'attendance_type'  => 1, // 1 = In
            'description'      => $status,
        ]);

        return response()->json([
            'message'  => 'Clock In berhasil',
            'status'   => $status,
            'data'     => $attendance
        ], 201);
    }

    public function clockOut(Request $request)
    {
        // $testingCarbon = Carbon::parse('2025-09-18 19:00:00'); // testing "sesuaikan tanggal sekarang"
        // $testingCarbonNow = Carbon::parse('2025-09-18 19:00:00'); // testing

        // Ambil employee login
        $employee = Employee::with('department')
            ->where('email', $request->user()->email)
            ->firstOrFail();

        // Ambil history clock-in terbaru
        $attendanceHistory = attendanceHistory::where('employee_id', $employee->employee_id)
            ->where('attendance_type', 1)
            ->latest('date_attendance')
            ->first();

        if (!$attendanceHistory) {
            return response()->json(['message' => 'Belum absen masuk, tidak bisa clock out'], 400);
        }

        $attendanceId = $attendanceHistory->attendance_id;

        // Cari attendance berdasarkan employee + attendanceId
        $attendance = attendance::where('attendance_id', $attendanceId)
            ->where('employee_id', $employee->employee_id)
            ->firstOrFail();

        if ($attendance->clock_out) {
            return response()->json(['message' => 'Sudah absen keluar sebelumnya'], 400);
        }

        // Tentukan status
        $nowTime = Carbon::now()->format('H:i:s');
        // $nowTime = $testingCarbonNow; // untuk testing
        $maxClockOut = $attendance->employee->department->max_clock_out_time;

        if ($nowTime < '12:00:00') {
            $status = 'Dispen';
        } elseif ($nowTime < $maxClockOut) {
            $status = 'Pulang Cepat';
        } elseif ($nowTime == $maxClockOut) {
            $status = 'Tepat Waktu';
        } else {
            $status = 'Lembur';
        }

        // Update attendance
        $attendance->update([
            'clock_out' => now(),
            // 'clock_out' => $testingCarbon, // testing
        ]);

        // Simpan history
        attendanceHistory::create([
            'employee_id'     => $employee->employee_id,
            'attendance_id'   => $attendanceId,
            'date_attendance' => now(),
            // 'date_attendance' => $testingCarbon,
            'attendance_type' => 2, // 2 = Out
            'description'     => $status,
        ]);

        return response()->json([
            'message' => 'Clock Out berhasil',
            'status'  => $status,
            'data'    => $attendance
        ]);
    }
}
