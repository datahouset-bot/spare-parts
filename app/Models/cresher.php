<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\HasFinancialYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class cresher extends Model
{
    use HasFactory;
    use HasFinancialYear;
    protected $fillable = [
        'slip_no',
        'date',
        'time',
        'acc_id',
        'vehicle_id',
        'vehicle_no',
        'party_name',
        'vehicle_measure',
        'Material',
        'Materialremark',
        'Quantity',
        'Rate',
        'unit',
        'Royalty_Quantity',
        'Royalty_Rate',
        'Royalty',
        'Total',
        'address',
        'phone',
        'remark',
        'pic',
];
  

}
