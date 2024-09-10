<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventory extends Model
{
    use HasFactory;
    public function godown()
    {
        return $this->belongsTo(godown::class, 'godown_id', 'id');
    }
}
