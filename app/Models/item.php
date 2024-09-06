<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;
    protected $table = 'items';

    public function amc()
    {
        return $this->hasMany(Amc::class, 'amc_product_id', 'id');
    }
    public function kot()
    {
        return $this->hasMany(kot::class, 'item_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(unit::class,'unit_id','id');
    }
    public function gstmaster()
    {
        return $this->belongsTo(gstmaster::class,'item_gst_id','id');
    }

    public function company()
    {
        return $this->belongsTo(company::class, 'company_id'); // Ensure 'company_id' is the foreign key column in the 'items' table
    }

    // Define the relationship with the ItemGroup model
    public function itemgroup()
    {
        return $this->belongsTo(itemgroup::class, 'group_id','id'); // Ensure 'itemgroup_id' is the foreign key column in the 'items' table
    }
}
