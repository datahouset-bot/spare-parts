<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\photoattendance;
use App\Models\attendancesalary;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class photoattendancecontroller extends Controller
{
    public function index()
    {
        return view('photoattendancee.attendance_index');
    }

    public function create()
    {
      $employees = photoattendance::with(['latestAdvance'])->latest()->get();
        return view('photoattendancee.attendance_view', compact('employees'));
    }

    public function showform()
    {
        $employees = photoattendance::select('id', 'name')->get();
        return view('photoattendancee.checkinindex', compact('employees'));
    }


    //============ SHOW EMPLOYEE ATTENDANCE/salary/and all DETAILS===========================
public function show($id)
{
    $employee = photoattendance::findOrFail($id);

    /* ===============================
       MONTH / YEAR
    =============================== */
    $selectedMonth = request('month', now()->month);
    $selectedYear  = now()->year;

    /* ===============================
       ADVANCE SALARY
    =============================== */
    $advances = DB::table('attendancesalary')
        ->where('emp_id', $id)
        ->whereMonth('date', $selectedMonth)
        ->whereYear('date', $selectedYear)
        ->orderBy('date', 'DESC')
        ->get();

    $totalAdvance = $advances->sum('advance_salary');

    /* ===============================
       RAW ATTENDANCE (FORMAT DATE)
    =============================== */
   $rawAttendance = DB::table('attendancecheckins')
    ->where('emp_id', $id)
    ->whereMonth('created_at', $selectedMonth)
    ->whereYear('created_at', $selectedYear)
    ->get()
    ->mapWithKeys(function ($item) {
        $date = Carbon::parse($item->created_at)->format('Y-m-d');
        $item->date = $date; // ensure property exists
        return [$date => $item];
    });

    /* ===============================
       BUFFER TIME
    =============================== */
    $bufferTime = $employee->Buffer_time
        ? $employee->Buffer_time . ':00'
        : '09:30:00';

    /* ===============================
       FULL MONTH LOOP
    =============================== */
    $start = Carbon::create($selectedYear, $selectedMonth, 1);
    $end   = $start->copy()->endOfMonth();

    $attendance = collect();
foreach (CarbonPeriod::create($start, $end) as $date) {

    $dateStr = $date->format('Y-m-d');

    if ($rawAttendance->has($dateStr)) {

        $day = $rawAttendance[$dateStr];

        // ✅ ENSURE DATE PROPERTY EXISTS
        $day->date = $dateStr;

        if (!$day->checkin_time) {
            $day->status = 'absent';
            $day->late_message = 'absent';
        } else {

            $checkinTime = date("H:i:s", strtotime($day->checkin_time));

         if ($checkinTime > $bufferTime) {

    $day->status = 'late';

    $lateSeconds = strtotime($checkinTime) - strtotime($bufferTime);

    $hours   = floor($lateSeconds / 3600);
    $minutes = floor(($lateSeconds % 3600) / 60);

    if ($hours > 0) {
        $day->late_message = "Late by {$hours} hr {$minutes} min";
    } else {
        $day->late_message = "Late by {$minutes} min";
    }

} else {
    $day->status = 'present';
    $day->late_message = null;
}

        }

        $attendance->push($day);

    } else {

        // ABSENT DAY
        $attendance->push((object)[
            'date' => $dateStr,
            'status' => 'absent',
            'late_message' => 'absent'
        ]);
    }
}


    /* ===============================
       COUNTS
    =============================== */
    $presentDays = $attendance->whereIn('status', ['present', 'late'])->count();
    $absentDays  = $attendance->where('status', 'absent')->count();
    $totalDays   = $attendance->count();

    return view('photoattendancee.attendance_show', compact(
        'employee',
        'advances',
        'totalAdvance',
        'attendance',
        'presentDays',
        'absentDays',
        'totalDays',
        'selectedMonth'
    ));
}


    // =====================================================================================

    public function getEmployeeName($id)
    {
        $employee = photoattendance::find($id);
        return response()->json([
            'name' => $employee ? $employee->name : null
        ]);
    }
    public function store(Request $request)
{
    $validate = Validator::make($request->all(), [
        'emp_id'          => 'nullable|string',
        'name'            => 'required|string|max:255',
        'email'           => 'nullable|email',
        'mobile'          => 'nullable|string|max:15',
        'address'         => 'nullable|string',
        'document_no'     => 'nullable|string|max:100',

        'Report_time'     => 'nullable',
        'Buffer_time'     => 'nullable', // ✅ FIXED (not numeric)

        'salary_amount'   => 'nullable|numeric',
        'date_of_joining' => 'nullable|date',
        'document_type'   => 'nullable|string',

        'terms_text'      => 'nullable|string',
        'terms'           => 'required',

        'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'document_file'   => 'nullable|mimes:jpg,jpeg,png,pdf|max:4096',
    ]);

    if ($validate->fails()) {
        return redirect()->back()->withErrors($validate)->withInput();
    }// ==========================
// SAVE PHOTO (STORAGE STYLE)
// // ==========================
// $photoName = null;
// if ($request->hasFile('photo')) {
//     $photo     = $request->file('photo');
//     $photoName = time().'_'.$photo->getClientOriginalName();
//     $photo->storeAs('public/attendance/photos', $photoName);
// }


// ==========================
// SAVE DOCUMENT (STORAGE STYLE)
// ==========================
$documentName = null;
if ($request->hasFile('document_file')) {
    $document     = $request->file('document_file');
    $documentName = time().'_'.$document->getClientOriginalName();
    $document->storeAs('public/attendance/documents', $documentName);
}


    // SAVE EMPLOYEE
    $employee = new photoattendance();

    if ($request->emp_id) {
        $employee->emp_id = $request->emp_id; // ✅ FIXED
    }

    $employee->name            = $request->name;
    $employee->email           = $request->email;
    $employee->mobile          = $request->mobile;
    $employee->address         = $request->address;
    $employee->document_no     = $request->document_no;

    $employee->Report_time     = $request->Report_time;
    $employee->Buffer_time     = $request->Buffer_time;

    $employee->salary_amount   = $request->salary_amount;
    $employee->date_of_joining = $request->date_of_joining;
    $employee->document_type   = $request->document_type;

    $employee->terms_text      = $request->terms_text;
    $employee->terms           = 1;
     if ($request->hasFile('photo')) {

    $photo_image1=$request->photo;
    $name=$photo_image1->getClientOriginalName();
    $photo_image1->storeAS('public\room_image',$name);
    
   $employee->photo           = $name;
}

 
    $employee->document_submit = $documentName;

    $employee->save();

    return redirect()->back()->with('success', 'Employee Registered Successfully!');
}


// ===================================================================================================
    public function edit($id)
    {
        $employee = photoattendance::findOrFail($id);
        return view('photoattendancee.attendance_edit', compact('employee'));
    }

public function update(Request $request, $id)
{
    $employee = photoattendance::findOrFail($id);

    // VALIDATION
    $validate = Validator::make($request->all(), [
        'name'            => 'required|string|max:255',
        'email'           => 'nullable|email',
        'mobile'          => 'nullable|string|max:15',
        'address'         => 'nullable|string',
        'document_no'     => 'nullable|string|max:100',

        'report_time'     => 'nullable',
        'salary_amount'   => 'nullable|numeric',
        'date_of_joining' => 'nullable|date',
        'document_type'   => 'nullable|string',
        'buffer_time'     => 'nullable|string',

        'terms_text'      => 'nullable|string',
        'terms'           => 'nullable',

        'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'document_file'   => 'nullable|mimes:jpg,jpeg,png,pdf|max:4096',
    ]);

    if ($validate->fails()) {
        return redirect()->back()->withErrors($validate)->withInput();
    }

    /* ============================
       UPDATE BASIC FIELDS
    ============================ */
    $employee->name            = $request->name;
    $employee->email           = $request->email;
    $employee->mobile          = $request->mobile;
    $employee->address         = $request->address;
    $employee->document_no     = $request->document_no;

    $employee->Report_time     = $request->report_time;
    $employee->salary_amount   = $request->salary_amount;
    $employee->date_of_joining = $request->date_of_joining;
    $employee->document_type   = $request->document_type;
    $employee->Buffer_time     = $request->buffer_time;

    $employee->terms_text      = $request->terms_text;
    $employee->terms           = $request->has('terms') ? 1 : 0;


    /* ============================
       UPDATE PHOTO
    ============================ */
  if ($request->hasFile('photo')) {

    if ($employee->photo) {
        Storage::delete('public/attendance/photos/'.$employee->photo);
    }

    $photo     = $request->file('photo');
    $photoName = time().'_'.$photo->getClientOriginalName();
    $photo->storeAs('public/attendance/photos', $photoName);

    $employee->photo = $photoName;
}


    /* ============================
       UPDATE DOCUMENT
    ============================ */
   if ($request->hasFile('document_file')) {

    if ($employee->document_submit) {
        Storage::delete('public/attendance/documents/'.$employee->document_submit);
    }

    $document     = $request->file('document_file');
    $documentName = time().'_'.$document->getClientOriginalName();
    $document->storeAs('public/attendance/documents', $documentName);

    $employee->document_submit = $documentName;
}


    $employee->save();

    return redirect()
            ->route('attendances.create')
            ->with('success', 'Employee updated successfully!');
}

public function destroy($id)
{
    $employee = photoattendance::findOrFail($id);

    // ==========================
    // DELETE PHOTO (STORAGE)
    // ==========================
    if ($employee->photo) {
        Storage::delete('public/attendance/photos/' . $employee->photo);
    }

    // ==========================
    // DELETE DOCUMENT (STORAGE)
    // ==========================
    if ($employee->document_submit) {
        Storage::delete('public/attendance/documents/' . $employee->document_submit);
    }

    $employee->delete();

    return redirect()->back()->with('success', 'Employee deleted successfully!');
}

    // =====================================save advance salary=====================================================
public function saveAdvanceSalary(Request $request)
{
    $request->validate([
        'advance_salary' => 'required|numeric',
        'date' => 'required|date',
    ]);

attendancesalary::create([
        'emp_id' => $request->emp_no,
        'emp_name' => $request->emp_name, 
        'advance_salary' => $request->advance_salary,
        'date' => $request->date,
         'salary' => $request->salary, 
         'no_of_days_worked' => 0,
        'remark' => "Advance Given",
    ]);

    return back()->with('success', 'Advance Salary Added Successfully!');
}
}
