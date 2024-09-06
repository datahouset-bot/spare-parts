<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function runBackup()
{
    Artisan::call('backup:run');
    $output = Artisan::output();

    // Log the output to a file
   return("Backup output: " . $output);


}

}
