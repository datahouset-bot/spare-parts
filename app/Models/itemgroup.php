<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemgroup extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = ['item_group'];
    public function items()
    {
        return $this->hasMany(item::class,'group_id','id');
    }
    
}
