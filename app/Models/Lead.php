<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    public function Followup()
    {
        // return $this->hasMany(Amc::class, 'cust_name_id', 'id');

        return $this->hasMany(Lead::class, 'lead_id', 'id');
    }

    public function setLeadMobileAttribute($value)
    {
        $this->attributes['lead_mobile'] = str_replace(' ', '', $value);
    }
    public function setLeadTitleAttribute($value)
    {
        $this->attributes['lead_title'] = strtoupper($value);
    }
    public function setLeadNameAttribute($value)
    {
        $this->attributes['lead_name'] = strtoupper($value);
    }
    public function setLeadProductAttribute($value)
    {
        $this->attributes['lead_product'] = strtoupper($value);
    }
    public function setLeadDiscAttribute($value)
    {
        $this->attributes['lead_disc'] = strtoupper($value);
    }


}
