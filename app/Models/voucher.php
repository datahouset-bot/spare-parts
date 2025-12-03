<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFinancialYear;

class voucher extends Model
{
    use HasFactory;
    use HasFinancialYear;
    public function account()
    {
        return $this->belongsTo(account::class, 'account_id', 'id');
    }
         protected $fillable = [ 'voucher_no',
            'voucher_date',
            'voucher_terms',
            'voucher_bill_no',
            'total_qty',
            'total_net_amount',
            'total_item_basic_amount',
            'total_gst_amount',
            'total_disc_item_amount',
            'total_roundoff',
            'date',
            'account_id',
            'amount',
            'type',
            'description',
            'financial_year_id',
        ];
    
}
