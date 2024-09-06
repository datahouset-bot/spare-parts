<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class businesssource extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_source_name',
        'buiness_source_remark'
    
        // Add other fields here as necessary
    ];
}
