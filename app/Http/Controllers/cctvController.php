<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cctvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           $accounts = account::where('firm_id',Auth::user()->firm_id)->get();
          $items = item::where('firm_id',Auth::user()->firm_id)->get();
        //   return $items;

         return view("cctv.cctv_entry", [
             'accountdata' => $accounts,
              'itemdata' => $items
         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
