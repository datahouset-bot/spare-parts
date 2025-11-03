<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class table extends Model
{
    use HasFactory;
    protected $fillable = [
        'firm_id',
        'table_name',
        'table_group',
        // Add other fields here as necessary
    ];
}
