<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingpageController extends Controller
{
    //

    public function show_secondindexpage()
    {
        return view ('second_index');

    }
}
