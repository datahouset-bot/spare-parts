<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends CustomBaseController
{
    public function index(Request $request)
    { 
        // Default date today agar koi select na kare
        $date = $request->get('date', Carbon::today()->toDateString());

        // Logged in user ke firm ke sabhi users
        $users = User::where('firm_id', Auth::user()->firm_id)
                     ->orderBy('name')
                     ->get();

        // Us date ki attendance agar pehle se saved hai, to fetch karo
        $existing = Attendance::where('attendance_date', $date)
            ->where('firm_id', Auth::user()->firm_id)
            ->get()
            ->keyBy('user_id');

        return view('attendance.index', compact('users', 'existing', 'date'));
    }

  public function store(Request $request)
{
    $request->validate([
        'attendance_date' => 'required|date',
        'user_id' => 'required|array',
    ]);

    $date = $request->attendance_date;
    $firm_id = Auth::user()->firm_id;

    foreach ($request->user_id as $i => $user_id) {
        Attendance::updateOrCreate(
            [
                'user_id' => $user_id,
                'attendance_date' => $date,
                'firm_id' => $firm_id,
            ],
            [
                'status' => $request->status[$i] ?? 'P',
                'in_time' => $request->in_time[$i] ?? null,
                'out_time' => $request->out_time[$i] ?? null,
                'attend_af1' => $request->attend_af1[$i] ?? null, // ✅ yahan fix
            ]
        );
    }

    return redirect()
        ->route('attendance.index', ['date' => $date])
        ->with('success', 'Attendance saved or updated successfully.');
}
public function report()
{
    $users = User::where('firm_id', auth()->user()->firm_id)->orderBy('name')->get();
    return view('attendance.report', compact('users'));
}
public function reportShow(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'official_in' => 'required',
        'official_out' => 'required',
    ]);

    $official_in=$request->official_in;
    $official_out=$request->official_out;
    $user = User::findOrFail($request->user_id);
    $attendances = Attendance::where('user_id', $user->id)
    ->whereBetween('attendance_date', [$request->start_date, $request->end_date])
    ->orderBy('attendance_date')
    ->get()
    ->keyBy(function($item){ 
        return Carbon::parse($item->attendance_date)->format('Y-m-d'); 
    });

    // helper to parse time strings robustly
    $parseTime = function(?string $timeStr) {
        if (!$timeStr) return null;
        try {
            // Carbon::parse handles H:i, H:i:s, h:i A etc.
            return Carbon::parse($timeStr);
        } catch (\Exception $e) {
            // fallback: try common formats
            $formats = ['H:i:s','H:i','g:i A','g:iA','H.i'];
            foreach ($formats as $fmt) {
                try {
                    return Carbon::createFromFormat($fmt, $timeStr);
                } catch (\Exception $e2) {
                    // continue
                }
            }
        }
        return null;
    };

    // parse official times once
    $officialIn = $parseTime($request->official_in);
    $officialOut = $parseTime($request->official_out);

    $period = new \DatePeriod(
        new \DateTime($request->start_date),
        new \DateInterval('P1D'),
        (new \DateTime($request->end_date))->modify('+1 day')
    );

    $report = [];
    $total_present = $total_absent = $total_half = $total_sunday = 0;
    $total_late_minutes = 0;

    foreach ($period as $date) {
        $d = $date->format('Y-m-d');
        $dayName = $date->format('l');
        $data = $attendances[$d] ?? null;

        // default status if no record
        $status = $data->status ?? 'A';
        $remark = $data->attend_af1 ?? null;

        // If Sunday, mark as 'S' (you asked that Sunday be marked specially)
        if ($dayName === 'Sunday') {
            $status = 'S';
        }

        // Late calculation (only when present and actual in_time exists)
        $lateMins = 0;
        if ($status === 'P' && $data && $data->in_time) {
            $actualIn = $parseTime($data->in_time);
            if ($officialIn && $actualIn && $actualIn->greaterThan($officialIn)) {
                $lateMins = $officialIn->diffInMinutes($actualIn);
                $total_late_minutes += $lateMins;
            }
        }

        // Tally counts
        if ($status === 'P') $total_present++;
        elseif ($status === 'A') $total_absent++;
        elseif ($status === 'H') $total_half++;
        elseif ($status === 'S') $total_sunday++;

        $report[] = [
            'date' => $d,
            'day' => $dayName,
            'status' => $status,
            'remark' => $remark,
            'late' => $lateMins,
            'in_time' => $data->in_time ?? null,
            'out_time' => $data->out_time ?? null,
        ];
    }

    return view('attendance.report_show', compact(
        'user',
        'report',
        'total_present',
        'total_absent',
        'total_half',
        'total_sunday',
        'total_late_minutes',
        'request',
        'official_in',
        'official_out'

    ));
}


}
