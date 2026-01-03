<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\photoattendance;

use App\Models\attendancecheckin;
use Illuminate\Support\Facades\Storage;

class attendancecheck extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    // ✅ Validate
    $request->validate([
        'from_date' => 'nullable|date',
        'to_date'   => 'nullable|date|after_or_equal:from_date',
        'month'     => 'nullable|date_format:Y-m',
    ]);

    // =========================
    // DATE LOGIC (FIXED)
    // =========================
  if ($request->filled('from_date') || $request->filled('to_date')) {

    // 📆 DATE FILTER
    $fromDate = $request->from_date ?? now()->format('Y-m-d');
    $toDate   = $request->to_date   ?? now()->format('Y-m-d');

} elseif (!empty($request->month)) {

    // 📅 MONTH FILTER
    $fromDate = Carbon::parse($request->month)->startOfMonth()->format('Y-m-d');
    $toDate   = Carbon::parse($request->month)->endOfMonth()->format('Y-m-d');

} else {

    // 🕒 DEFAULT TODAY
    $fromDate = now()->format('Y-m-d');
    $toDate   = now()->format('Y-m-d');
}

    $employees = photoattendance::all();
    $period    = CarbonPeriod::create($fromDate, $toDate);

    $attendanceData = [];

    foreach ($employees as $emp) {
        foreach ($period as $date) {

            $attendance = attendancecheckin::where('emp_id', $emp->id)
                ->whereDate('date', $date->format('Y-m-d'))
                ->first();

            $status      = "Absent";
            $lateMessage = "";

            $checkin_time  = $attendance?->checkin_time ?? "--";
            $checkout_time = $attendance?->checkout_time ?? "--";

            $checkin_photo  = $attendance?->checkin_photo;
            $checkout_photo = $attendance?->checkout_photo;

            if ($attendance) {

                if ($attendance->checkin_time && !$attendance->checkout_time) {
                    $status = "Half Day";
                }

                if ($attendance->checkin_time && $attendance->checkout_time) {
                    $status = "Present";
                }

                $bufferTime = $emp->Buffer_time
                    ? $emp->Buffer_time . ":00"
                    : "09:30:00";

                if ($attendance->checkin_time) {

                    $checkinOnly = date("H:i:s", strtotime($attendance->checkin_time));

                    if ($checkinOnly > $bufferTime && $status !== "Absent") {

                        $status = "Late";

                        $lateSeconds = strtotime($checkinOnly) - strtotime($bufferTime);

                        $hours   = floor($lateSeconds / 3600);
                        $minutes = floor(($lateSeconds % 3600) / 60);

                        $lateMessage = $hours > 0
                            ? "Late by {$hours} hr {$minutes} min"
                            : "Late by {$minutes} min";
                    }
                }
            }

            $attendanceData[] = [
                'date'           => $date->format('Y-m-d'),
                'emp_id'         => $emp->id,
                'af5'            => $emp->af5,
                'af6'            => $emp->af6,
                'emp_name'       => $emp->name,
                'checkin_time'   => $checkin_time,
                'checkout_time'  => $checkout_time,
                'checkin_photo'  => $checkin_photo,
                'checkout_photo' => $checkout_photo,
                'status'         => $status,
                'late_message'   => $lateMessage,
                'Remark'         => $attendance?->Remark,
            ];
        }
    }

    return view('photoattendancee.checkin_detail', compact(
        'attendanceData',
        'fromDate',
        'toDate'
    ));
}


    /**
     * Show the form for creating a new resource.
     */
public function store(Request $request)
{
    $request->validate([
        'emp_id'        => 'required|numeric',
        'emp_name'      => 'required|string',
        'checkin_photo' => 'nullable',
        'checkout_photo'=> 'nullable',
        'checkin_time'  => 'nullable',
        'checkout_time' => 'nullable',
    ]);

    $today = date('Y-m-d');

    // Check existing attendance
    $attendance = attendancecheckin::where('emp_id', $request->emp_id)
        ->where('date', $today)
        ->first();

    /* --------------------------
       CASE 1: CHECK-IN
    -------------------------- */
    if (!empty($request->checkin_photo)) {

        if ($attendance && $attendance->checkin_time !== null) {
            return back()->with('error', 'You have already checked in today.');
        }

        if (!$attendance) {
            $attendance = new attendancecheckin();
            $attendance->emp_id = $request->emp_id;
            $attendance->emp_name = $request->emp_name;
            $attendance->date = $today; // ← SAVE TODAY DATE
        }

        // Create folder
       // SAVE CHECK-IN IMAGE (storage)
$data = base64_decode(
    preg_replace('#^data:image/\w+;base64,#i', '', $request->checkin_photo)
);

$filename = time().'_checkin.png';

Storage::put(
    'public/account_image/'.$filename,
    $data
);
$attendance->checkin_photo = $filename;

        $attendance->checkin_time = $request->checkin_time;

        // Ensure date saved (if not already)
        $attendance->date = $today;

        $attendance->save();

        return back()->with('success', 'Check-in completed successfully.');
    }

    /* --------------------------
       CASE 2: CHECK-OUT
    -------------------------- */
    if (!empty($request->checkout_photo)) {

        if (!$attendance) {
            return back()->with('error', 'You cannot check out before checking in.');
        }

        if ($attendance->checkout_time !== null) {
            return back()->with('error', 'You have already checked out today.');
        }

        // Create folder
       // SAVE CHECK-OUT IMAGE (storage)
$data = base64_decode(
    preg_replace('#^data:image/\w+;base64,#i', '', $request->checkout_photo)
);

$filename = time().'_checkout.png';

Storage::put(
    'public/account_image/'.$filename,
    $data
);

$attendance->checkout_photo = $filename;

        $attendance->checkout_time = $request->checkout_time;

        // Ensure today's date is saved
        $attendance->date = $today;

        $attendance->save();

        return back()->with('success', 'Checkout completed successfully.');
    }

    return back()->with('error', 'Something went wrong.');
}



    public function create()
    {
        //
    }

    /**
* Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function updateStatus(Request $request)
{
    $request->validate([
        'emp_id' => 'required',
        'date'   => 'required',
        'status' => 'required',
        'Remark' => 'nullable|string'
    ]);

    $attendance = attendancecheckin::where('emp_id', $request->emp_id)
        ->whereDate('date', $request->date)
        ->first();

    if (!$attendance) {
        $emp = photoattendance::find($request->emp_id);

        $attendance = new attendancecheckin();
        $attendance->emp_id   = $request->emp_id;
        $attendance->emp_name = $emp->name ?? '';
        $attendance->date     = $request->date;
    }

    // RESET
    $attendance->checkin_time  = null;
    $attendance->checkout_time = null;

    $checkinDateTime  = $request->date . ' ';
    $checkoutDateTime = $request->date . ' ';

    if ($request->status == 'Present') {
        $attendance->checkin_time  = $checkinDateTime . '09:00:00';
        $attendance->checkout_time = $checkoutDateTime . '18:00:00';
    }

    if ($request->status == 'Half Day') {
        $attendance->checkin_time = $checkinDateTime . '09:00:00';
    }

    if ($request->status == 'Late') {
        $attendance->checkin_time  = $checkinDateTime . '10:30:00';
        $attendance->checkout_time = $checkoutDateTime . '18:00:00';
    }

    // ✅ SAVE Remark
    $attendance->Remark = $request->Remark;

    $attendance->save();

    return back()->with('success', 'Attendance updated successfully');
}

}
