<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roombooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_no',
        'voucher_no',
        'booking_date',
        'booking_time',
        'checkin_date',
        'checkin_time',
        'checkout_date',
        'checkout_time',
        'commited_days',
        'no_of_guest',
        'business_source_id',
        'package_id',
        'guest_name',
        'guest_address',
        'guest_address2',
        'guest_city',
        'guest_state',
        'guest_country',
        'guest_pincode',
        'guest_nationality',
        'guest_mobile',
        'guest_phone',
        'guest_email',
        'agent',
        'guest_idproof',
        'guest_idproof_no',
        'firm_name',
        'firm_address',
        'gst_no',
        'room_tariff_perday',
        'booking_amount',
        'posting_acc_id',
        'voucher_posting_amt',
        'voucher_payment_ref',
        'voucher_payment_remark',
    ];

    public function room()
    {
        return $this->belongsTo(room::class, 'room_id', 'id');
    }
}
