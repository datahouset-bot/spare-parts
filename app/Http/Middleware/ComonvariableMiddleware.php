<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\pic;
use App\Models\componyinfo;
use App\Models\compinfofooter;
use App\Models\softwarecompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ComonvariableMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
      
       
        if (!$user) {
            // Default firm (global/shared data)
            $firmId = 'DATA0001';
            $componyinfo = Componyinfo::where('firm_id', $firmId)->first();
            $pic = Pic::where('firm_id', $firmId)->first();
            $compinfofooter = Compinfofooter::where('firm_id', $firmId)->first();
            $softwarecompinfo = Softwarecompany::where('firm_id', $firmId)->first();
        } else {
            // Firm-specific data
            $firmId = $user->firm_id;
            $componyinfo = Componyinfo::where('firm_id', $firmId)->first();
            $pic = Pic::where('firm_id', $firmId)->first();
            $compinfofooter = Compinfofooter::where('firm_id', $firmId)->first();
            $softwarecompinfo = Softwarecompany::where('firm_id', $firmId)->first();
        }

        // Share data with all views
        view()->share([
            'compinfofooter' => $compinfofooter,
            'componyinfo' => $componyinfo,
            'pic' => $pic,
            'softwarecompinfo' => $softwarecompinfo,
        ]);


        return $next($request);
    }
}
