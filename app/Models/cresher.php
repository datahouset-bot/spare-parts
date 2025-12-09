<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cresher extends Model
{
    use HasFactory;
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
