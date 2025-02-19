<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\softwarecompany;

class CheckSubscriptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $softwarecompinfo = softwarecompany::where('firm_id',Auth::user()->firm_id)->first();

        if ($user->email !== 'datahouset@gmail.com' && $user->email !== Auth::user()->firm_id . '@gmail.com') {

            $expiryDate = Carbon::parse($softwarecompinfo->expiry_date);
            $currentDate = Carbon::now();
            $daysDifference = $currentDate->diffInDays($expiryDate, false);

            if ($daysDifference < 0) {
                // Subscription has expired, show 'subscription_expired' view
                return response()->view('subscription_expired');
            }
        }

        return $next($request);
    }
}
