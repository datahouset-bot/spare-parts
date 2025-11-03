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
}
