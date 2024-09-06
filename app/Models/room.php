<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    use HasFactory;

    protected $fillable = ['room_no', 'roomtype_id', 'room_floor', 'room_facilities','room_image1','room_image2','room_image3','room_status'];
    const STATUS_VACANT = 'vacant';
    const STATUS_BOOKED = 'booked';
    const STATUS_OCCUPIED = 'occupied';
    const STATUS_DIRTY = 'dirty';
    public function roomtype()
    {
        return $this->belongsTo(roomtype::class,'roomtype_id');
    }

    public function roombooking()
    {
        return $this->hasMany(roombooking::class, 'room_id', 'id');
    }
    public function roomcheckin()
    {
        return $this->hasMany(roomcheckin::class, 'room_id', 'id');
    }


}
