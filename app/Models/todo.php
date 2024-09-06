<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class todo extends Model
{
    use HasFactory;

    Protected $fillable =[
    'reminder_date',
    'reminder_title',
    'reminder_name',
    'reminder_mobile',
    'reminder_city',
    'reminder_disc',
    
];



public function setReminderDiscAttribute($value)
    {
        $this->attributes['reminder_disc'] = strtoupper($value);
    }

    public function setReminderCityAttribute($value)
    {
        $this->attributes['reminder_city'] = strtoupper($value);
    }
    public function setReminderMobileAttribute($value)
    {
        $this->attributes['reminder_mobile'] = strtoupper($value);
    }
    public function setReminderNameAttribute($value)
    {
        $this->attributes['reminder_name'] = strtoupper($value);
    }
    public function setReminderTitleAttribute($value)
    {
        $this->attributes['reminder_title'] = strtoupper($value);
    }
}

