<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendancesalary extends Model
{
    protected $table = 'attendancesalary';
    use HasFactory;
    protected $fillable = [
        'emp_id',
        'emp_name',
        'advance_salary',
        'date',
        'salary',
        'no_of_days_worked',
        'remark'

    ];
}
