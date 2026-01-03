<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

{
    use AuthenticatesUsers;

 protected function authenticated($request, $user)
{
    // 1️⃣ Attendance Module users → Attendance screen
    if ($user->can('Attendance Module')) {
        return redirect()->route('attendance.checkin');
    }

    // 2️⃣ Crusher Module users → Crusher dashboard
    if ($user->can('Crusher Module')) {
        return redirect()->route('crusher.index'); // adjust route if needed
    }

    // 3️⃣ Everyone else → Home dashboard
    return redirect()->route('home');
}

public function __construct()
{
    $this->middleware('guest')->except('logout');
}
}