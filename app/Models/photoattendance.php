<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class photoattendance extends Model
{
    use HasFactory;
     protected $fillable = [

        'id',
        'name',
        'email',
        'mobile',
        'address',
        'document_no',
        'Report_time',
        'salary_amount',
        'date_of_joining',
        'document_type',
        'document_submit',
        'terms_text',
        'terms',
        'photo',
        'Buffer_time',
    ];
    public function latestAdvance()
{
    return $this->hasOne(\App\Models\Attendancesalary::class, 'emp_id')
                ->latest();
}

}
