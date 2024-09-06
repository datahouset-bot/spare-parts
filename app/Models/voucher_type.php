<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voucher_type extends Model
{
    use HasFactory;
    protected $fillable = [
        'voucher_type_name',
        'numbring_start_from',
        'voucher_prefix',
        'voucher_suffix',
        'voucher_numbring_style',
        'voucher_print_name',
        'voucher_remark',
    ];
}
