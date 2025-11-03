<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gstmaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'taxname',
        'hsn_no',
        'sgst',
        'csgst',
        'igst',
        'vat',
        'tax1',
        'tax2',
        'tax3',
        'tax4',
        'tax5'
        // Add other fields here as necessary


    ];
    public function roomTypes()
    {
        return $this->hasMany(RoomType::class,'gst_id');
    }
    public function items()
    {
        return $this->hasMany(Item::class, 'item_gst_id','id'); // Ensure 'company_id' is the foreign key column in the 'items' table
    }

}
