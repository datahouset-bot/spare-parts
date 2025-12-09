<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\photoattendance;
use App\Models\attendancesalary;
use Illuminate\Support\Facades\DB;
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

    public function show($id)
{
     $employee = photoattendance::findOrFail($id);

    // Get all advance salary records
    $advances = DB::table('attendancesalary')
                    ->where('emp_id', $id)
                    ->orderBy('id', 'DESC')
                    ->get();

    // Total Advance Taken
    $totalAdvance = $advances->sum('advance_salary');

     $attendance = DB::table('attendancecheckins')
                    ->where('emp_id', $id)
                    ->orderBy('id', 'DESC')
                    ->get();

    $presentDays = $attendance->where('status', 'present')->count();
    $absentDays  = $attendance->where('status', 'absent')->count();
    $totalDays   = $attendance->count();

    return view('photoattendancee.attendance_show', compact(
        'employee', 'advances', 'totalAdvance', 'attendance',
        'presentDays',
        'absentDays',
        'totalDays'
    ));
}

    public function getEmployeeName($id)
    {
        $employee = photoattendance::find($id);
        return response()->json([
            'name' => $employee ? $employee->name : null
        ]);
    }

  public function store(Request $request)
{
    // VALIDATION
    $validate = Validator::make($request->all(), [
        'id'              => 'nullable|numeric',
        'name'            => 'required|string|max:255',
        'email'           => 'nullable|email',
        'mobile'          => 'nullable|string|max:15',
        'address'         => 'nullable|string',
        'document_no'     => 'nullable|string|max:100',
        'Report_time'     => 'nullable',
        'salary_amount'   => 'nullable|numeric',
        'date_of_joining' => 'nullable|date',
        'document_type'   => 'nullable|string',
        'Buffer_time'     => 'nullable|numeric',
        'terms_text'      => 'nullable|string',
        'terms'           => 'required',

        'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'document_file'   => 'nullable|mimes:jpg,jpeg,png,pdf|max:4096',
    ]);

    if ($validate->fails()) {
        return redirect()->back()->withErrors($validate)->withInput();
    }

    // ==========================
    //   SAVE PHOTO
    // ==========================
    $photoName = null;
    if ($request->hasFile('photo')) {
        $photoName = time() . '_' . $request->photo->getClientOriginalName();
        $request->photo->move(public_path('uploads/attendance/photos'), $photoName);
    }

    // ==========================
    //   SAVE DOCUMENT
    // ==========================
    $documentName = null;
    if ($request->hasFile('document_file')) {
        $documentName = time() . '_' . $request->document_file->getClientOriginalName();
        $request->document_file->move(public_path('uploads/attendance/documents'), $documentName);
    }

    // ==========================
    //   SAVE EMPLOYEE RECORD
    // ==========================
    $employee = new photoattendance();

    if ($request->id) {
        $employee->id = $request->id; // manual ID if needed
    }

    $employee->name            = $request->name;
    $employee->email           = $request->email;
    $employee->mobile          = $request->mobile;
    $employee->address         = $request->address;
    $employee->document_no     = $request->document_no;
    $employee->Report_time     = $request->Report_time;
    $employee->salary_amount   = $request->salary_amount;
    $employee->date_of_joining = $request->date_of_joining;
    $employee->document_type   = $request->document_type;
    $employee->Buffer_time     = $request->Buffer_time;

    $employee->terms_text      = $request->terms_text;
    $employee->terms           = $request->has('terms') ? 1 : 0;

    $employee->photo           = $photoName;
    $employee->document_submit = $documentName;

    $employee->save();

    return redirect()->back()->with('success', 'Employee Registered Successfully!');
}

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

        // Delete old file safely
        if (!empty($employee->photo)) {
            $oldPath = public_path('uploads/attendance/photos/' . $employee->photo);
            if (file_exists($oldPath) && is_file($oldPath)) {
                unlink($oldPath);
            }
        }

        // Save new file
        $photoName = time() . '_' . $request->photo->getClientOriginalName();
        $request->photo->move(public_path('uploads/attendance/photos'), $photoName);
        $employee->photo = $photoName;
    }


    /* ============================
       UPDATE DOCUMENT
    ============================ */
    if ($request->hasFile('document_file')) {

        if (!empty($employee->document_submit)) {
            $oldDoc = public_path('uploads/attendance/documents/' . $employee->document_submit);
            if (file_exists($oldDoc) && is_file($oldDoc)) {
                unlink($oldDoc);
            }
        }

        $documentName = time() . '_' . $request->document_file->getClientOriginalName();
        $request->document_file->move(public_path('uploads/attendance/documents'), $documentName);

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

        // DELETE PHOTO
        if ($employee->photo) {
            $path = public_path('uploads/attendance/photos/' . $employee->photo);
            if (file_exists($path)) unlink($path);
        }

        // DELETE DOCUMENT
        if ($employee->document_submit) {
            $path = public_path('uploads/attendance/documents/' . $employee->document_submit);
            if (file_exists($path)) unlink($path);
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
