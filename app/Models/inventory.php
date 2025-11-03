<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFinancialYear;

class inventory extends Model
{
    use HasFactory;
    use HasFinancialYear;
    public function godown()
    {
        return $this->belongsTo(godown::class, 'godown_id', 'id');
    }
}
