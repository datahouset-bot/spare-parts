<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accountgroup extends Model
{
    use HasFactory;

    protected $table = 'accountgroups';

    protected $fillable = [
        'account_group_name',
        'primary_group_id',
    ];

    /**
     * Get the primary group associated with the account group.
     */
    public function primaryGroup()
    {
        return $this->belongsTo(primarygroup::class, 'primary_group_id');
    }
    public function accounts()
    {
        return $this->hasMany(account::class, 'account_group_id', 'id');
    }
}
