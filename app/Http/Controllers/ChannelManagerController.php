<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\room;
use App\Models\account;
use App\Models\package;
use App\Models\roomtype;
use App\Models\componyinfo;
use App\Models\roombooking;
use Illuminate\Support\Str;
use App\Models\accountgroup;
use Illuminate\Http\Request;
use App\Models\businesssource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ChannelManagerController extends Controller
{
    public function pushInventory()
    {
    $vacantroom_roomtype = Room::where('rooms.firm_id', Auth::user()->firm_id)
        ->where('rooms.room_status', 'vacant')
        ->join('roomtypes', 'rooms.roomtype_id', '=', 'roomtypes.id')
        ->select(
            'roomtypes.roomtype_name',
            'roomtypes.room_type_af1',
            DB::raw('COUNT(rooms.id) as total')
        )
        ->groupBy('roomtypes.roomtype_name', 'roomtypes.room_type_af1')
        ->get();

    // Step 2: Format data for API
    $rooms = $vacantroom_roomtype->map(function ($room) {
        return [
            'available' => $room->total,
            'roomCode'  => $room->room_type_af1,  // room type code
        ];
    })->toArray();
    $componyinfo=componyinfo::where('firm_id',Auth::user()->firm_id)->first();
 

    $today = now()->format('Y-m-d');
    $cm_hotelcode=$componyinfo->componyinfo_af3;

    $payload = [
        "hotelCode" => $cm_hotelcode, // your hotel code
        "updates"   => [
            [
                "startDate" => $today,
                "endDate"   => $today, // both same
                "rooms"     => $rooms,
            ]
        ]
    ];

    // Step 3: Send to API
    $response = Http::post("https://live.aiosell.com/api/v2/cm/update/datahouse", $payload);

$debugData = [
    'vacantroom_roomtype' => $vacantroom_roomtype ?? null,
    'sent_payload'        => $payload ?? [],
    'api_response'        => $response->json() ?? [],
];

// Directly return HTML from controller
$debugData = [
    'vacantroom_roomtype' => $vacantroom_roomtype ?? null,
    'sent_payload'        => $payload ?? [],
    'api_response'        => $response->json() ?? [],
];

return view('channalmanager.pushInventory', compact('debugData'));



    }



public function showroomtype(){
    $componyinfo=componyinfo::where('firm_id',Auth::user()->firm_id)->first();
    $roomtype =roomtype::where('firm_id',Auth::user()->firm_id)->with('package','gstmaster')->get(); 

 
}
public function pushrate(Request $request)
{
    // 1. Get company info (hotel code)
    $componyinfo = Componyinfo::where('firm_id', Auth::user()->firm_id)->first();
    $cm_hotelcode = $componyinfo->componyinfo_af3; // Hotel code for API

    // 2. Get room types for this firm
    $roomtypes = Roomtype::where('firm_id', Auth::user()->firm_id)->get();

    // 3. Build API payload
    $payload = [
        "hotelCode" => $cm_hotelcode,
        "updates" => [
            [
                "startDate" => $request->start_date,   // pass in request
                "endDate"   => $request->end_date,     // pass in request
                "rates" => []
            ]
        ]
    ];

    foreach ($roomtypes as $room) {
        // Single
        if (!empty($room->room_type_af2) && !empty($room->room_type_af3)) {
            $payload["updates"][0]["rates"][] = [
                "roomCode"     => $room->room_type_af1,
                "rate"         => (float)$room->room_type_af3,
                "rateplanCode" => $room->room_type_af2,
            ];
        }

        // Double
        if (!empty($room->room_type_af4) && !empty($room->room_type_af5)) {
            $payload["updates"][0]["rates"][] = [
                "roomCode"     => $room->room_type_af1,
                "rate"         => (float)$room->room_type_af5,
                "rateplanCode" => $room->room_type_af4,
            ];
        }

        // Triple
        if (!empty($room->room_type_af6) && !empty($room->room_type_af7)) {
            $payload["updates"][0]["rates"][] = [
                "roomCode"     => $room->room_type_af1,
                "rate"         => (float)$room->room_type_af7,
                "rateplanCode" => $room->room_type_af6,
            ];
        }

        // Quad
        if (!empty($room->room_type_af8) && !empty($room->room_type_af9)) {
            $payload["updates"][0]["rates"][] = [
                "roomCode"     => $room->room_type_af1,
                "rate"         => (float)$room->room_type_af9,
                "rateplanCode" => $room->room_type_af8,
            ];
        }
    }

    // 4. Push API
    $url = "https://live.aiosell.com/api/v2/cm/update-rates/datahouse";

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post($url, $payload);

    // 5. Return response
    return response()->json([
        "status"   => $response->status(),
        "response" => $response->json(),
        "payload"  => $payload
    ]);
}





// public function store_roombookiking_api(Request $request)
// {

//         // 1. Validate required fields
//      $validator = Validator::make($request->all(), [
//     'hotelCode'   => 'required|string',
//     'bookingId'   => 'required|string',


// ]);


//         if ($validator->fails()) {
//             return response()->json([
//                 'status'  => 'error',
//                 'message' => 'Validation failed',
//                 'errors'  => $validator->errors()
//             ], 422);
//         }

//         try {

//             $cmcode=$request->hotelCode;
//             $companyinfo=componyinfo::where('componyinfo_af3',$cmcode)->first();
//             $firm_id=$companyinfo->firm_id;
// $businessSource = businesssource::where('firm_id', $firm_id)
//     ->where('business_source_name', $request->channel)
//     ->first();

// if (!$businessSource) {
//     return response()->json([
//         'status'  => 'error',
//         'message' => 'Business source not found',
//     ], 404);
// }
// $business_source_id = $businessSource->id;



// $room = room::where('firm_id', $firm_id)
//     ->where('room_no', 'ONLINE_BOOKING')
//     ->first();

// if (!$room) {
//     return response()->json([
//         'status'  => 'error',
//         'message' => 'Room with code ONLINE_BOOKING not found',
//     ], 404);
// }
// $room_id = $room->id;

//             // 2. Ensure guest account exists
//             $guest = Account::where('mobile', $request->guest['phone'])->first();
//             if (!$guest) {
//                 $guest = new Account();
//                 $guest->firm_id=$firm_id;
//                 // $guest->account_name = $request->guest['firstName'] . ' ' . $request->guest['lastName'];
//                 // $guest->mobile       = $request->guest['phone'];
//                 // $guest->email        = $request->guest['email'];
                

// // ✅ Safe assignment with random fallback
// $guest->account_name = 
//     ($request->guest['firstName'] ?? Str::random(5)) . ' ' . 
//     ($request->guest['lastName']  ?? Str::random(5));

// $guest->mobile = $request->guest['phone'] 
//     ?? rand(6000000000, 9999999999);   // random 10-digit number

// $guest->email = $request->guest['email'] 
//     ?? Str::random(8) . '@example.com'; // random email

//                 $guest->address      = $request->guest['address']['line1'] ?? '';
//                 $guest->city         = $request->guest['address']['city'] ?? '';
//                 $guest->state        = $request->guest['address']['state'] ?? '';
//                 $guest->pincode      = $request->guest['address']['zipCode'] ?? '';
//                 $guest->nationality  = $request->guest['address']['country'] ?? '';

//                 // attach to Guest Customer group if exists
//                 $group = AccountGroup::where('account_group_name', 'Guest Customer')->first();
//                 if ($group) {
//                     $guest->account_group_id = $group->id;
//                 }
//                 $guest->save();
//             }

//             foreach ($request->rooms as $roomData) {
//     // find package based on each room's rateplanCode
//     $package = package::where('firm_id', $firm_id)
//         ->where('package_name', $roomData['rateplanCode'])
//         ->first();

//     if (!$package) {
//         return response()->json([
//             'status'  => 'error',
//             'message' => 'Package not found for rateplanCode: ' . $roomData['rateplanCode'],
//         ], 404);
//     }

//     $package_id = $package->id;

//     $booking = new RoomBooking();
//     $booking->firm_id         = $firm_id;
//     $booking->booking_no      = $request->bookingId;
//     $booking->voucher_no      = $request->bookingId;
//     $booking->booking_date    = Carbon::parse($request->bookedOn)->format('Y-m-d');
//     $booking->checkin_date    = Carbon::parse($request->checkin)->format('Y-m-d');
//     $booking->checkout_date   = Carbon::parse($request->checkout)->format('Y-m-d');
//     $booking->guest_name      = $roomData['guestName'];
//     $booking->guest_mobile    = $request->guest['phone'];
//     $booking->guest_email     = $request->guest['email'];
//     $booking->room_tariff_perday = $roomData['prices'][0]['sellRate'] ?? 0;
//     $booking->no_of_guest     = $roomData['occupancy']['adults'] + ($roomData['occupancy']['children'] ?? 0);
//     $booking->bookingaf3      = $request->specialRequests ?? null;
//     $booking->business_source_id = $business_source_id;
//     $booking->package_id      = $package_id;  // ✅ correct now
//     $booking->room_id         = $room_id;
//     $booking->room_no         = $room->room_no;
//     $booking->save();
// }


//             // 4. Return success
//             return response()->json([
//                 'status'  => 'success',
//                 'message' => 'Booking stored successfully',
//                 'bookingId' => $request->bookingId
//             ]);

//         } catch (\Exception $e) {
//             return response()->json([
//                 'status'  => 'error',
//                 'message' => 'Something went wrong',
//                 'error'   => $e->getMessage()
//             ], 500);
//         }
//     }
// public function store_roombookiking_api(Request $request)
// {
//     // 1. Validate only required fields
//     $validator = Validator::make($request->all(), [
//         'hotelCode' => 'required|string',
//         'bookingId' => 'required|string',
//     ]);

//     if ($validator->fails()) {
//         return response()->json([
//             'status'  => 'error',
//             'message' => 'Validation failed',
//             'errors'  => $validator->errors()
//         ], 422);
//     }

//     try {
//         $cmcode = $request->hotelCode;
//         $companyinfo = componyinfo::where('componyinfo_af3', $cmcode)->first();
//         $firm_id = $companyinfo->firm_id;

// $businessSource = businesssource::where('firm_id', $firm_id)
//     ->where('business_source_name', $request->channel)
//     ->first();

// if (!$businessSource) {
//     // Fallback to Direct
//     $businessSource = businesssource::where('firm_id', $firm_id)
//         ->where('business_source_name', 'Direct')
//         ->first();
// }

// if (!$businessSource) {
//     return response()->json([
//         'status'  => 'error',
//         'message' => 'Business source not found (including Direct)',
//     ], 404);
// }

// $business_source_id = $businessSource->id;


//         $room = room::where('firm_id', $firm_id)
//             ->where('room_no', 'ONLINE_BOOKING')
//             ->first();

//         if (!$room) {
//             return response()->json([
//                 'status'  => 'error',
//                 'message' => 'Room with code ONLINE_BOOKING not found',
//             ], 404);
//         }
//         $room_id = $room->id;

//         // 2. Ensure guest account exists
//  // 2. Ensure guest account exists
// $guestPhone = $request->input('guest.phone');

// // If phone is null or empty, use bookingId's numeric value
// if (empty($guestPhone)) {
//     // Extract only numeric digits from bookingId
//     $guestPhone = preg_replace('/\D/', '', $request->bookingId);

//     // If bookingId had no digits, fall back to random number
//     if (empty($guestPhone)) {
//         $guestPhone = date('Ymd') . rand(1000, 9999);
//     }
// }

// $guestEmail = $request->input('guest.email', Str::random(8) . '@example.com');
// $guestFName = $request->input('guest.firstName', Str::random(5));
// $guestLName = $request->input('guest.lastName', Str::random(5));

// $guest = Account::where('mobile', $guestPhone)->first();
// if (!$guest) {
//     $guest = new Account();
//     $guest->firm_id      = $firm_id;
//     $guest->account_name = $guestFName . ' ' . $guestLName;
//     $guest->mobile       = $guestPhone;   // ✅ now using correct phone
//     $guest->email        = $guestEmail;
//     $guest->address      = $request->guest['address']['line1'] ?? '';
//     $guest->city         = $request->guest['address']['city'] ?? '';
//     $guest->state        = $request->guest['address']['state'] ?? '';
//     $guest->pincode      = $request->guest['address']['zipCode'] ?? '';
//     $guest->nationality  = $request->guest['address']['country'] ?? '';

//     $group = AccountGroup::where('account_group_name', 'Guest Customer')->first();
//     if ($group) {
//         $guest->account_group_id = $group->id;
//     }
//     $guest->save();
// }

//         // 3. Store room bookings
//         foreach ($request->rooms as $roomData) {
//            $package = package::where('firm_id', $firm_id)
//     ->where('package_name', $roomData['rateplanCode'])
//     ->first();

// if (!$package) {
//     // Fallback to General
//     $package = package::where('firm_id', $firm_id)
//         ->where('package_name', 'General')
//         ->first();
// }

// if (!$package) {
//     return response()->json([
//         'status'  => 'error',
//         'message' => 'Package not found for rateplanCode: ' . $roomData['rateplanCode'] . ' or fallback General',
//     ], 404);
// }

// $package_id = $package->id;


//             $booking = new RoomBooking();
//             $booking->firm_id         = $firm_id;
//             $booking->booking_no      = $request->bookingId;
//             $booking->voucher_no      = $request->bookingId; // using bookingId instead of cmBookingId
//             $booking->booking_date    = Carbon::parse($request->bookedOn ?? now())->format('Y-m-d');
//             $booking->checkin_date    = Carbon::parse($request->checkin ?? now())->format('Y-m-d');
//             $booking->checkout_date   = Carbon::parse($request->checkout ?? now()->addDay())->format('Y-m-d');
//             $booking->guest_name      = $roomData['guestName'] ?? $guestFName . ' ' . $guestLName;
//            $booking->guest_mobile    = $guestPhone; // ✅ instead of hardcoded "9998989"

//             $booking->guest_email     = $guestEmail;
//             $booking->room_tariff_perday = $roomData['prices'][0]['sellRate'] ?? 0;
//             $booking->no_of_guest     = ($roomData['occupancy']['adults'] ?? 1) + ($roomData['occupancy']['children'] ?? 0);
//             $booking->bookingaf3      = $request->specialRequests ?? null;
//             $booking->business_source_id = $business_source_id;
//             $booking->package_id      = $package->id;
//             $booking->room_id         = $room_id;
//             $booking->room_no         = $room->room_no;
//             $booking->save();
//         }

//         // 4. Return success
//         return response()->json([
//             'status'  => 'success',
//             'message' => 'Booking stored successfully',
//             'bookingId' => $request->bookingId
//         ]);

//     } catch (\Exception $e) {
//         return response()->json([
//             'status'  => 'error',
//             'message' => 'Something went wrong',
//             'error'   => $e->getMessage()
//         ], 500);
//     }
// }


public function store_roombookiking_api(Request $request)
{
    // 🔥 Always log API hit
    \Log::info('🔥 API HIT: store_roombookiking_api', [
        'headers' => $request->headers->all(),
        'data'    => $request->all(),
    ]);

    // Default response — assume API hit is successful
    $response = [
        'status'        => 'success',
        'message'       => '✅ API Hit Successfully',
        'bookingId'     => $request->bookingId ?? null,
        'received_data' => $request->all(),
    ];

    try {
        // ✅ 1. Basic validation
        $validator = Validator::make($request->all(), [
            'hotelCode' => 'required|string',
            'bookingId' => 'required|string',
        ]);

        if ($validator->fails()) {
            $response['validation'] = $validator->errors();
            $response['warning'] = 'Validation failed';
            return response()->json($response, 200); // still return success because API hit
        }

        // ✅ 2. Company info
        $cmcode = $request->hotelCode;
        $companyinfo = componyinfo::where('componyinfo_af3', $cmcode)->first();

        if (!$companyinfo) {
            $response['warning'] = 'Hotel code not found';
            return response()->json($response, 200);
        }

        $firm_id = $companyinfo->firm_id;

        // ✅ 3. Business source
        $businessSource = businesssource::where('firm_id', $firm_id)
            ->where('business_source_name', $request->channel)
            ->first();

        if (!$businessSource) {
            $businessSource = businesssource::where('firm_id', $firm_id)
                ->where('business_source_name', 'Direct')
                ->first();
        }

        if (!$businessSource) {
            $response['warning'] = 'Business source not found';
            return response()->json($response, 200);
        }

        $business_source_id = $businessSource->id;

        // ✅ 4. Room
        $room = room::where('firm_id', $firm_id)
            ->where('room_no', 'ONLINE_BOOKING')
            ->first();

        if (!$room) {
            $response['warning'] = 'Room ONLINE_BOOKING not found';
            return response()->json($response, 200);
        }

        // ✅ 5. Guest setup
        $guestPhone = $request->input('guest.phone');
        if (empty($guestPhone)) {
            $guestPhone = preg_replace('/\D/', '', $request->bookingId);
            if (empty($guestPhone)) {
                $guestPhone = date('Ymd') . rand(1000, 9999);
            }
        }

        $guestEmail = $request->input('guest.email', Str::random(8) . '@example.com');
        $guestFName = $request->input('guest.firstName', Str::random(5));
        $guestLName = $request->input('guest.lastName', Str::random(5));

        $guest = Account::where('mobile', $guestPhone)->first();
        if (!$guest) {
            $guest = new Account();
            $guest->firm_id      = $firm_id;
            $guest->account_name = $guestFName . ' ' . $guestLName;
            $guest->mobile       = $guestPhone;
            $guest->email        = $guestEmail;
            $guest->address      = $request->guest['address']['line1'] ?? '';
            $guest->city         = $request->guest['address']['city'] ?? '';
            $guest->state        = $request->guest['address']['state'] ?? '';
            $guest->pincode      = $request->guest['address']['zipCode'] ?? '';
            $guest->nationality  = $request->guest['address']['country'] ?? '';
            $group = AccountGroup::where('account_group_name', 'Guest Customer')->first();
            if ($group) {
                $guest->account_group_id = $group->id;
            }
            $guest->save();
        }

        // ✅ 6. Room Booking store
        if (!empty($request->rooms)) {
            foreach ($request->rooms as $roomData) {
                $package = package::where('firm_id', $firm_id)
                    ->where('package_name', $roomData['rateplanCode'])
                    ->first();

                if (!$package) {
                    $package = package::where('firm_id', $firm_id)
                        ->where('package_name', 'General')
                        ->first();
                }

                if (!$package) {
                    $response['warning'] = 'Package not found for ' . ($roomData['rateplanCode'] ?? '');
                    return response()->json($response, 200);
                }

                $booking = new RoomBooking();
                $booking->firm_id         = $firm_id;
                $booking->booking_no      = $request->bookingId;
                $booking->voucher_no      = $request->bookingId;
                $booking->booking_date    = Carbon::parse($request->bookedOn ?? now())->format('Y-m-d');
                $booking->checkin_date    = Carbon::parse($request->checkin ?? now())->format('Y-m-d');
                $booking->checkout_date   = Carbon::parse($request->checkout ?? now()->addDay())->format('Y-m-d');
                $booking->guest_name      = $roomData['guestName'] ?? $guestFName . ' ' . $guestLName;
                $booking->guest_mobile    = $guestPhone;
                $booking->guest_email     = $guestEmail;
                $booking->room_tariff_perday = $roomData['prices'][0]['sellRate'] ?? 0;
                $booking->no_of_guest     = ($roomData['occupancy']['adults'] ?? 1) + ($roomData['occupancy']['children'] ?? 0);
                $booking->bookingaf3      = $request->specialRequests ?? null;
                $booking->business_source_id = $business_source_id;
                $booking->package_id      = $package->id;
                $booking->room_id         = $room->id;
                $booking->room_no         = $room->room_no;
                $booking->save();
            }
        } else {
            $response['warning'] = 'No room data found';
        }

        // ✅ Always return success message even if something missing
        $response['message'] .= ' and Booking process attempted';
        return response()->json($response, 200);

    } catch (\Exception $e) {
        // ❌ Log but still return API Hit Success
        \Log::error('❌ API ERROR in store_roombookiking_api', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        $response['warning'] = 'Exception occurred';
        $response['error'] = $e->getMessage();
        return response()->json($response, 200);
    }
}


}


