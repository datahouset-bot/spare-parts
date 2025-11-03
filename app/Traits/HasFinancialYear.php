<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\financialyear;
use Illuminate\Support\Facades\Auth;

trait HasFinancialYear
{
    public function scopeWithinFY($query, $column)
    {
        $firm_id = Auth::user()->firm_id ?? null;

        $financialyear = financialyear::where('firm_id', $firm_id)
            ->where('is_active_fy', 1)
            ->first();

        $fy_start = $financialyear->financial_year_start ?? Carbon::parse('2024-04-01');
        $fy_end = $financialyear->financial_year_end ?? Carbon::parse('2026-03-31');

        return $query->whereBetween($column, [$fy_start, $fy_end]);
    }
}
