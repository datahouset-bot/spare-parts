<?php

namespace App\Models;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    use HasFactory;

    public function setFollowupRemarkAttribute($value)
    {
        $this->attributes['followup_remark'] = strtoupper($value);
    }

    public static function getRecordsWithHighestIdForEachLead()
    {
        return self::query()
        ->select('f.lead_id', 'f.followup_date', 'f.followup_remark', 'f.id')
        ->from(DB::raw('(SELECT lead_id, MAX(id) AS max_id FROM followups GROUP BY lead_id) AS subquery'))
        ->join('followups as f', function ($join) {
            $join->on('f.lead_id', '=', 'subquery.lead_id')
                ->on('f.id', '=', 'subquery.max_id');
        });
    }




    public function Lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id', 'id');
    }
}
