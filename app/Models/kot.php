<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFinancialYear;

class kot extends Model
{
    use HasFactory;
    use HasFinancialYear;
    public function item()
    {
        return $this->belongsTo(item::class, 'item_id', 'id');
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
