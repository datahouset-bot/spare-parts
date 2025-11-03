<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roomtype extends Model
{
    use HasFactory;
    protected $fillable = [
        'roomtype_name',
        'package_id',
        'gst_id',
        'room_tariff',
        'room_dis',
        'room_type_af1',
        'room_type_af2',
        'room_type_af3',
        'room_type_af4',
        'room_type_af5',
        'room_type_af6',
        'room_type_af7',
        'room_type_af8',
        'room_type_af9',
        'room_type_af10',
        'room_type_af11',
        'room_type_af12',
        'room_type_af13',
        // Add other fields here as necessary
    ];
    public function package()
    {
        return $this->belongsTo(package::class,'package_id');
    }
    public function gstmaster()
    {
        return $this->belongsTo(gstmaster::class,'gst_id');
        
    }
    public function room()
    {
        return $this->hasMany(Room::class,'roomtype_id');
    }
}
