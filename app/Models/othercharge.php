<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class othercharge extends Model
{
    use HasFactory;
    protected $fillable = [
        'charge_name',
        'charge_type',
        'input_type',
        'applicable_on',
        'charge_posting_account',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'charge_posting_account','id');
    }
}
