<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kot extends Model
{
    use HasFactory;
    public function item()
    {
        return $this->belongsTo(item::class, 'item_id', 'id');
    }
}
