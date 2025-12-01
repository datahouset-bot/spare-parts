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
    'vehicle_no',
    'party_name',
    'Vehicle_name',
    'Material',
    'Royalty',
    'Quantity',
    'address',
    'phone',
    'remark',
    'pic',
];

}
