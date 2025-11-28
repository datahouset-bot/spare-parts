<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class labelsetting extends Model
{
    use HasFactory;
     protected $fillable = [
        'firm_id',
        'field_name',
        'replaced_field_name',
        'is_visible',
    ];
}
