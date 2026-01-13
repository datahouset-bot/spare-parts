<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempentry extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_name',
        'voucher_no',
        'voucher_type',
        'entry_date',
        'item_id',
        'item_name',
        'qty',
        'rate',
        'amount',
        'total_discount',
        'total_amount',
        'total_gst_name',
        'total_gst_id',
        'total_gst',
        'item_net_value'  ,
        'account_id'  ,
        'temp_af1'  ,
        'firm_id', 
    ];
}
