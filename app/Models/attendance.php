<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['user_id', 'attendance_date', 'status', 'in_time', 'out_time','firm_id','attend_af1','attend_af2','attend_af3','attend_af4','attend_af5'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
