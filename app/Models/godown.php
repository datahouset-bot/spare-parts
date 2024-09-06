<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class godown extends Model
{
    use HasFactory;
    protected $fillable = ['godown_name', 'godown_address', 'godown_af1','godown_af2'];

}
