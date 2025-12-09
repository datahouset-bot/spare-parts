<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendancecheckin extends Model
{
    use HasFactory;
      protected $fillable = [
        'emp_id',
        'emp_name',
        'checkin_photo',
        'checkout_photo',
        'checkin_time',
        'checkout_time',
    ];
}
