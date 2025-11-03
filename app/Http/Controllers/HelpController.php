<?php

namespace App\Http\Controllers;

use App\Models\help;
use App\Http\Requests\StorehelpRequest;
use App\Http\Requests\UpdatehelpRequest;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index()
{
 $data = Help::orderBy('created_at', 'desc')->get();
return view('help.help', compact('data'));

}

public function store(Request $request)
{
    $request->validate([
        'type' => 'required',
        'topic' => 'required',
    ]);

    Help::create($request->all());
    return back()->with('message', 'Training video added successfully.');
}

public function edit($id)
{
    $helps = Help::findOrFail($id);
    return view('help.help_edit', compact('helps'));
}

public function update(Request $request, $id)
{
    $record = Help::findOrFail($id);
    $record->update($request->all());
    return redirect()->route('helps.index')->with('message', 'Updated successfully.');
}

public function destroy($id)
{
    Help::destroy($id);
    return back()->with('message', 'Deleted successfully.');
}

}
