<?php

namespace App\Http\Controllers;
use App\Models\kot;
use App\Models\item;
use App\Models\room;
use App\Models\User;
use App\Models\ledger;
use App\Models\account;
use App\Models\voucher;
use App\Models\foodbill;
use App\Models\roomtype;
use App\Models\gstmaster;
use App\Models\inventory;
use App\Models\roombooking;
use App\Models\roomcheckin;
use App\Models\accountgroup;
use App\Models\roomcheckout;
use Illuminate\Http\Request;
use App\Models\businesssource;
use App\Models\softwarecompany;
use App\Models\super_comp_list;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Storesuper_comp_listRequest;
use App\Http\Requests\Updatesuper_comp_listRequest;

class SuperCompListController extends Controller
{
    public function index()
    {
        // $record = super_comp_list::orderBy('created_at', 'desc')->get();
      


        $record = \DB::table('super_comp_lists as s')
    ->leftJoin('roomcheckouts as r', 's.firm_id', '=', 'r.firm_id')
    ->select(
        's.*',
        \DB::raw('COUNT(r.id) as total_roomcheckouts')
    )
    ->groupBy(
        's.id', 's.firm_id', 's.firm_name', 's.firm_mobile', 's.firm_dealer',
        's.activation_date', 's.expiry_date', 's.billing_amt', 
        's.created_at', 's.updated_at','s.comp_af1','s.comp_af2','s.comp_af3','s.comp_af4','s.comp_af5','s.comp_af6','s.comp_af7','s.comp_af8' // include all fields from super_comp_lists table
    )
    ->orderBy('s.created_at', 'desc')
    ->get();

        return view('super.supercom', ['data' => $record]);


    }

    public function softwarecomapny_show($firm_id)
    {
        $software_companyInfo = softwarecompany::where('firm_id',$firm_id)->first();
    
      
        return view('setting.software_company_form_firmid', ['software_companyInfo' => $software_companyInfo,'firm_id'=>$firm_id]);

    }

    public function store_softwarecompny_firmid(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'software_firm_name' => 'required',
            'customer_firm_name' => 'required',
            'firm_id'=>'required',
        ]);
    
        if ($validator->passes()) 
        {
            $software_companyInfo = softwarecompany::where('firm_id',$request->firm_id)->first();
    
    
            $software_companyInfo->activation_date = $request->activation_date;
            $software_companyInfo->expiry_date = $request->expiry_date;
            $software_companyInfo->customer_firm_name = $request->customer_firm_name;
            $software_companyInfo->customer_mobile = $request->customer_mobile;
            $software_companyInfo->customer_phone = $request->customer_phone;
            $software_companyInfo->software_firm_name = $request->software_firm_name;
            $software_companyInfo->software_address1 = $request->software_address1;
            $software_companyInfo->software_address2 = $request->software_address2;
            $software_companyInfo->software_city = $request->software_city;
            $software_companyInfo->software_pincode = $request->software_pincode;
            $software_companyInfo->software_state = $request->software_state;
            $software_companyInfo->software_phone = $request->software_phone;
            $software_companyInfo->software_mobile = $request->software_mobile;
            $software_companyInfo->software_email = $request->software_email;
            $software_companyInfo->software_website = $request->software_website;
            $software_companyInfo->software_facebook = $request->software_facebook;
            $software_companyInfo->software_youtube = $request->software_youtube;
            $software_companyInfo->software_twitter = $request->software_twitter;
            $software_companyInfo->software_logo1 = $request->software_logo1;
            $software_companyInfo->software_logo2 = $request->software_logo2;
            $software_companyInfo->software_logo3 = $request->software_logo3;
            $software_companyInfo->software_logo4 = $request->software_logo4;
            $software_companyInfo->software_af1 = $request->software_af1;
            $software_companyInfo->software_af2 = $request->software_af2;
            $software_companyInfo->software_af3 = $request->software_af3;
            $software_companyInfo->software_af4 = $request->software_af4;
            $software_companyInfo->software_af5 = $request->software_af5;
            $software_companyInfo->software_af6 = $request->software_af6;
            $software_companyInfo->software_af7 = $request->software_af7;
            $software_companyInfo->software_af8 = $request->software_af8;
            $software_companyInfo->software_af9 = $request->software_af9;
            $software_companyInfo->software_af10 = $request->software_af10;
    
            $software_companyInfo->update();
    
            return redirect()->back()->with('message', 'Record Updated Successfully!');
        } 
        else {
            return redirect()->back()->withInput()->withErrors($validator)->with('message', 'Record Not Updated!');
        }
    }
    
    public function seed($firm_id)
    {
        return view('super.supercom_seed', ['firm_id' => $firm_id]);


    }
    public function trandelete($firm_id)
    {
        return view('super.supercom_trandelete', ['firm_id' => $firm_id]);
    }
    public function room_transection_delete($firm_id)
    {

        $roomcheckout_delete = roomcheckout::where('firm_id', $firm_id);

        // Check if records exist before attempting to delete
        if ($roomcheckout_delete->exists()) {
            $roomcheckout_delete->delete();
        }

        $roomcheckin_delete = roomcheckin::where('firm_id', $firm_id);

        if ($roomcheckin_delete->exists()) {
            $roomcheckin_delete->delete();
        }
        $roombooking_delete = roombooking::where('firm_id', $firm_id);
        if ($roombooking_delete->exists()) {
            $roombooking_delete->delete();
        }
        $ledger_delete = Ledger::where('firm_id', $firm_id);

        // Check if the query returns any records
        if ($ledger_delete->exists()) {
            $ledger_delete->delete(); // Directly delete the records
        }

        $foodbill_delete = foodbill::where('firm_id', $firm_id);
        if ($foodbill_delete->exists()) {
            $foodbill_delete->delete();
        }
        $kot_delete = kot::where('firm_id', $firm_id);
        if ($kot_delete->exists()) {
            $kot_delete->delete();
        }


        // Retrieve inventory records for the specific firm_id
        $inventory_delete = inventory::where('firm_id', $firm_id);

        // Assuming you want to delete these only if some other condition (e.g., $roomcheckout_delete) is met:
        if ($inventory_delete->exists()) {
            // Delete the inventory records
            $inventory_delete->delete();
        }
        $voucher_delete = voucher::where('firm_id', $firm_id);

        // Assuming you want to delete these only if some other condition (e.g., $roomcheckout_delete) is met:
        if ($voucher_delete->exists()) {
            // Delete the voucher records
            $voucher_delete->delete();
        }




    }

    public function firm_master_delete($firm_id)
    {



       $accounts = account::where('firm_id', $firm_id)->get();

            // Check if records exist before attempting to delete
            if ($accounts->isNotEmpty()) {
                foreach ($accounts as $account) {
                    // Delete the account_id_pic if it exists
                    if ($account->account_id_pic && Storage::exists('public/account_image/' . $account->account_id_pic)) {
                        Storage::delete('public/account_image/' . $account->account_id_pic);
                    }

                    // Delete the account_pic1 if it exists
                    if ($account->account_pic1 && Storage::exists('public/account_image/' . $account->account_pic1)) {
                        Storage::delete('public/account_image/' . $account->account_pic1);
                    }
                }

                // After deleting images, delete the accounts
                account::where('firm_id', $firm_id)->delete();
            }

            $rooms = room::where('firm_id', $firm_id)->get();

            // Check if records exist before attempting to delete
            if ($rooms->isNotEmpty()) {
                foreach ($rooms as $room) {
                    // Delete the room_image if it exists
                    if ($room->room_image1 && Storage::exists('public/room_image/' . $room->room_image1)) {
                        Storage::delete('public/room_image/' . $room->room_image1);
                    }

                    if ($room->room_image2 && Storage::exists('public/room_image/' . $room->room_image2)) {
                        Storage::delete('public/room_image/' . $room->room_image2);
                    }
                    if ($room->room_image3 && Storage::exists('public/room_image/' . $room->room_image3)) {
                        Storage::delete('public/room_image/' . $room->room_image3);
                    }
                
                }

                // After deleting images, delete the accounts
                room::where('firm_id', $firm_id)->delete();
            }




        $account_delete = account::where('firm_id', $firm_id);

        // Check if records exist before attempting to delete
        if ($account_delete->exists()) {
            $account_delete->delete();
        }
        $item_delete = item::where('firm_id', $firm_id);

        // Check if records exist before attempting to delete
        if ($item_delete->exists()) {
            $item_delete->delete();
        }





        $room_delete = room::where('firm_id', $firm_id);

        // Check if records exist before attempting to delete
        if ($room_delete->exists()) {
            $room_delete->delete();
        }
        $user_delete = user::where('firm_id', $firm_id);
        if ($user_delete->exists()) {
            $user_delete->delete();
        }



    }

    public function firmmaster_foregnkey_delete($firm_id)
    {
        $roomtype_delete = roomtype::where('firm_id', $firm_id);

        // Assuming you want to delete these only if some other condition (e.g., $roomcheckout_delete) is met:
        if ($roomtype_delete->exists()) {
            // Delete the roomtype records
            $roomtype_delete->delete();
        }
        $accountgroup_delete = AccountGroup::where('firm_id', $firm_id)->get();

        // Debugging the query result
        // dd($accountgroup_delete);

        if ($accountgroup_delete->isNotEmpty()) { // Check if the collection is not empty
            foreach ($accountgroup_delete as $group) {
                $group->delete(); // Delete each record individually
            }
        }

        $gstmaster_delete = gstmaster::where('firm_id', $firm_id);

        // Check if records exist before attempting to delete
        if ($gstmaster_delete->exists()) {
            $gstmaster_delete->delete();
        }

        $businesssource_delete = businesssource::where('firm_id', $firm_id);

        // Check if records exist before attempting to delete
        if ($businesssource_delete->exists()) {
            $businesssource_delete->delete();
        }





    }


    public function seedcompinfooters(Request $request)
    {
        DB::table('compinfofooters')->insert([
            [
                'firm_id' => $request->firm_id,  // Corrected assignment
                'bank_name' => '.',
                'bank_ac_no' => '.',
                'bank_ifsc' => '.',
                'upiid' => '.',
                'pay_no' => '.',
                'bank_branch' => '.',
                'voucher_prefix' => '.',
                'voucher_suffix' => '.',
                'voucher_note' => '.',
                'country' => '.',
                'currency' => '.',
                'terms' => '.',
                'ct1' => '1',
                'ct2' => 'Hotel Management ',
                'ct3' => '3',
                'ct4' => '4',
                'ct5' => '5',
                'ct6' => '6',
                'ct7' => '7',
                'ct8' => '8',
                'ct9' => '9',
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Add more entries as needed
        ]);
    }

    public function createUsersAndAssignRoles(Request $request)
    {
        // Create and assign Super Admin role to user
        $superAdminUser = User::firstOrCreate([
            'email' => $request->firm_id.'_superadmin@gmail.com',
        ], [
            'name' => 'Super Admin',
            'firm_id' => $request->firm_id,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
        ]);

        $superAdminUser->assignRole('super-admin');

        // Create and assign Data House user with Super Admin role
        $superAdminUser2 = User::firstOrCreate([
            'email' => $request->firm_id.'_datahouset@gmail.com',
        ], [
            'name' => 'Data House',
            'firm_id' => $request->firm_id,
            'email_verified_at' => now(),
            'password' => Hash::make('India@77'),
        ]);

        $superAdminUser2->assignRole('super-admin');
        $superAdminUser3 = User::firstOrCreate([
            'email' => $request->firm_id . '@gmail.com',
        ], [
            'name' => $request->firm_id,
            'firm_id' => $request->firm_id,
            'email_verified_at' => '2024-11-30 13:13:24',
            'password' => Hash::make('India@77'),
        ]);

        $superAdminUser3->assignRole('super-admin');

        // Create and assign Admin role to user
        $adminUser = User::firstOrCreate([
            'email' => $request->firm_id.'_admin@gmail.com',
        ], [
            'name' => 'Admin',
            'firm_id' => $request->firm_id,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
        ]);

        $adminUser->assignRole('admin');

        // Create and assign Staff role to user
        $staffUser = User::firstOrCreate([
            'email' => $request->firm_id.'_staff@gmail.com',
        ], [
            'name' => 'Staff',
            'firm_id' => $request->firm_id,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
        ]);

        $staffUser->assignRole('staff');
    }
    public function seedcomponyinfos(Request $request)
    {
        DB::table('componyinfos')->insert([
            [
                'firm_id' => $request->firm_id,
                'cominfo_firm_name' => $request->firm_id,
                'cominfo_address1' => '.',
                'cominfo_address2' => '',
                'cominfo_city' => 'DEMO City',
                'cominfo_pincode' => '123456',
                'cominfo_state' => 'DEMO State',
                'cominfo_phone' => '1234567890',
                'cominfo_mobile' => $request->firm_mobile,
                'cominfo_email' => 'info@datahouse.com',
                'cominfo_gst_no' => 'GSTIN123456789',
                'cominfo_pencard' => 'ABCDE1234F',
                'cominfo_field1' => 'Extra Field 1',
                'cominfo_field2' => 'Extra Field 2',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function picseeder(Request $request): void
    {
        DB::table('pics')->insert([
            [
                'firm_id' => $request->firm_id,
                'logo' => 'logo1.png',
                'qrcode' => 'qrcode1.png',
                'seal' => 'seal1.png',
                'signature' => 'signature1.png',
                'brand' => 'Brand A',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
    public function softwarecompanies(Request $request): void
    {
        DB::table('softwarecompanies')->insert([
            [
                'firm_id' => $request->firm_id,
                'activation_date' => now(),
                'expiry_date' => now()->addYear(),
                'customer_firm_name' => $request->firm_name,
                'customer_mobile' => '0',
                'customer_phone' => '0',
                'software_firm_name' => 'Data House ERP',
                'software_address1' => 'Shop No 8 3rrd Floor Good Luck ',
                'software_address2' => 'Apartment Shri Nath Ki taliya ',
                'software_city' => 'Jabalpur',
                'software_pincode' => '482001',
                'software_state' => 'Madhya Pradesh ',
                'software_phone' => '7999663696',
                'software_mobile' => $request->firm_mobile,
                'software_email' => 'datahousejbp@gmail.com',
                'software_website' => 'https://datahouse',
                'software_facebook' => 'https://facebook.com/datahouse',
                'software_youtube' => 'https://youtube.com/datahouse',
                'software_twitter' => 'https://twitter.com/datahouse',
                'software_logo1' => 'https://datahouse.com/logo1.png',
                'software_logo2' => 'https://datahouse.com/logo2.png',
                'software_logo3' => 'https://datahouse.com/logo3.png',
                'software_logo4' => 'https://datahouse.com/logo4.png',
                'software_af1' => 'af',
                'software_af2' => 'af',
                'software_af3' => 'af',
                'software_af4' => 'af',
                'software_af5' => 'https://wapp.powerstext.in/http-tokenkeyapi.php',
                'software_af6' => 'af',
                'software_af7' => 'af',
                'software_af8' => 'af',
                'software_af9' => 'af',
                'software_af10' => 'af',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records as needed
        ]);
    }

    public function vouchertypeSeedr(Request $request): void
    {
        $data = [
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Check_In',
                'numbring_start_from' => 1,
                'voucher_prefix' => 'SR/',
                'voucher_suffix' => '/25-26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Check In',
                'voucher_remark' => 'Check In',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Check_out',
                'numbring_start_from' => 0,
                'voucher_prefix' => 'GSR/',
                'voucher_suffix' => '/25-26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Tax Invoice',
                'voucher_remark' => 'Check Out',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Receipts',
                'numbring_start_from' => 1,
                'voucher_prefix' => 'REC/',
                'voucher_suffix' => '/25-26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Receipts',
                'voucher_remark' => 'Payment Receipts',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Payments',
                'numbring_start_from' => 1,
                'voucher_prefix' => 'PAY/',
                'voucher_suffix' => '/25-26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Payments',
                'voucher_remark' => 'Payments',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Room_booking',
                'numbring_start_from' => 1,
                'voucher_prefix' => 'RM/',
                'voucher_suffix' => '/25-26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Room Booking',
                'voucher_remark' => 'Room Booking',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Kot',
                'numbring_start_from' => 1,
                'voucher_prefix' => 'KOT/',
                'voucher_suffix' => '/25-26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'KOT',
                'voucher_remark' => 'KOT',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Foodbill',
                'numbring_start_from' => 0,
                'voucher_prefix' => 'F/',
                'voucher_suffix' => '/25-26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Food Bill',
                'voucher_remark' => 'Food Bill',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Advance_Receipt',
                'numbring_start_from' => 0,
                'voucher_prefix' => 'AR',
                'voucher_suffix' => '',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Advace Receipt',
                'voucher_remark' => 'Advace Receipt',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Purchase',
                'numbring_start_from' => 0,
                'voucher_prefix' => '',
                'voucher_suffix' => '',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => '',
                'voucher_remark' => '',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Restaurant_food_bill',
                'numbring_start_from' => 0,
                'voucher_prefix' => 'Res/',
                'voucher_suffix' => '/25-26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => '1',
                'voucher_remark' => 'Restaurant Food Bill',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Sale',
                'numbring_start_from' => 1,
                'voucher_prefix' => 'S/',
                'voucher_suffix' => '/25-26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Sale',
                'voucher_remark' => 'Sale',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'Stock_Transfer',
                'numbring_start_from' => 0,
                'voucher_prefix' => 'ST/',
                'voucher_suffix' => '/25-26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'Stock_Transfer',
                'voucher_remark' => 'Stock_Transfer',
            ],
            [
                'firm_id' => $request->firm_id,
                'voucher_type_name' => 'My_Check_out',
                'numbring_start_from' => 0,
                'voucher_prefix' => 'MY/',
                'voucher_suffix' => '/25=26',
                'voucher_numbring_style' => 'voucher_no_continue',
                'voucher_print_name' => 'My Check Out',
                'voucher_remark' => 'My Check Out',
            ],
        ];

        DB::table('voucher_types')->insert($data);

        //
    }

    public function gstmasterseed(Request $request)
    {
        $data = [
            [
                'firm_id' => $request->firm_id,
                'taxname' => 'GST 5%',
                'sgst' => 2.5000,
                'cgst' => 2.5000,
                'igst' => 5.0000,
                'vat' => 0.0000,
                'tax1' => 0.0000,
                'tax2' => 0.0000,
                'tax3' => 0.0000,
                'tax4' => 0.0000,
                'tax5' => 0.0000,
            ],
            [
                'firm_id' => $request->firm_id,
                'taxname' => 'GST 12%',
                'sgst' => 6.0000,
                'cgst' => 6.0000,
                'igst' => 12.0000,
                'vat' => 0.0000,
                'tax1' => 0.0000,
                'tax2' => 0.0000,
                'tax3' => 0.0000,
                'tax4' => 0.0000,
                'tax5' => 0.0000,
            ],
            [
                'firm_id' => $request->firm_id,
                'taxname' => 'GST 18%',
                'sgst' => 9.0000,
                'cgst' => 9.0000,
                'igst' => 18.0000,
                'vat' => 0.0000,
                'tax1' => 0.0000,
                'tax2' => 0.0000,
                'tax3' => 0.0000,
                'tax4' => 0.0000,
                'tax5' => 0.0000,
            ],
            [
                'firm_id' => $request->firm_id,
                'taxname' => 'GST 28%',
                'sgst' => 14.0000,
                'cgst' => 14.0000,
                'igst' => 28.0000,
                'vat' => 0.0000,
                'tax1' => 0.0000,
                'tax2' => 0.0000,
                'tax3' => 0.0000,
                'tax4' => 0.0000,
                'tax5' => 0.0000,
            ],
            [
                'firm_id' => $request->firm_id,
                'taxname' => 'GST 0%',
                'sgst' => 0,
                'cgst' => 0,
                'igst' => 0,
                'vat' => 0,
                'tax1' => 0,
                'tax2' => 0,
                'tax3' => 0,
                'tax4' => 0,
                'tax5' => 0,
            ],
        ];

        DB::table('gstmasters')->insert($data);
    }
    public function tableseeder(Request $request)
    {
        $data = [
            ['firm_id' => $request->firm_id, 'table_name' => '1'],
            ['firm_id' => $request->firm_id, 'table_name' => '2'],
            ['firm_id' => $request->firm_id, 'table_name' => '3'],
            ['firm_id' => $request->firm_id, 'table_name' => '4'],
            ['firm_id' => $request->firm_id, 'table_name' => '5'],
            ['firm_id' => $request->firm_id, 'table_name' => '6'],
            ['firm_id' => $request->firm_id, 'table_name' => '7'],
            ['firm_id' => $request->firm_id, 'table_name' => '8'],
            ['firm_id' => $request->firm_id, 'table_name' => '9'],
            ['firm_id' => $request->firm_id, 'table_name' => '10'],
        ];

        DB::table('tables')->insert($data);
    }

    public function unitseeder(Request $request)
    {
        $data = [
            // Primary unit name, conversion factor, alternate unit name
            ['firm_id' => $request->firm_id, 'primary_unit_name' => 'Pcs', 'conversion' => 1, 'alternate_unit_name' => null],
            ['firm_id' => $request->firm_id, 'primary_unit_name' => 'Plate', 'conversion' => 1, 'alternate_unit_name' => null],
            ['firm_id' => $request->firm_id, 'primary_unit_name' => 'Half', 'conversion' => 1, 'alternate_unit_name' => null],
            ['firm_id' => $request->firm_id, 'primary_unit_name' => 'Cup', 'conversion' => 1, 'alternate_unit_name' => null],
        ];

        DB::table('units')->insert($data);
    }

    public function businesssourcesseed(Request $request)
    {
        $data = [
            ['firm_id' => $request->firm_id, 'business_source_name' => 'OYO', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id' => $request->firm_id, 'business_source_name' => 'Make My Trip', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id' => $request->firm_id, 'business_source_name' => 'Goibibo', 'buiness_source_remark' => 'Online Travel Agency'],
            ['firm_id' => $request->firm_id, 'business_source_name' => 'Direct', 'buiness_source_remark' => 'Direct Booking'],
        ];

        DB::table('businesssources')->insert($data);
        //
    }

    public function godownsseed(Request $request)
    {
        $data = [
            // Primary unit name, conversion factor, alternate unit name
            ['firm_id' => $request->firm_id, 'godown_name' => 'Main Store', 'godown_address' => 'Main Store', 'godown_af1' => '0', 'godown_af2' => '0'],
            ['firm_id' => $request->firm_id, 'godown_name' => 'Kitchen', 'godown_address' => 'Main Store', 'godown_af1' => '0', 'godown_af2' => '0'],
            ['firm_id' => $request->firm_id, 'godown_name' => 'Consume', 'godown_address' => 'Main Store', 'godown_af1' => '0', 'godown_af2' => '0'],
        ];

        DB::table('godowns')->insert($data);
    }
    public function businessseeting(Request $request)
    {
        $data = [
            // Primary unit name, conversion factor, alternate unit name
            ['firm_id' => $request->firm_id, 'calculation_type' => '24hour', 'standard_checkout_time' => '23:59:00'],

        ];

        DB::table('businesssettings')->insert($data);
    }
    public function format_seed(Request $request)
    {
        $data = [
            ['firm_id' => $request->firm_id, 'option_type' => 'Check_out', 'option_name' => 'room_checkout_view2', 'format_name' => 'day wise a4g'],
            ['firm_id' => $request->firm_id, 'option_type' => 'Check_out', 'option_name' => 'room_checkout_view', 'format_name' => 'A4 General Invoice'],
            ['firm_id' => $request->firm_id, 'option_type' => 'Check_out', 'option_name' => 'room_checkout_view3', 'format_name' => 'A4 standard'],
            ['firm_id' => $request->firm_id, 'option_type' => 'Check_out', 'option_name' => 'room_checkout_view4', 'format_name' => 'a5/Half Page Format'],
             ['firm_id' => $request->firm_id, 'option_type' => 'Check_out', 'option_name' => 'room_checkout_view7', 'format_name' => 'Only Room Bill'],
            ['firm_id' => $request->firm_id, 'option_type' => 'Check_out', 'option_name' => 'room_checkout_view8', 'format_name' => 'Only Food Bill'],
            ['firm_id' => $request->firm_id, 'option_type' => 'Room_booking', 'option_name' => 'roombooking_view', 'format_name' => 'A4 Booking  Reciept'],
            ['firm_id' => $request->firm_id, 'option_type' => 'Room_booking', 'option_name' => 'roombooking_print2', 'format_name' => 'Room Booking Without  Room'],
            
        ];
    
        foreach ($data as $item) {
            // Check if the record already exists
            $exists = DB::table('optionlists')
                ->where('firm_id', $item['firm_id'])
                ->where('option_type', $item['option_type'])
                ->where('option_name', $item['option_name'])
                ->exists();
    
            // Insert only if the record does not exist
            if (!$exists) {
                DB::table('optionlists')->insert($item);
            }
        }
    }
    
    public function primarygroupseed(Request $request)
    {
        $data = [
            ['firm_id' => $request->firm_id, 'primary_group_name' => 'Current Assets'],
            ['firm_id' => $request->firm_id, 'primary_group_name' => 'Loans (Liability)'],
            ['firm_id' => $request->firm_id, 'primary_group_name' => 'Current Liabilities'],
            ['firm_id' => $request->firm_id, 'primary_group_name' => 'Revenue Accounts'],
            ['firm_id' => $request->firm_id, 'primary_group_name' => 'Capital Account'],
            ['firm_id' => $request->firm_id, 'primary_group_name' => 'Sundry Debtors'],
            ['firm_id' => $request->firm_id, 'primary_group_name' => 'Sundry Creditors'],
            ['firm_id' => $request->firm_id, 'primary_group_name' => 'Pre-Operative Expenses'],
            ['firm_id' => $request->firm_id, 'primary_group_name' => 'Profit & Loss'],
            ['firm_id' => $request->firm_id, 'primary_group_name' => 'Suspense Account'],

        ];

        DB::table('primarygroups')->insert($data);
    }

    public function accountgroupseed(Request $request)
    {
        $primaryGroups = DB::table('primarygroups')
            ->pluck('id', 'primary_group_name')
            ->toArray();

        // Account groups data
        $accountGroups = [
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Cash In Hand', 'primary_group_name' => 'Current Assets'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Bank Account', 'primary_group_name' => 'Current Assets'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Sundry Debtors', 'primary_group_name' => 'Current Assets'],

            ['firm_id' => $request->firm_id, 'account_group_name' => 'Guest Customer', 'primary_group_name' => 'Sundry Debtors'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Loans & Advances (Asset)', 'primary_group_name' => 'Current Assets'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Securities & Deposits (Asset)', 'primary_group_name' => 'Current Assets'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Stock-in-hand', 'primary_group_name' => 'Current Assets'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Current Assets', 'primary_group_name' => 'Current Assets'],

            ['firm_id' => $request->firm_id, 'account_group_name' => 'Sundry Creditors', 'primary_group_name' => 'Current Liabilities'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Duties & Taxes', 'primary_group_name' => 'Current Liabilities'],

            ['firm_id' => $request->firm_id, 'account_group_name' => 'Provisions/Expenses Payable', 'primary_group_name' => 'Current Liabilities'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Bank O/D Account', 'primary_group_name' => 'Loans (Liability)'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Secured Loans', 'primary_group_name' => 'Loans (Liability)'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Unsecured Loans', 'primary_group_name' => 'Loans (Liability)'],






            ['firm_id' => $request->firm_id, 'account_group_name' => 'Profit & Loss', 'primary_group_name' => 'Profit & Loss'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Sales', 'primary_group_name' => 'Revenue Accounts'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Purchase', 'primary_group_name' => 'Revenue Accounts'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Advertisement & Publicity', 'primary_group_name' => 'Revenue Accounts'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Bank Charges', 'primary_group_name' => 'Revenue Accounts'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Bad Debts Written Off', 'primary_group_name' => 'Revenue Accounts'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Books & Periodicals', 'primary_group_name' => 'Revenue Accounts'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Capital Equipments', 'primary_group_name' => 'Fixed Assets'],
            ['firm_id' => $request->firm_id, 'account_group_name' => 'Reserves & Surplus', 'primary_group_name' => 'Capital Account'],


            ['firm_id' => $request->firm_id, 'account_group_name' => 'Suspense Account', 'primary_group_name' => 'Suspense Account'],



            // More entries here...
        ];

        foreach ($accountGroups as $accountGroup) {
            // Check if the primary group exists
            if (isset($primaryGroups[$accountGroup['primary_group_name']])) {
                DB::table('accountgroups')->insert([
                    'firm_id' => $request->firm_id,
                    'account_group_name' => $accountGroup['account_group_name'],
                    'primary_group_id' => $primaryGroups[$accountGroup['primary_group_name']]
                ]);
            } else {
                // If the primary group doesn't exist, log an error
                \Log::error('Primary group not found for: ' . $accountGroup['primary_group_name']);
            }
        }
    }

    public function accountseed($firm_id)
    {
        // Fetch the required account group IDs
        $saleac_id = accountgroup::where('firm_id', $firm_id)
            ->where('account_group_name', 'Sales')->first();

        $sundry_debtors_id = accountgroup::where('firm_id', $firm_id)
            ->where('account_group_name', 'Sundry Debtors')->first();
        $sundry_SundryCreditors_id = accountgroup::where('firm_id', $firm_id)
            ->where('account_group_name', 'Sundry Creditors')->first();
        $cash_id = accountgroup::where('firm_id', $firm_id)
            ->where('account_group_name', 'Cash In Hand')->first();
        $bankaccount_id = accountgroup::where('firm_id', $firm_id)
            ->where('account_group_name', 'Bank Account')->first();

        if ($saleac_id && $sundry_debtors_id) {
            // Define the accounts to be created
            $accounts = [
                [
                    'firm_id' => $firm_id,
                    'account_name' => 'Sales',
                    'account_group_id' => $saleac_id->id,
                    'op_balnce' => 0,
                    'balnce_type' => 'Dr',
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'phone' => null,
                    'mobile' => null,
                    'email' => null,
                    'person_name' => null,
                    'gst_no' => null,
                    'account_af3' => 'YES',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'firm_id' => $firm_id,
                    'account_name' => 'Room_Checkout',
                    'account_group_id' => $saleac_id->id,
                    'op_balnce' => 0,
                    'balnce_type' => 'Dr',
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'phone' => null,
                    'mobile' => null,
                    'email' => null,
                    'person_name' => null,
                    'gst_no' => null,
                    'account_af3' => 'YES',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'firm_id' => $firm_id,
                    'account_name' => 'FoodBill Sales',
                    'account_group_id' => $saleac_id->id,
                    'op_balnce' => 0,
                    'balnce_type' => 'Dr',
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'phone' => null,
                    'mobile' => null,
                    'email' => null,
                    'person_name' => null,
                    'gst_no' => null,
                    'account_af3' => 'YES',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'firm_id' => $firm_id,
                    'account_name' => 'Stock Transfer From',
                    'account_group_id' => $sundry_debtors_id->id,
                    'op_balnce' => 0,
                    'balnce_type' => 'Dr',
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'phone' => null,
                    'mobile' => null,
                    'email' => null,
                    'person_name' => null,
                    'gst_no' => null,
                    'account_af3' => 'YES',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'firm_id' => $firm_id,
                    'account_name' => 'Stock Transfer To',
                    'account_group_id' => $sundry_debtors_id->id,
                    'op_balnce' => 0,
                    'balnce_type' => 'Dr',
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'phone' => null,
                    'mobile' => null,
                    'email' => null,
                    'person_name' => null,
                    'gst_no' => null,
                    'account_af3' => 'YES',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'firm_id' => $firm_id,
                    'account_name' => 'Guest Customer',
                    'account_group_id' => $sundry_debtors_id->id,
                    'op_balnce' => 0,
                    'balnce_type' => 'Dr',
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'phone' => null,
                    'mobile' => null,
                    'email' => null,
                    'person_name' => null,
                    'gst_no' => null,
                    'account_af3' => 'YES',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'firm_id' => $firm_id,
                    'account_name' => 'Genral Supplier ',
                    'account_group_id' => $sundry_SundryCreditors_id->id,
                    'op_balnce' => 0,
                    'balnce_type' => 'Dr',
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'phone' => null,
                    'mobile' => null,
                    'email' => null,
                    'person_name' => null,
                    'gst_no' => null,
                    'account_af3' => 'YES',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'firm_id' => $firm_id,
                    'account_name' => 'Cash',
                    'account_group_id' => $cash_id->id,
                    'op_balnce' => 0,
                    'balnce_type' => 'Dr',
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'phone' => null,
                    'mobile' => null,
                    'email' => null,
                    'person_name' => null,
                    'gst_no' => null,
                    'account_af3' => 'YES',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'firm_id' => $firm_id,
                    'account_name' => 'Online',
                    'account_group_id' => $bankaccount_id->id,
                    'op_balnce' => 0,
                    'balnce_type' => 'Dr',
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'phone' => null,
                    'mobile' => null,
                    'email' => null,
                    'person_name' => null,
                    'gst_no' => null,
                    'account_af3' => 'YES',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

            ];

            // Filter accounts to ensure no duplicates are inserted
            foreach ($accounts as $account) {
                $exists = DB::table('accounts')
                    ->where('firm_id', $account['firm_id'])
                    ->where('account_name', $account['account_name'])
                    ->exists();

                if (!$exists) {
                    DB::table('accounts')->insert($account);
                }
            }
        } else {
            return "Please seed all account groups first.";
        }
    }

    public function remainingseed($firm_id)
    {
        
        $purchase_id = accountgroup::where('firm_id', $firm_id)
            ->where('account_group_name', 'Purchase')->first(); 


            if ( $purchase_id) {
                // Define the accounts to be created
                $accounts = [
        
                    [
                        'firm_id' => $firm_id,
                        'account_name' => 'Purchase',
                        'account_group_id' => $purchase_id->id,
                        'op_balnce' => 0,
                        'balnce_type' => 'Dr',
                        'address' => null,
                        'city' => null,
                        'state' => null,
                        'phone' => null,
                        'mobile' => null,
                        'email' => null,
                        'person_name' => null,
                        'gst_no' => null,
                        'account_af3' => 'YES',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
             
                ];
    
                // Filter accounts to ensure no duplicates are inserted
                foreach ($accounts as $account) {
                    $exists = DB::table('accounts')
                        ->where('firm_id', $account['firm_id'])
                        ->where('account_name', $account['account_name'])
                        ->exists
                    if (!$exists) {
                        DB::table('accounts')->insert($account);
                    }
                }
            } else {
                return "Please seed all account groups first.";
            }



            $data = [
                [
                    'firm_id' => $firm_id,
                    'voucher_type_name' => 'RKot',
                    'numbring_start_from' => 1,
                    'voucher_prefix' => 'R/',
                    'voucher_suffix' => '',
                    'voucher_numbring_style' => 'voucher_no_continue',
                    'voucher_print_name' => 'Restaurant Kot',
                    'voucher_remark' => 'Restaurant Kot',
                ],
            ];
    
            DB::table('voucher_types')->insert($data);
    }





    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'firm_id' => 'required|unique:users,firm_id',
            'firm_name' => 'required',
            'firm_mobile' => 'required',
            'firm_dealer' => 'required',
            'activation_date' => 'required',
            'expiry_date' => 'required',
            'billing_amt' => 'required',

        ]);
        if ($validator->passes()) {
            $supercomp = new super_comp_list;
            $supercomp->firm_id = $request->firm_id;
            $supercomp->firm_name = $request->firm_name;
            $supercomp->firm_mobile = $request->firm_mobile;
            $supercomp->firm_dealer = $request->firm_dealer;
            $supercomp->activation_date = $request->activation_date;
            $supercomp->expiry_date = $request->expiry_date;
            $supercomp->billing_amt = $request->billing_amt;
            $supercomp->comp_af1 = $request->comp_af1;
            $supercomp->comp_af2 = $request->comp_af2;
            $supercomp->comp_af3 = $request->comp_af3;
            $supercomp->comp_af4 = $request->comp_af4;
            $supercomp->comp_af5 = $request->comp_af5;
            $supercomp->comp_af6 = $request->comp_af6;
            $supercomp->comp_af7 = $request->comp_af7;
            $supercomp->comp_af8 = $request->comp_af8;

            $supercomp->save();
            $this->seedcompinfooters($request);
            $this->createUsersAndAssignRoles($request);
            $this->seedcomponyinfos($request);
            $this->picseeder($request);
            $this->softwarecompanies($request);
            $this->vouchertypeSeedr($request);
            $this->gstmasterseed($request);
            $this->unitseeder($request);
            $this->tableseeder($request);
            $this->businesssourcesseed($request);
            $this->godownsseed($request);
            $this->primarygroupseed($request);
            $this->accountgroupseed($request);
            $this->accountseed($request);
            $this->businessseeting($request);

            return redirect('/super_comp_lists')->with('message', 'Firm Created Successfully  created successfully!');
        } else {
            return redirect('/super_comp_lists')->withInput()->withErrors($validator);
        }
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
        $package = super_comp_list::findOrFail($id);
        return view('room_master.package_edit', compact('package'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'package_name' => 'required',
            'plan_name' => 'required',
            'other_name' => 'required',
        ]);

        $package = super_comp_list::findOrFail($id);
        $package->update($request->all());

        return redirect()->route('super_comp_lists.index')->with('message', 'Package updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the supercom record
        $supercom = super_comp_list::find($id);

        if (!$supercom) {

            return redirect('/super_comp_lists')->with('message', 'supercom Not Found');
        }

        // Get the firm_id from the supercom record
        $firm_id = $supercom->firm_id;

        // Fetch all table names from the database
        $tables = DB::select('SHOW TABLES');
        $databaseName = env('DB_DATABASE');
        $key = "Tables_in_$databaseName";

        DB::beginTransaction();

        try {
            foreach ($tables as $table) {
                $tableName = $table->$key;

                // Check if the table has a 'firm_id' column
                $columns = Schema::getColumnListing($tableName);
                if (in_array('firm_id', $columns)) {
                    // Delete records where 'firm_id' matches
                    DB::table($tableName)->where('firm_id', $firm_id)->delete();
                }
            }

            // Delete the supercom record itself
            $supercom->delete();

            DB::commit();

            return redirect('/super_comp_lists')->with('message', 'All records for the firm and supercom deleted successfully!');
        } catch (\Exception $e) {
            // DB::rollBack();

            // Log the full error details for debugging
            \Log::error('Error deleting records: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return a user-friendly error message or specific error data
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while deleting records. Please contact support.',
                'error' => $e->getMessage(), // Optional: include this only if you want to return the error details.
            ], 500);
        }

    }
}
