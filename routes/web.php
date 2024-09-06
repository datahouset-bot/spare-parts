<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KotController;
use App\Http\Controllers\PicController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\RestaController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\BackupController;

use App\Http\Controllers\ExportController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BanquetController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\FoodbillController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoomtypeController;
use App\Http\Controllers\GstmasterController;
use App\Http\Controllers\ItemgroupController;
use App\Http\Controllers\OptionlistController;
use App\Http\Controllers\ComponyinfoController;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\OtherchargeController;
use App\Http\Controllers\RoombookingController;
use App\Http\Controllers\RoomcheckinController;
use App\Http\Controllers\RoomserviceController;
use App\Http\Controllers\VoucherTypeController;
use App\Http\Controllers\AccountgroupController;
use App\Http\Controllers\PrimarygroupController;
use App\Http\Controllers\RoomcheckoutController;
use App\Http\Controllers\BusinesssourceController;
use App\Http\Controllers\CompinfofooterController;
use App\Http\Controllers\BusinesssettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/admin', function () {
    return view('home22');
});

Route::get('/TESTHOME', function () {
    return view('index');
});
// Route::get('/account', function () {
//     return view('master.account');
// });

Auth::routes();
Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [LandingpageController::class, 'show_secondindexpage'])->name('second_index');


// profile Route--------------------------------------------------
//Route::get('/userprofilelist', [App\Http\Controllers\userprofileController::class, 'show'])->name('userprofilelist');
Route::get('/userprofile', [App\Http\Controllers\userprofileController::class, 'show_userprofile'])->name('userprofile');
Route::get('/deleteprofile/{id}', [App\Http\Controllers\userprofileController::class, 'delete_userprofile'])->name('delete_userprofil');
Route::get('/viwprofileform/{id}', [App\Http\Controllers\userprofileController::class, 'show_user_form'])->name('viwprofileform');
Route::post('/modify', [App\Http\Controllers\userprofileController::class, 'modify']);






// master Route---item_group -----------------------------------------------
 Route::get('itemgroups',[App\Http\Controllers\ItemgroupController::class,'index']);
 Route::Post('itemgroups',[App\Http\Controllers\ItemgroupController::class,'store']);
 Route::get('deleteitemgroups/{id}',[App\Http\Controllers\ItemgroupController::class,'destroy']);
 Route::get('howediteditemgroups/{id}',[App\Http\Controllers\ItemgroupController::class,'show']);

 Route::resource('units',UnitController::class);
 
 Route::Post('unit_store',[App\Http\Controllers\UnitController::class,'unit_store']);
 Route::get('fetch_units', [App\Http\Controllers\UnitController::class, 'fetchUnits']);


 Route::resource('primarygroups',PrimarygroupController::class);
 Route::resource('accountgroups',AccountgroupController::class);
 



// master Route---item-----------------------------------------------
Route::get('/item', [App\Http\Controllers\ItemController::class, 'index'])->name('item');
// Route::get('/deleteitem/{id}', [App\Http\Controllers\ItemController::class, 'destroy']);
Route::get('itemform', [App\Http\Controllers\ItemController::class, 'itemform']);
Route::post('saveitem', [App\Http\Controllers\ItemController::class, 'insertitem']);
Route::get('/showedititem/{id}', [App\Http\Controllers\ItemController::class, 'show_item_form_edit']);
Route::put('/edititem', [App\Http\Controllers\ItemController::class, 'edit_item']);
Route::get('/itemformview/{id}', [App\Http\Controllers\ItemController::class, 'itemformview']);
Route::get('item_dt', [App\Http\Controllers\ItemController::class, 'item_dt']);

Route::get('/searchitem/{item_id}', [ItemController::class, 'searchitem']);

// master Route---Comapny-----------------------------------------------
Route::get('/company', [App\Http\Controllers\CompanyController::class, 'index'])->name('company');
Route::get('/savecompany', [App\Http\Controllers\CompanyController::class, 'create']);
Route::post('/savecompany', [App\Http\Controllers\CompanyController::class, 'create']);
Route::get('/deletecompany/{id}', [App\Http\Controllers\CompanyController::class, 'destroy']);
Route::get('/showeditecompany/{id}', [App\Http\Controllers\CompanyController::class, 'show_company_form_edit']);
Route::put('/editcompany', [App\Http\Controllers\CompanyController::class, 'edit_company']);

//Account Route ---------------------------------------------------------------------------
Route::get('/account',[App\Http\Controllers\AccountController::class,'index']);
Route::get('/account_dt',[App\Http\Controllers\AccountController::class,'index_dt']);
Route::get('/account_import',[App\Http\Controllers\AccountController::class,'account_import']);
Route::post('account_import',[App\Http\Controllers\AccountController::class,'import']);
Route::post('downloadExcel',[App\Http\Controllers\AccountController::class,'downloadExcel']);
Route::post('downloadExcel_todo',[App\Http\Controllers\AccountController::class,'downloadExcel_todo']);
Route::get('/searchcustomer/{contactNumber}', [AccountController::class, 'searchCustomer']);


Route::get('/accountform', [App\Http\Controllers\AccountController::class, 'accountform']);
Route::post('/create', [App\Http\Controllers\AccountController::class, 'create']);
Route::get('/deleteaccount/{id}', [App\Http\Controllers\AccountController::class, 'destroy']);
Route::get('/showeditaccount/{id}', [App\Http\Controllers\AccountController::class, 'show_account_form_edit']);
Route::put('/editaccount', [App\Http\Controllers\AccountController::class, 'edit_account']);
Route::get('/accountformview/{id}', [App\Http\Controllers\AccountController::class, 'accountformview']);
//Amc Entery--------------------------------------------------------------------------------------------

Route::get('/delete_amc/{id}', [App\Http\Controllers\AmcController::class, 'destroy']);
Route::get('/show_edit_amc/{id}', [App\Http\Controllers\AmcController::class, 'show_edit_amc']);
Route::put('/update_amc', [App\Http\Controllers\AmcController::class, 'update_amc']);
// Route::POST('/update_amc', [App\Http\Controllers\AmcController::class, 'update_amc']);
Route::get('/amc_view/{id}', [App\Http\Controllers\AmcController::class, 'amc_view']);




Route::get('amcform',[App\Http\Controllers\AmcController::class,'index'])->name('amcform');
Route::get('amclist',[App\Http\Controllers\AmcController::class,'amclist'])->name('amclist');
Route::post('amclist',[App\Http\Controllers\AmcController::class,'amclistsearch'])->name('amclistsearch');
Route::post('/amccreat',[App\Http\Controllers\AmcController::class, 'create']);
Route::get('/export-amc',[App\Http\Controllers\AmcController::class, 'export'])->name('amc.export');  
Route::get('/amclist-pdf',[App\Http\Controllers\AmcController::class, 'pdf'])->name('amcpdf');  
Route::get('/amclist-mail',[App\Http\Controllers\AmcController::class, 'sendAmcListEmail'])->name('amcemail');  
Route::get('/amclist-print',[App\Http\Controllers\AmcController::class, 'printamclist'])->name('printamclist');
Route::get('amclisttest',[App\Http\Controllers\AmcController::class,'amclisttest'])->name('amclisttest');







//Amc report--------------------------------------------------------------------------------------------
Route::get('amclist_due',[App\Http\Controllers\AmcController::class,'amclist_due'])->name('amclistdue');
Route::post('amclist_due',[App\Http\Controllers\AmcController::class,'amclist_due'])->name('amclistsdue');
Route::get('amclist_due_month',[App\Http\Controllers\AmcController::class,'amclist_due_month'])->name('amclist_due_month');
Route::post('amclist_due_month',[App\Http\Controllers\AmcController::class,'amclist_due_month'])->name('amclist_due_month');
Route::post('amclist_end_month',[App\Http\Controllers\AmcController::class,'amclist_end_month'])->name('amclist_end_month');
Route::get('amclist_end_month',[App\Http\Controllers\AmcController::class,'amclist_end_month'])->name('amclist_end_month');
Route::post('amc_month_inactive',[App\Http\Controllers\AmcController::class,'amc_month_inactive'])->name('amc_month_inactive');
Route::get('amc_month_inactive',[App\Http\Controllers\AmcController::class,'amc_month_inactive'])->name('amc_month_inactive');
Route::post('amc_inactive',[App\Http\Controllers\AmcController::class,'amc_inactive']);
Route::get('amc_inactive',[App\Http\Controllers\AmcController::class,'amc_inactive'])->name('amc_inactive');

//-----Company_info-Setting--------------------------------------- 

route::get('company_info_form',[App\Http\Controllers\ComponyinfoController::class,'show_form']);
route::Put('compinfo_store',[App\Http\Controllers\ComponyinfoController::class,'store']);
route::get('comp_pic_form',[App\Http\Controllers\PicController::class,'index']);
route::put('comp_pic_store',[App\Http\Controllers\PicController ::class,'store']);
route::put('comp_pic_qrstore',[App\Http\Controllers\PicController::class,'comp_pic_qrstore']);
route::put('comp_pic_sealstore',[App\Http\Controllers\PicController::class,'comp_pic_sealstore']);
route::put('comp_pic_signaturestore',[App\Http\Controllers\PicController::class,'comp_pic_signaturestore']);
route::put('comp_pic_brandstore',[App\Http\Controllers\PicController::class,'comp_pic_brandstore']);
route::get('comp_info_footer',[App\Http\Controllers\CompinfofooterController::class,'index']);
route::put('comp_info_footer',[App\Http\Controllers\CompinfofooterController::class,'store']);
Route::get('sql_query', [CompinfofooterController::class, 'sql_query'])->name('sql_query');
Route::post('sql_query_execute', [CompinfofooterController::class, 'sql_query_execute'])->name('sql_query_execute');

//---------Tenent setting ----------------
route::get('tenant_show',[App\Http\Controllers\TenantController::class,'index']);
route::post('tenant_show',[App\Http\Controllers\TenantController::class,'store']);
route::get('tenantlist',[App\Http\Controllers\TenantController::class,'list']);
route::get('super_admin',[App\Http\Controllers\TenantController::class,'show_superadmin']);
Route::get('delete_tenant/{id}',[App\Http\Controllers\TenantController::class,'destroy']);




//-----Call Mangement  ---------------------------------------------------
Route::get('todolist',[App\Http\Controllers\TodoController::class,'index']);
Route::get('todolist_dt',[App\Http\Controllers\TodoController::class,'index_dt']);
Route::get('tododonelist',[App\Http\Controllers\TodoController::class,'index_done']);
Route::post('todolist',[App\Http\Controllers\TodoController::class,'store']);
Route::put('tododone',[App\Http\Controllers\TodoController::class,'edit']);
Route::get('/deletetodo/{id}',[App\Http\Controllers\TodoController::class,'destroy']);
Route::get('/showtodo/{id}', [App\Http\Controllers\TodoController::class, 'show']);
Route::put('/updatetodo', [App\Http\Controllers\TodoController::class, 'update']);
Route::get('todo_import_show', [App\Http\Controllers\TodoController::class, 'import_show']);
Route::post('todolist_import', [App\Http\Controllers\TodoController::class, 'import']);
//-----Call Mangement  ---------------------------------------------------
Route::get('coldcall',[App\Http\Controllers\LeadController::class,'index']);
Route::Post('addlead',[App\Http\Controllers\LeadController::class,'store']);
Route::get('followup',[App\Http\Controllers\LeadController::class,'followup']);
Route::get('followup_list',[App\Http\Controllers\LeadController::class,'followup_list']);
Route::Post('followup_list_datewise',[App\Http\Controllers\LeadController::class,'followup_list_date_wise']);
Route::get('addfollowup/{id}',[App\Http\Controllers\LeadController::class,'addfollowup']);
Route::post('newfollowup',[App\Http\Controllers\LeadController::class,'newfollowup']);
//---------------------------ajex using model ----------------------------------------
Route::get('testshowform',[App\Http\Controllers\TestController::class,'index']);
Route::get('showcustomerajex',[App\Http\Controllers\TestController::class,'show']);
Route::post('savecustomer',[App\Http\Controllers\TestController::class,'create']);
Route::get('searchbox',[App\Http\Controllers\TestController::class,'searchbox']);
Route::get('searchAccount',[App\Http\Controllers\TestController::class,'searchAccount']);
//------------------------------roommaster------------------------------------------------
Route::resource('packages', PackageController::class);
Route::resource('businesssources', BusinesssourceController::class);
Route::resource('roomtypes',RoomtypeController::class);
Route::resource('gstmasters',GstmasterController::class);
Route::resource('rooms',RoomController::class);

route::get('mark_room_dirty',[App\Http\Controllers\RoomController::class,'mark_room_dirty']);
route::POST('change_status_dirty',[App\Http\Controllers\RoomController::class,'change_status_dirty']);

//--------------------------roomdashboard------------------------
Route::get('room_dashboard',[App\Http\Controllers\roomdashboardcontroller::class,'room_dashboard']);
Route::post('room_dashboard',[App\Http\Controllers\roomdashboardcontroller::class,'room_dashboard_datewise']);
//------------------------roombooking--------------------
Route::resource('roombookings',RoombookingController::class);
Route::get('roombooking_home',[App\Http\Controllers\RoombookingController::class,'home'])->name('roombooking_home');
Route::get('clear_booking',[App\Http\Controllers\RoombookingController::class,'clear_booking'])->name('clear_booking');
Route::get('roombooking_view/{id}',[App\Http\Controllers\RoombookingController::class,'view'])->name('roombooking_view');
Route::get('roombooking_by_dashboard/{id}',[App\Http\Controllers\RoombookingController::class,'roombooking_by_dashboard'])->name('roombooking_by_dashboard');
Route::get('booking_calendar',[App\Http\Controllers\RoombookingController::class,'booking_calendar'])->name('booking_calendar');
Route::get('booking_by_guest_create',[App\Http\Controllers\RoombookingController::class,'booking_by_guest_create'])->name('booking_by_guest_create');
Route::post('store_by_guest_booking',[App\Http\Controllers\RoombookingController::class,'store_by_guest_booking'])->name('store_by_guest_booking');
Route::get('pending_booking',[App\Http\Controllers\RoombookingController::class,'pending_booking'])->name('pending_booking');
Route::get('roombooking_confirm/{id}',[App\Http\Controllers\RoombookingController::class,'roombooking_confirm'])->name('roombooking_confirm');
//------------------------roomcheckin--------------------
Route::resource('roomcheckins',RoomcheckinController::class);
route::post('show_roombooking',[App\Http\Controllers\RoomcheckinController::class,'show_roombooking']);
route::get('police_station_report',[App\Http\Controllers\RoomcheckinController::class,'police_station_report']);
route::get('show_selected_booking/{id}',[App\Http\Controllers\RoomcheckinController::class,'show_selected_booking']);
route::get('show_booking/{id}',[App\Http\Controllers\RoomcheckinController::class,'create_after_select_booking']);
route::get('vacant_all_room',[App\Http\Controllers\RoomcheckinController::class,'vacant_all_room']);

//-----------------roomcheckout--------------------------
Route::resource('roomcheckouts',RoomcheckoutController::class);
route::get('roomcheckout_register',[App\Http\Controllers\RoomcheckoutController::class,'register']);
route::post('show_checkin',[App\Http\Controllers\RoomcheckoutController::class,'show_checkin']);
route::post('roomcheckouts_store',[App\Http\Controllers\RoomcheckoutController::class,'roomcheckouts_store']);
route::get('show_checkin/{id}',[App\Http\Controllers\RoomcheckoutController::class,'show_checkin']);
route::get('dirty_room_clear/{id}',[App\Http\Controllers\RoomcheckoutController::class,'dirty_room_clear']);
route::get('room_checkout_view/{id}',[App\Http\Controllers\RoomcheckoutController::class,'room_checkout_view']);
route::get('room_checkout_view3/{id}',[App\Http\Controllers\RoomcheckoutController::class,'room_checkout_view3']);

//------------------------Voucher Type--------------------
Route::resource('voucher_types',VoucherTypeController::class);
Route::resource('othercharges',OtherchargeController::class);
Route::resource('ledgers',LedgerController::class);

Route::get('/outstanding_receivable',[App\Http\Controllers\LedgerController::class,'outstanding_receivable']);
Route::POST('/outstanding_receivable_result',[App\Http\Controllers\LedgerController::class,'outstanding_receivable_result']);
Route::get('/outstanding_payable',[App\Http\Controllers\LedgerController::class,'outstanding_payable']);
Route::POST('/outstanding_payable_result',[App\Http\Controllers\LedgerController::class,'outstanding_payable_result']);

Route::get('/reciepts',[App\Http\Controllers\LedgerController::class,'reciepts']);
Route::post('reciept_store',[App\Http\Controllers\LedgerController::class,'reciept_store']);
Route::post('ledger_show',[App\Http\Controllers\LedgerController::class,'ledger_show']);
Route::get('/payments',[App\Http\Controllers\LedgerController::class,'payments']);
Route::post('payment_store',[App\Http\Controllers\LedgerController::class,'payment_store']);
Route::get('payment_delete/{id}',[App\Http\Controllers\LedgerController::class,'payment_delete']);
Route::get('/advace_receipt',[App\Http\Controllers\LedgerController::class,'advace_receipt']);
Route::post('advace_receipt_store',[App\Http\Controllers\LedgerController::class,'advace_receipt_store']);
Route::get('advace_receipt_delete/{id}',[App\Http\Controllers\LedgerController::class,'advace_receipt_delete']);
Route::get('advace_receipt_print/{id}',[App\Http\Controllers\LedgerController::class,'advace_receipt_print']);
Route::get('/dayend_report',[App\Http\Controllers\LedgerController::class,'dayend_report']);

//---------------------------------roomservice------------
Route::resource('roomservices',RoomserviceController::class);
Route::get('new_room_kot',[App\Http\Controllers\RoomserviceController::class,'new_room_kot']);
Route::get('kichen_dashboard',[App\Http\Controllers\RoomserviceController::class,'kichen_dashboard']);
Route::POST('readytoserve',[App\Http\Controllers\RoomserviceController::class,'readytoserve']);
Route::resource('kots',KotController::class);
Route::get('store_toKot/{id}',[App\Http\Controllers\KotController::class,'store_toKot']);
Route::get('store_and_print/{id}/{voucher_no}',[App\Http\Controllers\KotController::class,'store_and_print']);
Route::get('kots_cleared',[App\Http\Controllers\KotController::class,'kots_cleared']);
//---------------------foodbill-----------------
Route::get('kot_print/{id}/{voucher_no}',[App\Http\Controllers\KotController::class,'kot_print']);
Route::get('kot_print_view/{id}/{voucher_no}',[App\Http\Controllers\KotController::class,'kot_print_view']);
Route::get('facthitem_records/{id}',[App\Http\Controllers\KotController::class,'fetchItemRecords']);
Route::get('temp_item_delete/{id}',[App\Http\Controllers\KotController::class,'temp_item_delete']);   
Route::resource('foodbills',FoodbillController::class); 
Route::get('facthkot_records/{id}',[App\Http\Controllers\FoodbillController::class,'fetchkotRecords']);
Route::get('item_wise_sale_report_view',[App\Http\Controllers\FoodbillController::class,'item_wise_sale_report_view']);
Route::POST('item_wise_sale_report',[App\Http\Controllers\FoodbillController::class,'item_wise_sale_report']);

Route::get('foodbill_print_view/{voucher_no}',[App\Http\Controllers\FoodbillController::class,'foodbill_print_view']);
//-----------------------------option list --------------
Route::resource('optionlists',OptionlistController::class);
Route::get('report_dashboard',[App\Http\Controllers\OptionlistController::class,'report_dashboard']);
Route::resource('businesssettings',BusinesssettingController::class);
//-------------------------table and Restaurent -----------
Route::resource('tables', TableController::class);
Route::get('table_dashboard',[App\Http\Controllers\TableController::class,'table_dashboard']);
Route::get('table_kot_create/{tableid}',[App\Http\Controllers\RestaController::class,'table_kot_create']);
Route::get('table_foodbill_create/{tableid}',[App\Http\Controllers\RestaController::class,'table_foodbill_create']);
Route::get('table_facthkot_records/{id}',[App\Http\Controllers\RestaController::class,'fetchkotRecords']);
Route::get('delete_foodbill/{voucher_no}',[App\Http\Controllers\RestaController::class,'destroy']);
Route::POST('table_foodbills_store',[App\Http\Controllers\RestaController::class,'store']);
Route::get('table_foodbills',[App\Http\Controllers\RestaController::class,'index']);
Route::get('table_foodbill_print_view/{voucher_no}',[App\Http\Controllers\RestaController::class,'table_foodbill_print_view']);

Route::group(['middleware' => ['role:super-admin|admin']], function() {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
    Route::get('/deleteitem/{id}', [App\Http\Controllers\ItemController::class, 'destroy']);

});
//----------------------------purchase--------------------------
Route::resource('purchases', PurchaseController::class);
Route::get('fetchItemRecords_inventory/{id}',[App\Http\Controllers\PurchaseController::class,'fetchItemRecords_inventory']);

Route::resource('banquets', BanquetController::class);
Route::get('/backup', [BackupController::class, 'runBackup']);
Route::get('backupdata', function () {
    Artisan::call('schedule:work');
});
Route::get('run-schedule-work', function () {
    // set_time_limit(0); // Removes the time limit for this script
    // Artisan::call('schedule:work');
    return 'Schedule work command executed.';
});

//-----------------------hotel front page------------------------
Route::get('/hotel_index', function () {
    return view('hotelfront.hotel_front_index');
});
Route::get('/hotel_about', function () {
    return view('hotelfront.hotel_front_about');
});
Route::get('/hotel_room', function () {
    return view('hotelfront.hotel_front_room');
});
Route::get('/hotel_gallery', function () {
    return view('hotelfront.hotel_front_gallery');
});
Route::get('/hotel_blog', function () {
    return view('hotelfront.hotel_front_blog');
});
Route::get('/hotel_contact', function () {
    return view('hotelfront.hotel_front_contact');
});