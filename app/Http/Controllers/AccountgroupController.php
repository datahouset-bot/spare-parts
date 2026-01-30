<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\accountgroup;
use App\Models\primarygroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\StoreaccountgroupRequest;
use App\Http\Requests\UpdateaccountgroupRequest;

class AccountgroupController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $primarygroups = primarygroup::where('firm_id', Auth::user()->firm_id)->get();
        $data = AccountGroup::with('primarygroup')
            ->where('firm_id', Auth::user()->firm_id)
            ->get();

        return view('master.account_group.account_group', ['primarygroups' => $primarygroups, 'data' => $data]);
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
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_group_name' => 'required|unique:accountgroups',
            'primary_group_id' => 'required',

        ]);


        if ($validator->passes()) {
            $accountgroup = new accountgroup;
            $accountgroup->firm_id = Auth::user()->firm_id;
            $accountgroup->account_group_name = $request->account_group_name;
            $accountgroup->primary_group_id = $request->primary_group_id;
            $accountgroup->save();

            return redirect('/accountgroups')->with('message', 'Account  Group  Created successfully!');
        } else {
            return redirect('/accountgroups')->withInput()->withErrors($validator);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(accountgroup $accountgroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $accountgroup = accountgroup::where('firm_id', Auth::user()->firm_id)
            ->findOrFail($id);
        $primarygroups = primarygroup::where('firm_id', Auth::user()->firm_id)
            ->get();
        return view('master.account_group.account_group_edit', compact('accountgroup', 'primarygroups'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {



        $request->validate([
            'account_group_name' => [
                'required',
                Rule::unique('accountgroups')->where(fn($query) => $query->where('firm_id', Auth::user()->firm_id)),
            ],
            'primary_group_id' => 'required',
        ]);



        $accountgroup = accountgroup::where('firm_id', Auth::user()->firm_id)->findOrFail($id);
        $accountgroup->account_group_name = $request->account_group_name;

        $accountgroup->update();

        return redirect()->route('accountgroups.index')->with('message', 'Account Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $accountgroup = accountgroup::where('firm_id', Auth::user()->firm_id)->find($id);

        // Check if the package exists
        if ($accountgroup) {
            // Delete the package
            $accountgroup->delete();
            return redirect('/accountgroups')->with('message', 'Account Group Delete Successfully!');
        } else {
            // accountgroup not found
            return redirect('/accountgroups')->with('message', 'accountgroup Not Found');
        }
    }

public function storeAjax(Request $request)
{
    try {
        // ✅ Validate input
        $validated = $request->validate([
            'account_group_name' => 'required|string|max:255',
            'primary_group_id' => 'required|string|max:255',
        ]);

        // ✅ Create account group
        $group = AccountGroup::create([
            'account_group_name' => $validated['account_group_name'],
            'primary_group_id' => $validated['primary_group_id'],
            'firm_id' => Auth::user()->firm_id,
        ]);

        // ✅ Success response
        return response()->json([
            'success' => true,
            'id' => $group->id,
            'account_group_name' => $group->account_group_name,
        ], 200);

    } catch (ValidationException $e) {

        // ❌ Validation error
        return response()->json([
            'success' => false,
            'type' => 'validation',
            'errors' => $e->errors(),
        ], 422);

    } catch (Exception $e) {

        // 🧠 Log real error for developer
        Log::error('AccountGroup AJAX Error', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);

        // ❌ Generic safe message for user
        return response()->json([
            'success' => false,
            'type' => 'server',
            'message' => 'Something went wrong while saving account group.',
            'debug' => config('app.debug') ? [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ] : null,
        ], 500);
    }
}
}