<?php

namespace App\Imports;

use App\Models\account;
use Maatwebsite\Excel\Concerns\ToModel;

class accountImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // print_r($row);

        if (!empty($row[1])){
 
        return new account([

            'account_name'=>$row[1],
            'account_group'=>$row[2],
            'op_balnce'=>$row[3],
            'balnce_type'=>$row[4],
            'address'=>$row[5],
            'city'=>$row[6],
            'state'=>$row[7],
            'phone'=>$row[8],
            'mobile'=>$row[9],
            'email'=>$row[10],
            'person_name'=>$row[11],
            `gst_no`=>$row[12]

        ]);
    }

         
    }
}
