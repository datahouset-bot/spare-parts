<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roomcheckin extends Model
{
    use HasFactory;
    protected $fillable = [
        'token',
        'check_in_no',
        'voucher_no',
        'checkin_date',
        'checkin_time',
        'commited_days',
        'no_of_guest',
        'business_source_id',
        'package_id',
        'checkin_remark1',
        'checkin_remark2',
        'checkin_room_id',
        'checkin_room_no',
        'checkin_roomtype',
        'checkin_room_tariff',
        'checkin_room_dis',
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
        'value_added_service',
        'purpose_of_visit',
        'comming_from',
        'going_to',
        'agent',
        'guest_idproof',
        'guest_idproof_no',
        'gst_no',
        'room_tariff_perday',
        'booking_amount',
        'amt_posting_acc',
        'voucher_posting_amt',
        'voucher_payment_ref',
        'voucher_payment_remark',
        'guest_id_pic',
        'guest_pic',
        'is_billed',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
    public function room()
    {
        return $this->belongsTo(room::class, 'room_id', 'id');
    }
    public function package()
    {
        return $this->belongsTo(package::class, 'package_id', 'id');
    }

}
