<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class account extends Model
{
    use HasFactory;
    protected $table = 'accounts';

    Protected $fillable =[
        'firm_id',
        'account_name',
        'account_group_id',
        'op_balnce',
        'balnce_type',
        'address',
        'city',
        'state',
        'phone',
        'mobile',
        'email',
        'person_name'

    ];
    

    public function amc()
    {
        return $this->hasMany(Amc::class, 'cust_name_id', 'id');
    }
    public function roomcheckin()
    {
        return $this->hasMany(roomcheckin::class, 'account_id', 'id');
    }
    public function roomcheckout()
    {
        return $this->hasMany(roomcheckout::class, 'account_id', 'id');
    }

    public function otherCharges()
    {
        return $this->hasMany(OtherCharge::class, 'charge_posting_account', 'id');
    }

    public function accountgroup()
    {
        return $this->belongsTo(accountgroup::class, 'account_group_id','id' );
    }
    public function voucher()
    {
        return $this->hasMany(voucher::class, 'account_id', 'id');
    }
}
