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
    'vehicle_measure',
    'Material',
    'Royalty',
    'Quantity',
    'address',
    'phone',
    'remark',
    'pic',
];

}
