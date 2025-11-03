<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class package extends Model
{
    use HasFactory;
    protected $fillable = [
        'package_name',
        'plan_name',
        'other_name',
        // Add other fields here as necessary
    ];

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }
    public function roomcheckin()
    {
        return $this->hasMany(roomcheckin::class, 'package_id', 'id');
    }
    public function roombooking()
    {
        return $this->hasMany(roombooking::class, 'package_id', 'id');
    }
}
