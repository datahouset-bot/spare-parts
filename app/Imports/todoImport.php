<?php

namespace App\Imports;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\todo;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class todoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!empty($row[2])){
 
            return new todo([

                'reminder_date' => Carbon::now()->toDateString(), // Adding current date
                'reminder_title'=>$row[2],
                'reminder_name'=>$row[3],
                'reminder_mobile'=>$row[4],
                'reminder_city'=>$row[5],
                'reminder_disc'=>$row[6],
     
    
                //
            ]);
            
        }
        
        
 
    }
}
