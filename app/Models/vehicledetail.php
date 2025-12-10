<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicledetail extends Model
{
    
    protected $table = "vehicledetails";
    use HasFactory;
    protected $fillable = [
        'vehicle_name',
        'owner_name',
        'Vehicle_no',
        'vehicle_measure',
        'Registration_date',
        'Driver_name',
        'Driver_contact',
        'Driver_address',
        'model_year',
        'Insaurance',
        'PUC',
    ];
}
