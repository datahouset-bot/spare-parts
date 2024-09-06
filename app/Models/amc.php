<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\item;
use App\Models\Lead;
use App\Models\account;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class amc extends Model
{

    use HasFactory;
    protected $table = 'amcs';
    protected $dates = [
        'amc_start_date',
        'amc_end_date',
    ];
    

    public function account()
    {
        return $this->belongsTo(Account::class, 'cust_name_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'amc_product_id', 'id');
    }


    // public function getAmcStartDateAttribute($value)
    // {

    //         /**
    //  * Accessor for formatting the amc_start_date attribute.
    //  *
    //  * @param  string  $value
    //  * @return string
    //  */
    //     // Check if the date is set
    //     if ($value) {
    //         // Convert the date to a Carbon instance
    //         $date = Carbon::parse($value);
    //         // Format the date as dd-mm-yy
    //         return $date->format('d-m-Y');
    //     }

    //     // Return null if the date is not set
    //     return null;
    // }
    // public function getAmcendDateAttribute($value)
    // {

    //         /**
    //  * Accessor for formatting the amc_start_date attribute.
    //  *
    //  * @param  string  $value
    //  * @return string
    //  */
    //     // Check if the date is set
    //     if ($value) {
    //         // Convert the date to a Carbon instance
    //         $date = Carbon::parse($value);
    //         // Format the date as dd-mm-yy
    //         return $date->format('d-m-Y');
    //     }

    //     // Return null if the date is not set
    //     return null;
    // }   
}
