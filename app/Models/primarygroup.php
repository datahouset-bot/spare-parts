<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class primarygroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'primary_group_name'
        // Add other fields here as necessary
    ];
    protected $table = 'primarygroups';


    /**
     * Get the account groups for the primary group.
     */
    public function accountGroups()
    {
        return $this->hasMany(accountgroup::class, 'primary_group_id');
    }
}
