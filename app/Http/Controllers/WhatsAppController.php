<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\softwarecompany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    public function sendFromFrontend(Request $request)
    {
        $mobile = $request->query('number');

        $url = "https://wapp.powerstext.in/http-tokenkeyapi.php";
       
        $software_companyInfo = softwarecompany::where('firm_id',Auth::user()->firm_id)->first();
        $authentic_key=$software_companyInfo->software_af4; //i am getting autontication key 
       
        
        $response = Http::get($url, [
            'authentic-key' => $authentic_key,
            'route' => 1,
            'number' => "918871702803",
            'message' => 'Testing Message From Data House- whtaspp through roomg '
        ]);

        $data = $response->json();

        if ($data && $data['Status'] === 'Success') {
            return response()->json(['success' => true, 'message' => 'WhatsApp message sent successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to send message.']);
        }
    }
}
