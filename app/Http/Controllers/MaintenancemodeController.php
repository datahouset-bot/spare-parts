<?php

namespace App\Http\Controllers;

use App\Models\maintenancemode;
use App\Http\Requests\StoremaintenancemodeRequest;
use App\Http\Requests\UpdatemaintenancemodeRequest;
use PhpParser\Node\NullableType;
use Illuminate\Http\Request;

class MaintenancemodeController extends Controller
{

public function index(){
    $maintenancemode = maintenancemode::first();
    if (!$maintenancemode) {
        $maintenancemode = new maintenancemode();
        $maintenancemode->id =1;
        
        $maintenancemode->maintenance_mode = 0 ;
        $maintenancemode->start_time = Null;
        $maintenancemode->end_time =Null;
        $maintenancemode->message1 =Null;
        $maintenancemode->message2 =Null;
        $maintenancemode->message3 =Null;

        $maintenancemode->save();
    } 
    return view ('setting.maintenancemode',['maintenancemode'=>$maintenancemode]);
}

public function update(Request $request)
{
    // Validate the input
    $request->validate([
        'start_time' => 'nullable|date',
        'end_time' => 'nullable|date|after_or_equal:start_time',
        'message1' => 'nullable|string|max:255',
        'message2' => 'nullable|string|max:255',
        'message3' => 'nullable|string|max:255',
    ]);

    // Fetch or create the maintenance mode record
    $maintenancemode = maintenancemode::firstOrCreate(['id' => 1]);

    // Update values
    $maintenancemode->maintenance_mode = $request->has('maintenance_mode') ? 1 : 0;
    $maintenancemode->start_time = $request->start_time;
    $maintenancemode->end_time = $request->end_time;
    $maintenancemode->message1 = $request->message1;
    $maintenancemode->message2 = $request->message2;
    $maintenancemode->message3 = $request->message3;

    // Save changes
    $maintenancemode->save();

    // Redirect back with success message
    return redirect()->back()->with('message', 'Maintenance mode settings updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(maintenancemode $maintenancemode)
    {
        //
    }
}
