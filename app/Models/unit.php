<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    use HasFactory;
    protected $fillable = ['firm_id', 'primary_unit_name', 'conversion', 'alternate_unit_name'];

    public function items()
    {
        return $this->hasMany(item::class,'unit_id','id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($unit) {
            if (empty($unit->alternate_unit_name)) {
                $unit->alternate_unit_name = $unit->primary_unit_name;
            }
        });
    }
}
