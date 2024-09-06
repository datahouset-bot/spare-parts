<?php

namespace App\Http\Middleware;
use App\Models\compinfofooter;
use App\Models\pic;
use App\Models\componyinfo;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ComonvariableMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
     $componyinfo=componyinfo::find(1);
     $pic=pic::find(1);
     
        $compinfofooter = compinfofooter::find(1); // Fetch the data from the model
        view()->share(['compinfofooter'=> $compinfofooter,'componyinfo'=>$componyinfo,'pic'=>$pic]); // Share
        return $next($request);
    }
}
