<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roomcheckout extends Model
{
    use HasFactory;
    protected $fillable=[
        'voucher_no',
        'check_out_no',
        'checkin_date',
        'checkin_time',
        'checkout_date',
        'check_out_time',
        'calculation_type',
        'no_of_days',
        'per_day_tariff',
        'total_room_rent',
        'guest_name',
        'guest_mobile',
        'amt_posting_acc',
        'voucher_posting_amt',
        'room_no',
        'room_id',
        'checkin_voucher_no'
    ];
    public function account()
    {
        return $this->belongsTo(account::class, 'account_id', 'id');
    }
}
