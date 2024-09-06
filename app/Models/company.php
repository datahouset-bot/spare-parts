<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(Item::class, 'company_id'); // Ensure 'company_id' is the foreign key column in the 'items' table
    }
}
