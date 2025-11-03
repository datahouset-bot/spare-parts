<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class help extends Model
{
    protected $fillable = [
         'business_type', 
        'type',
        'topic',
        'url',
        'description',
        'help_af1',
        'help_af2',
        'help_af3',
        'help_af4',
        'help_af5',
        'help_af6',
        'help_af7',
        'help_af8',
        'help_af9',
        'help_af10',
    ];
    use HasFactory;
}
