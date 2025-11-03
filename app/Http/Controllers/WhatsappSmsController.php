<?php

namespace App\Http\Controllers;

use auth;
use App\Models\account;
use App\Models\WhatsappSms;
use App\Models\voucher_type;
use Illuminate\Http\Request;
use App\Models\softwarecompany;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreWhatsappSmsRequest;
use App\Http\Requests\UpdateWhatsappSmsRequest;


class WhatsappSmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index22()
    {
        
$firm_id = Auth::user()->firm_id;

$WhatsappSms = WhatsappSms::where('firm_id', $firm_id)
 
    ->get();


if (count($WhatsappSms)<1) {
    WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Check_out_store',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "Dear Sir/Madam,\n\nThank you for choosing to stay with us at *{firm_name}*. We hope you had a pleasant experience.\n\n*Details*\nRoom No: {room_no}\nBill No: {voucher_no}\nCheckout Date: {checkout_date}\nBill Amount: ₹{total_billamount}\n\nWe appreciate your patronage and look forward to welcoming you again.\n\nFor your next reservation, feel free to reach out to us.\n\n*{firm_name}*\nAddress: {address1}, {address2}, {city}, {pincode}, {state}\nEmail: {email}\nWebsite: {website}\nBooking Link: www.datahouseerp.com/{firm_id}\nReception: {phone}, {mobile}\n\nWishing you safe travels and a wonderful day ahead.\n\nWarm regards,\n*Team {firm_name}*"
    ]);

     WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Check_out_delete',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "Dear Owner, This is to inform you that a guest bill has been deleted at *{firm_name}*. *Details* Room No: {room_no} Bill No: {voucher_no} Guest Name:{guest_name} Checkout Date: {checkout_date} Delete Bill Amount: ₹{total_billamount} Oprater Name : {name} Please ensure all *Deleted* Record"
    ]);
         WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Check_out_update',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "Dear Owner, This is to inform you that a guest bill has been updated at *{firm_name}*. *Details* Room No: {room_no} Bill No: {voucher_no} Checkout Date: {checkout_date} Updated Bill Amount: ₹{total_billamount} Guest has been successfully checked out. Please ensure all records are updated"
    ]);

            WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Check_In_store',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "Dear Sir/Madam, Welcome to *{firm_name}*! We are delighted to have you with us and hope you enjoy a comfortable and pleasant stay. *Check-in Details* Room No: {room_no} Bill No: {voucher_no} Check-in Date: {checkin_date} Should you need any assistance during your stay, please feel free to contact our reception at any time. *{firm_name}* Address: {address1}, {address2}, {city}, {pincode}, {state} Email: {email} Website: {website} Reception: {phone}, {mobile} Thank you for choosing us. We wish you a wonderful stay! Warm regards, *Team {firm_name}*"
    ]);

                WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Check_In_delete',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "Dear Owner, This is to inform you that a guest bill has been deleted at *{firm_name}*. *Details* Room No: {room_no} Bill No: {check_in_no} Checkin Date: {checkin_date} Guest Name:{guest_name} Room Tariff:{room_tariff_perday} Oprater Name : {name} Please ensure all Deleted Record"
    ]);
         WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Check_In_update',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "Dear Owner, This is to inform you that a guest bill has been Updated at *{firm_name}*. *New Details* Room No: {room_no} Bill No: {check_in_no} Checkin Date: {checkin_date} Guest Name:{guest_name} Room Tariff:{room_tariff_perday} Oprater Name : {name} Please ensure all *Updated* Record"
    ]);

             WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Room_booking_store',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "Dear Sir/Madam,

Thank you for choosing *{firm_name}* for your stay. We are delighted to confirm your booking and look forward to welcoming you.

*Booking Details*
Room No: {room_no}
Room  Type: {room_type}
Booking No: {booking_no}
Booking Date: {booking_date}
Checkin Date:{checkin_date}
Chekin Time:{check_in_time}
Checkout Date:{checkout_date}
Chekin Time:{check_out_time}
No Of Days:{commited_days}
RoomTariff Per Day :{room_tariff_perday}
Booking Amount:{booking_amount}
Payment Ref No :{refrance_no}
Payment Remark :{voucher_payment_remark}
Booking Agent:{agent}
Booking Officer:{name}


Your comfort is our priority, and we assure you of our best services during your stay.

For any assistance or special requests, please feel free to contact us.

*{firm_name}*
Address: {address1}, {address2}, {city}, {pincode}, {state}
Email: {email}
Website: {website}
Booking Link: www.datahouseerp.com/{firm_id}
Reception: {phone}, {mobile}

Thank you once again for choosing us. We wish you a pleasant stay.

Warm regards,  
*Team {firm_name}*"
    ]);


                 WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Room_booking_update',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "Dear {guest_name}, Your room booking at {firm_name} has been updated. Please review the updated details below: Booking Details Booking No: {booking_no} Voucher No: {voucher_no} Booking Date: {booking_date} Check-in Date: {checkin_date} Check-out Date: {checkout_date} Room No: {room_no} Room Type: {room_type} Committed Days: {commited_days} No. of Guests: {no_of_guest} Total Amount: ₹{total_amount} Booking Amount: ₹{booking_amount} Payment Remark: {voucher_payment_remark} If you have any questions or require assistance, please contact us at any time. {firm_name} Address: {address1}, {address2}, {city} – {pincode}, {state} Email: {email} Website: {website} Booking Link: www.datahouseerp.com/{firm_id} Reception: {phone} | {mobile} Warm regards, Team {firm_name}"
    ]);

                     WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Room_booking_delete',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "Dear {guest_name}, We regret to inform you that your room booking at {firm_name} has been canceled. Please find the booking details below: Booking Details Booking No: {booking_no} Voucher No: {voucher_no} Booking Date: {booking_date} Check-in Date: {checkin_date} Check-out Date: {checkout_date} Room No: {room_no} Room Type: {room_type} Committed Days: {commited_days} No. of Guests: {no_of_guest} Total Amount: ₹{total_amount} If you have already made a payment, it will be refunded as per our policy. For any assistance, please contact us anytime. {firm_name} Address: {address1}, {address2}, {city} – {pincode}, {state} Email: {email} Website: {website} Booking Link: www.datahouseerp.com/{firm_id} Reception: {phone} | {mobile} Warm regards, Team {firm_name}"
    ]);
                         WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Restaurant_food_bill_update',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "RESTAURANT FOOD BILL UPDATED ALERT ──────────────────────── Dear Sir, A restaurant food bill from {firm_name} has been updated. Please review the updated details below: Updated Restaurant Food Bill Details Bill No: {voucher_no} Date: {bill_date} Customer Name: {customer_name} Total Items: {total_item} Total Quantity: {total_qty} Updated Bill Amount: ₹{total_billamount} This bill was modified in the system. Please verify this action to ensure it was authorized. For any queries or audit review, contact your system administrator. ──────────────────────── {firm_name} {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Reception: {phone} | {mobile} Order Online: www.datahouseerp.com/{firm_id} Warm regards, Team {firm_name}	"
    ]);
                         WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Restaurant_food_bill_delete',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "RESTAURANT FOOD BILL DELETED ALERT ──────────────────────── Dear Sir, A restaurant food bill from {firm_name} has been deleted. Please review the details below: Restaurant Food Bill Details Bill No: {voucher_no} Date: {bill_date} Customer Name: {customer_name} Total Items: {total_item} Total Quantity: {total_qty} Bill Amount: ₹{total_billamount} This bill was deleted from the system. Please verify this action to ensure it was authorized. For any queries or audit review, contact your system administrator. ──────────────────────── {firm_name} {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Reception: {phone} | {mobile} Order Online: www.datahouseerp.com/{firm_id} Warm regards, Team {firm_name}"
    ]);
                            WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Restaurant_food_bill_store',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "*Dear {customer_name}* Thank you for dining with us at *{firm_name}*! We hope you had a delightful experience. *Food Bill Details* ──────────────────────── Bill No: *{voucher_no}* Date: *{bill_date}* Total Items: *{total_item}* Total Quantity: *{total_qty}* Bill Amount: *₹{total_billamount}* ──────────────────────── We sincerely appreciate your visit and look forward to serving you again soon. For any feedback or future orders, feel free to contact us anytime. *{firm_name}* {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Order Online: www.datahouseerp.com/{firm_id} Reception: {phone} | {mobile} Warm regards, *Team {firm_name}*"
    ]);
                            WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Foodbill_update',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "FOOD BILL UPDATED ALERT ──────────────────────── Dear Sir, A food bill from {firm_name} has been updated. Please review the updated details below: Updated Food Bill Details Bill No: {voucher_no} Date: {bill_date} Customer Name: {customer_name} Total Items: {total_item} Total Quantity: {total_qty} Updated Bill Amount: ₹{total_billamount} This bill was modified in the system. Please verify this action to ensure it was authorized. For any queries or audit review, contact your system administrator. ──────────────────────── {firm_name} {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Reception: {phone} | {mobile} Order Online: www.datahouseerp.com/{firm_id} Warm regards, Team {firm_name}"
    ]);
                     WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Foodbill_delete',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "FOOD BILL DELETED ALERT Dear Sir, A food bill from {firm_name} has been deleted. Please review the details below: ********************************* Food Bill Details Bill No: {voucher_no} Date: {bill_date} Customer Name: {customer_name} Total Items: {total_item} Total Quantity: {total_qty} Bill Amount: ₹{total_billamount} ********************************** This bill was deleted from the system. Please verify this action to ensure it was authorized. For any queries or audit review, contact your system administrator. ──────────────────────── {firm_name} {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Reception: {phone} | {mobile} Order Online: www.datahouseerp.com/{firm_id} Warm regards, Team {firm_name}"
    ]);
                     WhatsappSms::create([
        'firm_id' => $firm_id,
        'transection_type' => 'Foodbill_store',
        'wp_active'=>'1',
        'sms_active'=>'0',
        'wp_message' => "*Dear {customer_name}* Thank you for dining with us at *{firm_name}*! We hope you had a delightful experience. *Food Bill Details* ──────────────────────── Bill No: *{voucher_no}* Date: *{bill_date}* Total Items: *{total_item}* Total Quantity: *{total_qty}* Bill Amount: *₹{total_billamount}* ──────────────────────── We sincerely appreciate your visit and look forward to serving you again soon. For any feedback or future orders, feel free to contact us anytime. *{firm_name}* {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Order Online: www.datahouseerp.com/{firm_id} Reception: {phone} | {mobile} Warm regards, *Team {firm_name}*"
    ]);





   return ("Default WhatsApp message inserted. reload page ");
} else {
   return view ('setting.whatsappsms.whatsappsms_index',compact('WhatsappSms'));
}




    }
    public function index()
{
    $firm_id = Auth::user()->firm_id;

    // Define all required default transaction types and messages
    $defaults = [
        'Check_out_delete' => "Dear Owner, This is to inform you that a guest bill has been deleted at *{firm_name}*. *Details* Room No: {room_no} Bill No: {voucher_no} Guest Name:{guest_name} Checkout Date: {checkout_date} Delete Bill Amount: ₹{total_billamount} Oprater Name : {name} Please ensure all *Deleted* Record",

        'Check_out_update' => "Dear Owner, This is to inform you that a guest bill has been updated at *{firm_name}*. *Details* Room No: {room_no} Bill No: {voucher_no} Checkout Date: {checkout_date} Updated Bill Amount: ₹{total_billamount} Guest has been successfully checked out. Please ensure all records are updated",

        'Check_In_store' => "Dear Sir/Madam, Welcome to *{firm_name}*! We are delighted to have you with us and hope you enjoy a comfortable and pleasant stay. *Check-in Details* Room No: {room_no} Bill No: {voucher_no} Check-in Date: {checkin_date} Should you need any assistance during your stay, please feel free to contact our reception at any time. *{firm_name}* Address: {address1}, {address2}, {city}, {pincode}, {state} Email: {email} Website: {website} Reception: {phone}, {mobile} Thank you for choosing us. We wish you a wonderful stay! Warm regards, *Team {firm_name}*",

        'Check_In_delete' => "Dear Owner, This is to inform you that a guest bill has been deleted at *{firm_name}*. *Details* Room No: {room_no} Bill No: {check_in_no} Checkin Date: {checkin_date} Guest Name:{guest_name} Room Tariff:{room_tariff_perday} Oprater Name : {name} Please ensure all Deleted Record",
        
        'Check_In_update' => "Dear Owner, This is to inform you that a guest bill has been Updated at *{firm_name}*. *New Details* Room No: {room_no} Bill No: {check_in_no} Checkin Date: {checkin_date} Guest Name:{guest_name} Room Tariff:{room_tariff_perday} Oprater Name : {name} Please ensure all *Updated* Record",

        'Foodbill_store' => "**Dear {customer_name}* Thank you for dining with us at *{firm_name}*! We hope you had a delightful experience. *Food Bill Details* ──────────────────────── Bill No: *{voucher_no}* Date: *{bill_date}* Total Items: *{total_item}* Total Quantity: *{total_qty}* Bill Amount: *₹{total_billamount}* ──────────────────────── We sincerely appreciate your visit and look forward to serving you again soon. For any feedback or future orders, feel free to contact us anytime. *{firm_name}* {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Order Online: www.datahouseerp.com/{firm_id} Reception: {phone} | {mobile} Warm regards, *Team {firm_name}*",

        'Foodbill_delete' => "FOOD BILL DELETED ALERT Dear Sir, A food bill from {firm_name} has been deleted. Please review the details below: ********************************* Food Bill Details Bill No: {voucher_no} Date: {bill_date} Customer Name: {customer_name} Total Items: {total_item} Total Quantity: {total_qty} Bill Amount: ₹{total_billamount} ********************************** This bill was deleted from the system. Please verify this action to ensure it was authorized. For any queries or audit review, contact your system administrator. ──────────────────────── {firm_name} {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Reception: {phone} | {mobile} Order Online: www.datahouseerp.com/{firm_id} Warm regards, Team {firm_name}",

        'Foodbill_update' => "*FOOD BILL UPDATED ALERT ──────────────────────── Dear Sir, A food bill from {firm_name} has been updated. Please review the updated details below: Updated Food Bill Details Bill No: {voucher_no} Date: {bill_date} Customer Name: {customer_name} Total Items: {total_item} Total Quantity: {total_qty} Updated Bill Amount: ₹{total_billamount} This bill was modified in the system. Please verify this action to ensure it was authorized. For any queries or audit review, contact your system administrator. ──────────────────────── {firm_name} {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Reception: {phone} | {mobile} Order Online: www.datahouseerp.com/{firm_id} Warm regards, Team {firm_name}",

       'Restaurant_food_bill_store' => "*Dear {customer_name}* Thank you for dining with us at *{firm_name}*! We hope you had a delightful experience. *Food Bill Details* ──────────────────────── Bill No: *{voucher_no}* Date: *{bill_date}* Total Items: *{total_item}* Total Quantity: *{total_qty}* Bill Amount: *₹{total_billamount}* ──────────────────────── We sincerely appreciate your visit and look forward to serving you again soon. For any feedback or future orders, feel free to contact us anytime. *{firm_name}* {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Order Online: www.datahouseerp.com/{firm_id} Reception: {phone} | {mobile} Warm regards, *Team {firm_name}*	",

       'Restaurant_food_bill_delete' => "RESTAURANT FOOD BILL DELETED ALERT ──────────────────────── Dear Sir, A restaurant food bill from {firm_name} has been deleted. Please review the details below: Restaurant Food Bill Details Bill No: {voucher_no} Date: {bill_date} Customer Name: {customer_name} Total Items: {total_item} Total Quantity: {total_qty} Bill Amount: ₹{total_billamount} This bill was deleted from the system. Please verify this action to ensure it was authorized. For any queries or audit review, contact your system administrator. ──────────────────────── {firm_name} {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Reception: {phone} | {mobile} Order Online: www.datahouseerp.com/{firm_id} Warm regards, Team {firm_name}",

       'Restaurant_food_bill_update' => "RESTAURANT FOOD BILL UPDATED ALERT ──────────────────────── Dear Sir, A restaurant food bill from {firm_name} has been updated. Please review the updated details below: Updated Restaurant Food Bill Details Bill No: {voucher_no} Date: {bill_date} Customer Name: {customer_name} Total Items: {total_item} Total Quantity: {total_qty} Updated Bill Amount: ₹{total_billamount} This bill was modified in the system. Please verify this action to ensure it was authorized. For any queries or audit review, contact your system administrator. ──────────────────────── {firm_name} {address1}, {address2}, {city} – {pincode}, {state} {email} {website} Reception: {phone} | {mobile} Order Online: www.datahouseerp.com/{firm_id} Warm regards, Team {firm_name}",

       'Room_booking_store' => "Dear {guest_name}, Thank you for choosing {firm_name} for your stay. We’re pleased to acknowledge your room booking. Important: Please complete your payment and confirm your booking via telephone. Only after confirmation, your booking will be considered confirmed. Otherwise, it will be treated as unconfirmed. Booking Details Booking No: {booking_no} Booking Date: {booking_date} Reference No: {refrance_no} Agent: {agent} Stay Information Room No: {room_no} Room Type: {room_type} Check-in Date: {checkin_date} at {check_in_time} Check-out Date: {checkout_date} at {check_out_time} Committed Days: {commited_days} No. of Guests: {no_of_guest} Tariff Details Room Tariff (Per Day): ₹{room_tariff_perday} Total Amount: ₹{total_amount} Booking Amount: ₹{booking_amount} Payment Remark: {voucher_payment_remark} We look forward to providing you with a comfortable and memorable stay. For any assistance or special requests, feel free to contact us anytime. {firm_name} Address: {address1}, {address2}, {city} – {pincode}, {state} Email: {email} Website: {website} Booking Link: www.datahouseerp.com/{firm_id} Reception: {phone} | {mobile} Warm regards, Team {firm_name}",

              'Room_booking_delete' => "Dear {guest_name}, We regret to inform you that your room booking at {firm_name} has been canceled. Please find the booking details below: Booking Details Booking No: {booking_no} Voucher No: {voucher_no} Booking Date: {booking_date} Check-in Date: {checkin_date} Check-out Date: {checkout_date} Room No: {room_no} Room Type: {room_type} Committed Days: {commited_days} No. of Guests: {no_of_guest} Total Amount: ₹{total_amount} If you have already made a payment, it will be refunded as per our policy. For any assistance, please contact us anytime. {firm_name} Address: {address1}, {address2}, {city} – {pincode}, {state} Email: {email} Website: {website} Booking Link: www.datahouseerp.com/{firm_id} Reception: {phone} | {mobile} Warm regards, Team {firm_name}",

             'Room_booking_update' => "Dear {guest_name}, Your room booking at {firm_name} has been updated. Please review the updated details below: Booking Details Booking No: {booking_no} Voucher No: {voucher_no} Booking Date: {booking_date} Check-in Date: {checkin_date} Check-out Date: {checkout_date} Room No: {room_no} Room Type: {room_type} Committed Days: {commited_days} No. of Guests: {no_of_guest} Total Amount: ₹{total_amount} Booking Amount: ₹{booking_amount} Payment Remark: {voucher_payment_remark} If you have any questions or require assistance, please contact us at any time. {firm_name} Address: {address1}, {address2}, {city} – {pincode}, {state} Email: {email} Website: {website} Booking Link: www.datahouseerp.com/{firm_id} Reception: {phone} | {mobile} Warm regards, Team {firm_name}",


        
        // 🔽 You can add all other transection types here...
    ];

    // Loop through each default type
    foreach ($defaults as $type => $message) {
        $exists = WhatsappSms::where('firm_id', $firm_id)
            ->where('transection_type', $type)
            ->exists();

        // If this transection_type doesn’t exist, create it
        if (!$exists) {
            WhatsappSms::create([
                'firm_id' => $firm_id,
                'transection_type' => $type,
                'wp_active' => '1',
                'sms_active' => '0',
                'wp_message' => $message,
            ]);
        }
    }

    // Finally, load all records
    $WhatsappSms = WhatsappSms::where('firm_id', $firm_id)->get();

    return view('setting.whatsappsms.whatsappsms_index', compact('WhatsappSms'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

                $voucher_type=voucher_type::where('firm_id',Auth::user()->firm_id)->get();
           return view ('setting.whatsappsms.whatsappsms_create',compact('voucher_type')); 

           
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'transection_type' => 'required',
        'wp_message' => 'required|string',
        'wp_active' => 'nullable|boolean',
    ]);

    $whatsappSms = new WhatsappSms();
    $whatsappSms->firm_id=Auth::user()->firm_id;
    $whatsappSms->transection_type = $validated['transection_type'];
    $whatsappSms->wp_message = $validated['wp_message'];
    $whatsappSms->wp_active = $request->has('wp_active') ? 1 : 0;
    $whatsappSms->save();

    return redirect()->back()->with('message', 'WhatsApp message saved successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(WhatsappSms $whatsappSms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $WhatsappSms = WhatsappSms::where('firm_id',Auth::user()->firm_id)->where('id',$id)->first();
 
        return view ('setting.whatsappsms.whatsappsms_edit',compact('WhatsappSms')); 
 
    }


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{

    // // Validate input
    $request->validate([
        'wp_message' => 'required',
    ]);

    // Find the record
    $whatsappSms = WhatsappSms::findOrFail($id);

    // Update the fields
    $whatsappSms->transection_type = $request->transection_type;
    $whatsappSms->wp_active = $request->wp_active;
    $whatsappSms->wp_message = $request->wp_message;

    // Save the changes
    $whatsappSms->save();



    // Redirect back with a success message

        return redirect()->route('whatsapp_sms.index')->with('message', 'Record updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $WhatsappSms = WhatsappSms::where('firm_id',Auth::user()->firm_id)->find($id);

        // Check if the package exists
        if ($WhatsappSms) {
            // Delete the package
            $WhatsappSms->delete();
            return redirect('/whatsapp_sms')->with('message', 'Record Delete successfully!');
        } else {
            // Record not found
            return redirect('/whatsapp_sms')->with('message', 'Record Not Found');

        }
    }

    public function send_promotional_whatsapp(){
        //show the form user can enter number and message 
      return view ('setting.whatsappsms.whatsappsms_promotional'); 
    }

public function start_wp_promotionbyform(Request $request)
{
    $request->validate([
        'mobile_numbers' => 'required|string',
        'message' => 'required|string',
    ]);
    

    $firmId = Auth::user()->firm_id;

    $software = softwarecompany::where('firm_id', $firmId)->first();
    if (!$software || empty($software->software_af4) || strtolower($software->software_af4) === 'af') {
        return back()->with('message', 'WhatsApp sending not configured or disabled.');
    }

    $authKey = $software->software_af4;
    $apiUrl = $software->software_af5;

    $mobiles = explode(',', str_replace(["\r", "\n", " "], '', $request->mobile_numbers));
    $message = $request->message;

    $successCount = 0;
    $failCount = 0;

    foreach ($mobiles as $mobile) {
        if (preg_match('/^\d{10}$/', $mobile)) {
            try {
                $response = Http::get($apiUrl, [
                    'authentic-key' => $authKey,
                    'route' => 1,
                    'number' => $mobile,
                    'message' => $message,
                ]);

                if ($response->successful()) {
                    $successCount++;
                } else {
                    $failCount++;
                }
            } catch (\Exception $e) {
                $failCount++;
            }
        } else {
            $failCount++;
        }
    }

    return back()->with('message', "$successCount messages sent successfully. $failCount failed.");
}

public function start_wp_promotion(Request $request)
{
    $validator = Validator::make($request->all(), [
        'mobile_numbers' => 'required|string',
        'message' => 'required|string',
    ]);


    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'message' => 'Invalid input',
            'errors' => $validator->errors()
        ]);
    }

    $firmId = Auth::user()->firm_id;
    $software = softwarecompany::where('firm_id', $firmId)->first();

    if (!$software || empty($software->software_af4) || strtolower($software->software_af4) === 'af') {
        return response()->json(['status' => 400, 'message' => 'WhatsApp not configured.']);
    }

    $authKey = $software->software_af4;
    $apiUrl = $software->software_af5;

    $mobile = trim($request->mobile_numbers);
    $message = $request->message;
    $fileurl=$request->file_url;
    $filename=$request->filename;




    if (!preg_match('/^\d{10}$/', $mobile)) {
        return response()->json(['status' => 400, 'message' => 'Invalid mobile number']);
    }

    if (empty($filename)){

            try {
        $response = Http::get($apiUrl, [
            'authentic-key' => $authKey,
            'route' => 1,
            'number' => $mobile,
            'message' => $message,
    
        ]);

        if ($response->successful()) {
                    return response()->json(['status' => 200, 'message' => 'Sent successfully'.$fileurl.'and file name is '.$filename]);
        } else {
            return response()->json(['status' => 500, 'message' => 'Failed to send']);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => 500, 'message' => 'Exception: ' . $e->getMessage()]);
    }
        
    }else {
    try {
        
        
        $response = Http::get($apiUrl, [
            'authentic-key' => $authKey,
            'route' => 1,
            'number' => $mobile,
            'message' => $message,
            'fileurl' => $fileurl,
            
        ]);

       if ($response->successful()) {
    // Build the full URL for debugging/logging
    $hitUrl = $apiUrl . '?' . http_build_query([
        'authentic-key' => $authKey,
        'route' => 1,
        'number' => $mobile,
        'message' => $message,
        'fileurl' => $fileurl,

    ]);

    return response()->json([
        'status' => 200,
        'message' => 'Sent successfully with file',
        'fileurl' => $fileurl,
        'filename' => $filename,
        'hit_api' => $hitUrl,
    ]);
}
 else {
            return response()->json(['status' => 500, 'message' => 'Failed to send with file']);
        }

    } catch (\Exception $e) {
        return response()->json([
            'status' => 500,
            'message' => 'Exception: ' . $e->getMessage()
        ]);
    }
}

    



}
// if not already included

public function getGuestMobileNumbers()
{
    $firmId = auth()->user()->firm_id;

    // Fetch distinct mobile numbers for the user's firm, 10-digit only
    $mobiles = account::where('firm_id', $firmId)
        ->whereNotNull('mobile')
        ->pluck('mobile')
        ->filter(function ($mobile) {
            return preg_match('/^\d{10}$/', $mobile);
        })
        ->unique()
        ->values();

    return response()->json([
        'status' => 200,
        'mobiles' => $mobiles,
    ]);
}

public function upload(Request $request)
{
    if ($request->hasFile('upload_image')) {
        $user = Auth::user();
        $firmId = $user->firm_id;
        $file = $request->file('upload_image');

        $originalName = $file->getClientOriginalName();
        $filename = $firmId . '_' . time() . '_' . $originalName;

        // Delete all existing images with this firm_id prefix
        $files = Storage::files('public/image');
        foreach ($files as $oldFile) {
            if (str_contains($oldFile, "image/{$firmId}_")) {
                Storage::delete($oldFile);
            }
        }

        // Save new file
        $path = $file->storeAs('public/image', $filename);
        $url = url("storage/app/public/image/" . $filename);

        return response()->json([
            'status' => 200,
            'file_url' => $url,
            'filename' => $filename,
        ]);
    }

    return response()->json(['status' => 400, 'message' => 'No file uploaded']);
}



}

