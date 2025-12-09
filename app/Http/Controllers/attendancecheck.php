<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\photoattendance;
use App\Models\attendancecheckin;

class attendancecheck extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Request $request)
{
    $date = $request->date ?? now()->format('Y-m-d');

    $employees = photoattendance::all();

    $attendanceData = [];

    foreach ($employees as $emp) {

        $attendance = attendancecheckin::where('emp_id', $emp->id)
            ->whereDate('created_at', $date)
            ->first();

        $status = "Absent";

        $checkin_time = $attendance->checkin_time ?? "--";
        $checkout_time = $attendance->checkout_time ?? "--";

        $checkin_photo = $attendance->checkin_photo ?? null;
        $checkout_photo = $attendance->checkout_photo ?? null;

        if ($attendance) {
            if ($attendance->checkin_time && $attendance->checkout_time) {
                $status = "Present";
            }
        }

        $attendanceData[] = [
            'emp_id'         => $emp->id,
            'emp_name'       => $emp->name,
            'checkin_time'   => $checkin_time,
            'checkout_time'  => $checkout_time,
            'checkin_photo'  => $checkin_photo,
            'checkout_photo' => $checkout_photo,
            'status'         => $status,
        ];
    }

    return view('photoattendancee.checkin_detail', compact('attendanceData', 'date'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */public function store(Request $request)
{
    $request->validate([
        'emp_id'        => 'required|numeric',
        'emp_name'      => 'required|string',
        'checkin_photo' => 'nullable',
        'checkout_photo'=> 'nullable',
        'checkin_time'  => 'nullable',
        'checkout_time' => 'nullable',
    ]);

    $today = now()->format('Y-m-d');

    // Check if there is already a record for today
    $attendance = attendancecheckin::where('emp_id', $request->emp_id)
        ->whereDate('created_at', $today)
        ->first();

    /* ============================================================
        CASE 1: CHECK-IN
    ============================================================ */
    if (!empty($request->checkin_photo)) {

        // ❌ If already checked in today → stop
        if ($attendance && $attendance->checkin_time !== null) {
            return back()->with('error', 'You have already checked in today.');
        }

        // Create record if not exists
        if (!$attendance) {
            $attendance = new attendancecheckin();
            $attendance->emp_id = $request->emp_id;
            $attendance->emp_name = $request->emp_name;
        }

        // SAVE CHECK-IN PHOTO
        $directory = public_path('uploads/attendance');
        if (!file_exists($directory)) mkdir($directory, 0777, true);

        $imageData = str_replace('data:image/png;base64,', '', $request->checkin_photo);
        $imageData = base64_decode($imageData);
        $filename  = time() . '_checkin.png';

        file_put_contents($directory . '/' . $filename, $imageData);

        $attendance->checkin_photo = $filename;
        $attendance->checkin_time = $request->checkin_time;
        $attendance->save();

        return back()->with('success', 'Check-in completed successfully.');
    }

    /* ============================================================
        CASE 2: CHECK-OUT
    ============================================================ */
    if (!empty($request->checkout_photo)) {

        // ❌ No check-in found → reject checkout
        if (!$attendance || $attendance->checkin_time === null) {
            return back()->with('error', 'You cannot check out before checking in.');
        }

        // ❌ If already checked out → stop
        if ($attendance->checkout_time !== null) {
            return back()->with('error', 'You have already checked out today.');
        }

        // SAVE CHECK-OUT PHOTO
        $directory = public_path('uploads/attendance');
        if (!file_exists($directory)) mkdir($directory, 0777, true);

        $imageData = str_replace('data:image/png;base64,', '', $request->checkout_photo);
        $imageData = base64_decode($imageData);
        $filename  = time() . '_checkout.png';

        file_put_contents($directory . '/' . $filename, $imageData);

        $attendance->checkout_photo = $filename;
        $attendance->checkout_time = $request->checkout_time;
        $attendance->save();

        return back()->with('success', 'Checkout completed successfully.');
    }

    return back()->with('error', 'Something went wrong.');
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
}
