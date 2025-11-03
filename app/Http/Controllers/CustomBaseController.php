<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;
use App\Models\financialyear;
use Illuminate\Support\Facades\Auth;

class CustomBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $fy_start_date;
    protected $fy_end_date;
    protected $financialyeardata;

    public function __construct()
    {
        
        $this->middleware('permission:view role', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['create', 'store', 'addPermissionToRole', 'givePermissionToRole']]);
        $this->middleware('permission:update role', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete role', ['only' => ['destroy','rkot_destroy','payment_delete','advace_receipt_delete']]);

        $this->middleware(['auth', 'verified','check.subscription']);

          $this->middleware(function ($request, $next) {
            $financialyear = financialyear::where('firm_id', Auth::user()->firm_id)
                                ->where('is_active_fy', '1')
                                ->first();

            if ($financialyear) {
                $this->fy_start_date = $financialyear->financial_year_start;
                $this->fy_end_date = $financialyear->financial_year_end;
                $this->financialyeardata = $financialyear;
            } else {
                $this->fy_start_date = Carbon::parse('2024-04-01');
                $this->fy_end_date = Carbon::parse('2026-03-31');
                $this->financialyeardata = null;
            }

            return $next($request);
                });
        }




    
}
