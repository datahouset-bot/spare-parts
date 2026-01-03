<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KotController;
use App\Http\Controllers\PicController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\cctvcontroller;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TodoController;

use App\Http\Controllers\UnitController;
use App\Http\Controllers\attendancecheck;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\RestaController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\visitController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GodownController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BanquetController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Crushercontroller;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\shownewController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\FoodbillController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoomtypeController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\GstmasterController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemgroupController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\OptionlistController;
use App\Http\Controllers\ComponyinfoController;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\OtherchargeController;
use App\Http\Controllers\RoombookingController;
use App\Http\Controllers\RoomcheckinController;
use App\Http\Controllers\RoomserviceController;
use App\Http\Controllers\VoucherTypeController;
use App\Http\Controllers\WhatsappSmsController;
use App\Http\Controllers\AccountgroupController;
use App\Http\Controllers\PrimarygroupController;
use App\Http\Controllers\RoomcheckoutController;
use App\Http\Controllers\FinancialyearController;
use App\Http\Controllers\StocktransferController;
use App\Http\Controllers\SuperCompListController;
use App\Http\Controllers\BusinesssourceController;
use App\Http\Controllers\CompinfofooterController;
use App\Http\Controllers\BusinesssettingController;
use App\Http\Controllers\photoattendancecontroller;
use App\Http\Controllers\LabelsettingController;
use App\Http\Controllers\SoftwarecompanyController;
use App\Http\Controllers\attendancesalarycontroller;

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


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    // Optional: Also rebuild config cache (optional but common)
    // Artisan::call('config:cache');

    return '✅ All Laravel caches (config, route, view, app) have been cleared.';
});


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
Route::get('/mantinace_mode', [App\Http\Controllers\MaintenancemodeController::class, 'index']);
Route::post('/maintenancemode/update', [App\Http\Controllers\MaintenancemodeController::class, 'update'])->name('maintenancemode.update');


// profile Route--------------------------------------------------
//Route::get('/userprofilelist', [App\Http\Controllers\userprofileController::class, 'show'])->name('userprofilelist');
Route::get('/userprofile', [App\Http\Controllers\userprofileController::class, 'show_userprofile'])->name('userprofile');
Route::get('/deleteprofile/{id}', [App\Http\Controllers\userprofileController::class, 'delete_userprofile'])->name('delete_userprofil');
Route::get('/verifyid/{id}', [App\Http\Controllers\userprofileController::class, 'verifyid'])->name('verifyid');
Route::get('/viwprofileform/{id}', [App\Http\Controllers\userprofileController::class, 'show_user_form'])->name('viwprofileform');
Route::post('/modify', [App\Http\Controllers\userprofileController::class, 'modify']);






// master Route---item_group -----------------------------------------------
Route::get('itemgroups', [App\Http\Controllers\ItemgroupController::class, 'index']);
Route::Post('itemgroups', [App\Http\Controllers\ItemgroupController::class, 'store']);
Route::get('deleteitemgroups/{id}', [App\Http\Controllers\ItemgroupController::class, 'destroy']);
Route::get('showediteditemgroups/{id}', [App\Http\Controllers\ItemgroupController::class, 'show']);
Route::put('/itemgroups/{id}', [ItemGroupController::class, 'update']);


Route::resource('units', UnitController::class);
Route::resource('super_comp_lists', SuperCompListController::class);
Route::get('seed/{firm_id}', [App\Http\Controllers\SuperCompListController::class, 'seed']);
Route::get('remainingseed/{firm_id}', [App\Http\Controllers\SuperCompListController::class, 'remainingseed']);
Route::get('accountseed/{firm_id}', [App\Http\Controllers\SuperCompListController::class, 'accountseed']);
Route::get('batchlabel_seed/{firm_id}', [App\Http\Controllers\SuperCompListController::class, 'batchlabel_seed']);
Route::get('format_seed/{firm_id}', [App\Http\Controllers\SuperCompListController::class, 'format_seed']);
Route::get('trandelete/{firm_id}', [App\Http\Controllers\SuperCompListController::class, 'trandelete']);
Route::get('room_transection_delete/{firm_id}', [App\Http\Controllers\SuperCompListController::class, 'room_transection_delete']);
Route::get('firm_master_delete/{firm_id}', [App\Http\Controllers\SuperCompListController::class, 'firm_master_delete']);
Route::get('firmmaster_foregnkey_delete/{firm_id}', [App\Http\Controllers\SuperCompListController::class, 'firmmaster_foregnkey_delete']);
Route::get('softwarecomapny_show/{firm_id}', [App\Http\Controllers\SuperCompListController::class, 'softwarecomapny_show']);
Route::POST('store_softwarecompny_firmid', [App\Http\Controllers\SuperCompListController::class, 'store_softwarecompny_firmid']);

Route::Post('unit_store', [App\Http\Controllers\UnitController::class, 'unit_store']);
Route::get('fetch_units', [App\Http\Controllers\UnitController::class, 'fetchUnits']);


Route::resource('primarygroups', PrimarygroupController::class);
Route::resource('accountgroups', AccountgroupController::class);




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
Route::get('/searchitem_batch/{item_id}', [ItemController::class, 'searchitem_batch']);
Route::post('/items/import', [ItemController::class, 'importItems'])->name('items.import');

// master Route---Comapny-----------------------------------------------
Route::get('/company', [App\Http\Controllers\CompanyController::class, 'index'])->name('company');
// Route::get('/savecompany', [App\Http\Controllers\CompanyController::class, 'create']);
Route::post('/savecompany', [App\Http\Controllers\CompanyController::class, 'store']);
Route::get('/deletecompany/{id}', [App\Http\Controllers\CompanyController::class, 'destroy']);
Route::get('/showeditecompany/{id}', [App\Http\Controllers\CompanyController::class, 'show_company_form_edit']);
Route::put('/editcompany', [App\Http\Controllers\CompanyController::class, 'edit_company']);

//Account Route ---------------------------------------------------------------------------
Route::get('/account', [App\Http\Controllers\AccountController::class, 'index']);
Route::get('/account_dt', [App\Http\Controllers\AccountController::class, 'index_dt']);
Route::get('/account_import', [App\Http\Controllers\AccountController::class, 'account_import']);
Route::post('account_import', [App\Http\Controllers\AccountController::class, 'import']);
Route::post('downloadExcel', [App\Http\Controllers\AccountController::class, 'downloadExcel']);
Route::post('downloadExcel_todo', [App\Http\Controllers\AccountController::class, 'downloadExcel_todo']);
Route::get('/searchcustomer/{contactNumber}', [AccountController::class, 'searchCustomer']);
Route::get('/searchcustomer_check_in_pending/{contactNumber}', [AccountController::class, 'searchcustomer_check_in_pending']);
Route::get('/searchCustomer_by_id/{id}', [AccountController::class, 'searchCustomer_by_id']);


Route::get('/accountform', [App\Http\Controllers\AccountController::class, 'create']);
Route::post('/create_account', [App\Http\Controllers\AccountController::class, 'store']);
Route::get('/deleteaccount/{id}', [App\Http\Controllers\AccountController::class, 'destroy']);
Route::get('/showeditaccount/{id}', [App\Http\Controllers\AccountController::class, 'edit']);
Route::put('/editaccount', [App\Http\Controllers\AccountController::class, 'update']);
Route::get('/accountformview/{id}', [App\Http\Controllers\AccountController::class, 'accountformview']);
//Amc Entery--------------------------------------------------------------------------------------------

Route::get('/delete_amc/{id}', [App\Http\Controllers\AmcController::class, 'destroy']);
Route::get('/show_edit_amc/{id}', [App\Http\Controllers\AmcController::class, 'show_edit_amc']);
Route::put('/update_amc', [App\Http\Controllers\AmcController::class, 'update_amc']);
// Route::POST('/update_amc', [App\Http\Controllers\AmcController::class, 'update_amc']);
Route::get('/amc_view/{id}', [App\Http\Controllers\AmcController::class, 'amc_view']);
Route::get('/amc_view2/{id}', [App\Http\Controllers\AmcController::class, 'amc_view2']);

Route::get('/amc_format/{id}', [App\Http\Controllers\AmcController::class, 'amc_format']);

// =====================================================================================

Route::resource('cctv',cctvController::class);
Route::get('cctv/{id}/pdf', [cctvController::class, 'pdf'])
     ->name('cctv.pdf');


// ============================================================================================

Route::get('amcform', [App\Http\Controllers\AmcController::class, 'create'])->name('amcform');
Route::get('amclist', [App\Http\Controllers\AmcController::class, 'amclist'])->name('amclist');
Route::post('amclist', [App\Http\Controllers\AmcController::class, 'amclistsearch'])->name('amclistsearch');
Route::post('/amccreat', [App\Http\Controllers\AmcController::class, 'store']);
Route::get('/export-amc', [App\Http\Controllers\AmcController::class, 'export'])->name('amc.export');
Route::get('/amclist-pdf', [App\Http\Controllers\AmcController::class, 'pdf'])->name('amcpdf');
Route::get('/amclist-mail', [App\Http\Controllers\AmcController::class, 'sendAmcListEmail'])->name('amcemail');
Route::get('/amclist-print', [App\Http\Controllers\AmcController::class, 'printamclist'])->name('printamclist');
Route::get('amclisttest', [App\Http\Controllers\AmcController::class, 'amclisttest'])->name('amclisttest');







//Amc report--------------------------------------------------------------------------------------------
Route::get('amclist_due', [App\Http\Controllers\AmcController::class, 'amclist_due'])->name('amclistdue');
Route::post('amclist_due', [App\Http\Controllers\AmcController::class, 'amclist_due'])->name('amclistsdue');
Route::get('amclist_due_month', [App\Http\Controllers\AmcController::class, 'amclist_due_month'])->name('amclist_due_month');
Route::post('amclist_due_month', [App\Http\Controllers\AmcController::class, 'amclist_due_month'])->name('amclist_due_month');
Route::post('amclist_end_month', [App\Http\Controllers\AmcController::class, 'amclist_end_month'])->name('amclist_end_month');
Route::get('amclist_end_month', [App\Http\Controllers\AmcController::class, 'amclist_end_month'])->name('amclist_end_month');
Route::post('amc_month_inactive', [App\Http\Controllers\AmcController::class, 'amc_month_inactive'])->name('amc_month_inactive');
Route::get('amc_month_inactive', [App\Http\Controllers\AmcController::class, 'amc_month_inactive'])->name('amc_month_inactive');
Route::post('amc_inactive', [App\Http\Controllers\AmcController::class, 'amc_inactive']);
Route::get('amc_inactive', [App\Http\Controllers\AmcController::class, 'amc_inactive'])->name('amc_inactive');

//-----Company_info-Setting--------------------------------------- 

route::get('company_info_form', [App\Http\Controllers\ComponyinfoController::class, 'show_form']);
route::Put('compinfo_store', [App\Http\Controllers\ComponyinfoController::class, 'store']);
route::get('comp_pic_form', [App\Http\Controllers\PicController::class, 'index']);
route::put('comp_pic_store', [App\Http\Controllers\PicController::class, 'store']);
route::put('comp_pic_qrstore', [App\Http\Controllers\PicController::class, 'comp_pic_qrstore']);
route::put('comp_pic_sealstore', [App\Http\Controllers\PicController::class, 'comp_pic_sealstore']);
route::put('comp_pic_signaturestore', [App\Http\Controllers\PicController::class, 'comp_pic_signaturestore']);
route::put('comp_pic_brandstore', [App\Http\Controllers\PicController::class, 'comp_pic_brandstore']);
route::put('comp_pic_af1', [App\Http\Controllers\PicController::class, 'comp_pic_af1']);
route::put('comp_pic_af2', [App\Http\Controllers\PicController::class, 'comp_pic_af2']);
route::put('comp_pic_af3', [App\Http\Controllers\PicController::class, 'comp_pic_af3']);
route::put('comp_pic_af4', [App\Http\Controllers\PicController::class, 'comp_pic_af4']);
route::put('comp_pic_af5', [App\Http\Controllers\PicController::class, 'comp_pic_af5']);
route::put('comp_pic_af6', [App\Http\Controllers\PicController::class, 'comp_pic_af6']);
route::put('comp_pic_af7', [App\Http\Controllers\PicController::class, 'comp_pic_af7']);
route::put('comp_pic_af8', [App\Http\Controllers\PicController::class, 'comp_pic_af8']);
route::put('comp_pic_af9', [App\Http\Controllers\PicController::class, 'comp_pic_af9']);
route::put('comp_pic_af10', [App\Http\Controllers\PicController::class, 'comp_pic_af10']);

route::get('comp_info_footer', [App\Http\Controllers\CompinfofooterController::class, 'index']);
route::put('comp_info_footer', [App\Http\Controllers\CompinfofooterController::class, 'store']);
Route::get('sql_query', [CompinfofooterController::class, 'sql_query'])->name('sql_query');
Route::post('sql_query_execute', [CompinfofooterController::class, 'sql_query_execute'])->name('sql_query_execute');

//---------Tenent setting ----------------
route::get('tenant_show', [App\Http\Controllers\TenantController::class, 'index']);
route::post('tenant_show', [App\Http\Controllers\TenantController::class, 'store']);
route::get('tenantlist', [App\Http\Controllers\TenantController::class, 'list']);
route::get('super_admin', [App\Http\Controllers\TenantController::class, 'show_superadmin']);
Route::get('delete_tenant/{id}', [App\Http\Controllers\TenantController::class, 'destroy']);




//-----Call Mangement  ---------------------------------------------------
Route::get('todolist', [App\Http\Controllers\TodoController::class, 'index']);
Route::get('todolist_dt', [App\Http\Controllers\TodoController::class, 'index_dt']);
Route::get('tododonelist', [App\Http\Controllers\TodoController::class, 'index_done']);
Route::post('todolist', [App\Http\Controllers\TodoController::class, 'store']);
Route::put('tododone', [App\Http\Controllers\TodoController::class, 'edit']);
Route::get('/deletetodo/{id}', [App\Http\Controllers\TodoController::class, 'destroy']);
Route::get('/showtodo/{id}', [App\Http\Controllers\TodoController::class, 'show']);
Route::put('/updatetodo', [App\Http\Controllers\TodoController::class, 'update']);
Route::get('todo_import_show', [App\Http\Controllers\TodoController::class, 'import_show']);
Route::post('todolist_import', [App\Http\Controllers\TodoController::class, 'import']);
//-----Call Mangement  ---------------------------------------------------
Route::get('coldcall', [App\Http\Controllers\LeadController::class, 'index']);
Route::Post('addlead', [App\Http\Controllers\LeadController::class, 'store']);
Route::get('followup', [App\Http\Controllers\LeadController::class, 'followup']);
Route::get('followup_list', [App\Http\Controllers\LeadController::class, 'followup_list']);
Route::Post('followup_list_datewise', [App\Http\Controllers\LeadController::class, 'followup_list_date_wise']);
Route::get('addfollowup/{id}', [App\Http\Controllers\LeadController::class, 'addfollowup']);
Route::post('newfollowup', [App\Http\Controllers\LeadController::class, 'newfollowup']);
//---------------------------ajex using model ----------------------------------------
Route::get('testshowform', [App\Http\Controllers\TestController::class, 'index']);
Route::get('showcustomerajex', [App\Http\Controllers\TestController::class, 'show']);
Route::post('savecustomer', [App\Http\Controllers\TestController::class, 'create']);
Route::get('searchbox', [App\Http\Controllers\TestController::class, 'searchbox']);
Route::get('searchAccount', [App\Http\Controllers\TestController::class, 'searchAccount']);
//------------------------------roommaster------------------------------------------------
Route::resource('packages', PackageController::class);

Route::resource('businesssources', BusinesssourceController::class);
Route::resource('roomtypes', RoomtypeController::class);
Route::resource('gstmasters', GstmasterController::class);
Route::resource('rooms', RoomController::class);


Route::resource('softwarecompanies', SoftwarecompanyController::class)
    ->middleware(['check.admin.email', 'check.subscription']);
// route::redirect('rooms','slot');


route::get('mark_room_dirty', [App\Http\Controllers\RoomController::class, 'mark_room_dirty']);
route::POST('change_status_dirty', [App\Http\Controllers\RoomController::class, 'change_status_dirty']);

//-----------------------------channel Manager------------------
Route::get('pushInventory', [App\Http\Controllers\ChannelManagerController::class, 'pushInventory']);
Route::POST('pushrate', [App\Http\Controllers\ChannelManagerController::class, 'pushrate']);

//--------------------------roomdashboard------------------------
Route::get('room_dashboard', [App\Http\Controllers\roomdashboardcontroller::class, 'room_dashboard']);

Route::post('room_dashboard', [App\Http\Controllers\roomdashboardcontroller::class, 'room_dashboard_datewise']);
//------------------------roombooking--------------------
Route::resource('roombookings', RoombookingController::class);
Route::get('roombooking_home', [App\Http\Controllers\RoombookingController::class, 'home'])->name('roombooking_home');
Route::get('roombooking_register', [App\Http\Controllers\RoombookingController::class, 'register'])->name('roombooking_register');
Route::get('clear_booking', [App\Http\Controllers\RoombookingController::class, 'clear_booking'])->name('clear_booking');
Route::get('roombooking_view/{id}', [App\Http\Controllers\RoombookingController::class, 'view'])->name('roombooking_view');
Route::get('roombooking_print2/{id}', [App\Http\Controllers\RoombookingController::class, 'roombooking_print2'])->name('roombooking_print2');
Route::get('roombooking_by_dashboard/{id}', [App\Http\Controllers\RoombookingController::class, 'roombooking_by_dashboard'])->name('roombooking_by_dashboard');
Route::get('booking_calendar', [App\Http\Controllers\RoombookingController::class, 'booking_calendar'])->name('booking_calendar');
Route::get('booking_by_guest_create/{firm_id}', [App\Http\Controllers\RoombookingController::class, 'booking_by_guest_create'])->name('booking_by_guest_create');
Route::post('store_by_guest_booking', [App\Http\Controllers\RoombookingController::class, 'store_by_guest_booking'])->name('store_by_guest_booking');
Route::get('pending_booking', [App\Http\Controllers\RoombookingController::class, 'pending_booking'])->name('pending_booking');
Route::get('roombooking_confirm/{id}', [App\Http\Controllers\RoombookingController::class, 'roombooking_confirm'])->name('roombooking_confirm');
Route::post('room-status', [App\Http\Controllers\RoombookingController::class, 'show_rooms_available_for_booking'])->name('show_rooms_available_for_booking');

Route::post('room-status_by_guest', [App\Http\Controllers\RoombookingController::class, 'show_rooms_available_for_booking_by_guest'])->name('show_rooms_available_for_booking_by_guest');
route::get('roombooking_print_view/{id}', [App\Http\Controllers\RoombookingController::class, 'roombooking_print_view']);
//------------------------roomcheckin--------------------

Route::resource('roomcheckins', RoomcheckinController::class);
route::post('show_room_with_package', [App\Http\Controllers\RoomcheckinController::class, 'show_room_with_package']);
route::post('show_roombooking', [App\Http\Controllers\RoomcheckinController::class, 'show_roombooking']);
route::get('police_station_report', [App\Http\Controllers\RoomcheckinController::class, 'police_station_report']);
route::POST('police_station_report_result', [App\Http\Controllers\RoomcheckinController::class, 'police_station_report_result']);
route::get('room_checkin_view/{id}', [App\Http\Controllers\RoomcheckinController::class, 'room_checkin_view']);
route::get('show_selected_booking/{id}', [App\Http\Controllers\RoomcheckinController::class, 'show_selected_booking']);
route::get('show_booking/{id}', [App\Http\Controllers\RoomcheckinController::class, 'create_after_select_booking']);
route::get('vacant_all_room', [App\Http\Controllers\RoomcheckinController::class, 'vacant_all_room']);
route::Put('roomcheckin_update', [App\Http\Controllers\RoomcheckinController::class, 'update']);
route::get('checkin_print_format/{id}', [App\Http\Controllers\RoomcheckinController::class, 'checkin_print_format']);

//-----------------roomcheckout--------------------------
Route::resource('roomcheckouts', RoomcheckoutController::class);
route::get('roomcheckout_register', [App\Http\Controllers\RoomcheckoutController::class, 'register']);
route::post('roomcheckout_register', [App\Http\Controllers\RoomcheckoutController::class, 'register']);
route::get('guestlog', [App\Http\Controllers\RoomcheckoutController::class, 'guestlog']);

route::post('show_checkin', [App\Http\Controllers\RoomcheckoutController::class, 'show_checkin']);
route::get('My_Check_out', [App\Http\Controllers\RoomcheckoutController::class, 'My_Check_out']);

route::post('roomcheckouts_store', [App\Http\Controllers\RoomcheckoutController::class, 'roomcheckouts_store']);
route::post('roomcheckouts_store_edit', [App\Http\Controllers\RoomcheckoutController::class, 'roomcheckouts_store_edit']);
route::get('show_checkin/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'show_checkin']);
route::get('dirty_room_clear/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'dirty_room_clear']);
route::get('checkout_print_view/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'checkout_print_view']);
route::get('room_checkout_view/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'room_checkout_view']);
route::get('room_checkout_view2/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'room_checkout_view2']);
route::get('room_checkout_view3/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'room_checkout_view3']);
route::get('room_checkout_view4/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'room_checkout_view4']);
route::get('room_checkout_view5/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'room_checkout_view5']);
route::get('room_checkout_view6/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'room_checkout_view6']);
route::get('room_checkout_view7/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'room_checkout_view7']);
route::get('room_checkout_view8/{id}', [App\Http\Controllers\RoomcheckoutController::class, 'room_checkout_view8']);

//------------------------Voucher Type--------------------
Route::resource('voucher_types', VoucherTypeController::class);
Route::resource('othercharges', OtherchargeController::class);
Route::resource('ledgers', LedgerController::class);

Route::get('/outstanding_receivable', [App\Http\Controllers\LedgerController::class, 'outstanding_receivable']);
Route::POST('/outstanding_receivable_result', [App\Http\Controllers\LedgerController::class, 'outstanding_receivable_result']);
Route::get('/outstanding_payable', [App\Http\Controllers\LedgerController::class, 'outstanding_payable']);
Route::POST('/outstanding_payable_result', [App\Http\Controllers\LedgerController::class, 'outstanding_payable_result']);

Route::get('/reciepts', [App\Http\Controllers\LedgerController::class, 'reciepts']);
Route::get('/reciepts_format/{id}', [App\Http\Controllers\LedgerController::class, 'reciepts_format']);
route::get('receipt_print_view/{id}', [App\Http\Controllers\LedgerController::class, 'slip_print_view']);
Route::post('reciept_store', [App\Http\Controllers\LedgerController::class, 'reciept_store']);

Route::post('ledger_show', [App\Http\Controllers\LedgerController::class, 'ledger_show']);

Route::get('/payments', [App\Http\Controllers\LedgerController::class, 'payments']);
Route::get('/payment_format/{id}', [App\Http\Controllers\LedgerController::class, 'payment_format']);
route::get('payment_print_view/{id}', [App\Http\Controllers\ledgerController::class, 'payment_print_view']);
route::get('payment_print_view2/{id}', [App\Http\Controllers\ledgerController::class, 'payment_print_view2']);
route::get('payment_print_view3/{id}', [App\Http\Controllers\ledgerController::class, 'payment_print_view3']);

Route::post('payment_store', [App\Http\Controllers\LedgerController::class, 'payment_store']);
Route::get('payment_delete/{id}', [App\Http\Controllers\LedgerController::class, 'payment_delete']);
Route::get('/advace_receipt', [App\Http\Controllers\LedgerController::class, 'advace_receipt']);
Route::post('advace_receipt_store', [App\Http\Controllers\LedgerController::class, 'advace_receipt_store']);
Route::get('advace_receipt_delete/{id}', [App\Http\Controllers\LedgerController::class, 'advace_receipt_delete']);
Route::get('advace_receipt_print/{id}', [App\Http\Controllers\LedgerController::class, 'advace_receipt_print']);
Route::get('/dayend_report', [App\Http\Controllers\LedgerController::class, 'dayend_report']);


//---------------------------------roomservice------------
Route::resource('roomservices', RoomserviceController::class);
Route::get('new_room_kot', [App\Http\Controllers\RoomserviceController::class, 'new_room_kot']);
Route::get('kichen_dashboard', [App\Http\Controllers\RoomserviceController::class, 'kichen_dashboard']);
Route::POST('readytoserve_print', [App\Http\Controllers\RoomserviceController::class, 'readytoserve_print']);
Route::POST('readytoserve', [App\Http\Controllers\RoomserviceController::class, 'readytoserve']);
Route::resource('kots', KotController::class);
Route::get('/kots/create/{id}', [App\Http\Controllers\KotController::class, 'create']);

Route::get('store_toKot/{id}/{voucher_no}', [App\Http\Controllers\KotController::class, 'store_toKot']);
Route::get('kot_edit/{voucher_no}', [App\Http\Controllers\KotController::class, 'kot_edit']);



Route::get('store_and_print/{id}/{voucher_no}', [App\Http\Controllers\KotController::class, 'store_and_print']);
Route::get('kot_update_print/{id}/{voucher_no}', [App\Http\Controllers\KotController::class, 'kot_update_print']);
Route::get('kot_update/{id}', [App\Http\Controllers\KotController::class, 'kot_update']);
Route::get('kots_cleared/{kot_type}', [App\Http\Controllers\KotController::class, 'kots_cleared']);
//-------------------------------whtsapp controller -------------
Route::get('/send-whatsapp', [App\Http\Controllers\WhatsAppController::class, 'sendFromFrontend']);
Route::resource('whatsapp_sms', WhatsappSmsController::class);
Route::get('send_promotional_whatsapp', [App\Http\Controllers\WhatsappSmsController::class, 'send_promotional_whatsapp']);
Route::POST('start_wp_promotion', [App\Http\Controllers\WhatsappSmsController::class, 'start_wp_promotion']);
Route::get('/get_guest_mobile_numbers', [App\Http\Controllers\WhatsappSmsController::class, 'getGuestMobileNumbers']);

Route::post('/upload-image', [App\Http\Controllers\WhatsappSmsController::class, 'upload'])->name('whatsapp.upload');
//---------------------foodbill-----------------
Route::get('kot_print/{id}/{voucher_no}', [App\Http\Controllers\KotController::class, 'kot_print']);
Route::get('kot_print_view/{id}/{voucher_no}', [App\Http\Controllers\KotController::class, 'kot_print_view']);

Route::get('facthitem_records/{id}', [App\Http\Controllers\KotController::class, 'fetchItemRecords']);
Route::get('temp_item_delete/{id}', [App\Http\Controllers\KotController::class, 'temp_item_delete']);
Route::get('delete_kot_temprecord/{recordValue}', [App\Http\Controllers\KotController::class, 'delete_kot_temprecord']);
Route::resource('foodbills', FoodbillController::class);
Route::get('facthkot_records/{id}', [App\Http\Controllers\FoodbillController::class, 'fetchkotRecords']);
Route::get('item_wise_sale_report_view', [App\Http\Controllers\FoodbillController::class, 'item_wise_sale_report_view']);
Route::POST('item_wise_sale_report', [App\Http\Controllers\FoodbillController::class, 'item_wise_sale_report']);
Route::get('fetchkot/{id}', [App\Http\Controllers\FoodbillController::class, 'fetchkot']);
Route::get('fetchkot_foodbilledit/{id}', [App\Http\Controllers\FoodbillController::class, 'fetchkot_foodbilledit']);
// route::get('foodbill_print_view_bill/{id}', [App\Http\Controllers\FoodbillController::class, 'foodbill_print_view_bill']);
Route::get('foodbill_print_view/{voucher_no}', [App\Http\Controllers\FoodbillController::class, 'foodbill_print_view']);
Route::get('foodbill_print_view_new/{voucher_no}', [App\Http\Controllers\FoodbillController::class, 'foodbill_print_view_new']);
//-----------------------------option list --------------
Route::resource('optionlists', OptionlistController::class);
Route::get('report_dashboard', [App\Http\Controllers\OptionlistController::class, 'report_dashboard']);
Route::resource('businesssettings', BusinesssettingController::class);
Route::resource('businesssettings', BusinesssettingController::class);
//-------------------------help -----------
Route::resource('helps', HelpController::class);
//-------------------------table and Restaurent -----------
Route::resource('tables', TableController::class);
//------------------------financialyears----------------------------
Route::resource('financialyears', FinancialyearController::class);
Route::get('restaurant_kot', [App\Http\Controllers\RestaController::class, 'restaurant_kot']);
Route::get('nckot_register', [App\Http\Controllers\RestaController::class, 'nckot_register']);
Route::post('rest_foodbill_index_register', [App\Http\Controllers\RestaController::class, 'rest_foodbill_index_register']);
Route::post('/rkot_cancel', [App\Http\Controllers\KotController::class, 'cancel_rkot'])->name('rkot.cancel');
Route::get('rkot_destroy/{voucher_no}', [App\Http\Controllers\RestaController::class, 'rkot_destroy']);
Route::get('rkot_edit/{voucher_no}', [App\Http\Controllers\RestaController::class, 'rkot_edit']);
Route::get('rkot_update/{id}', [App\Http\Controllers\RestaController::class, 'rkot_update']);
Route::get('rkot_update_print/{voucher_no}/{id}', [App\Http\Controllers\RestaController::class, 'rkot_update_print']);
Route::get('Rkot_print_view/{id}/{voucher_no}', [App\Http\Controllers\RestaController::class, 'Rkot_print_view']);
Route::get('Rkot_print/{id}/{voucher_no}', [App\Http\Controllers\RestaController::class, 'Rkot_print']);

Route::get('table_dashboard', [App\Http\Controllers\TableController::class, 'table_dashboard']);
Route::get('showShiftTableForm', [App\Http\Controllers\TableController::class, 'showShiftTableForm']);
Route::post('shift_table_action', [App\Http\Controllers\TableController::class, 'shiftTableAction']);
Route::get('table_kot_create/{tableid}', [App\Http\Controllers\RestaController::class, 'table_kot_create']);
Route::get('table_foodbill_create/{tableid}', [App\Http\Controllers\RestaController::class, 'table_foodbill_create']);
Route::get('resta_fetchkot/{id}', [App\Http\Controllers\RestaController::class, 'resta_fetchkot']);
Route::get('resta_fetchkot_edit/{voucher_no}/{id}', [App\Http\Controllers\RestaController::class, 'resta_fetchkot_edit']);
Route::get('table_wise_item', [App\Http\Controllers\RestaController::class, 'table_wise_item']);
Route::get('table_wise_item_result/{table_id}', [App\Http\Controllers\RestaController::class, 'table_wise_item_result']);
Route::get('kot_register_pageshow', [App\Http\Controllers\RestaController::class, 'kot_register_pageshow']);
Route::POST('kot_register_result', [App\Http\Controllers\RestaController::class, 'kot_register_result']);


Route::get('table_facthkot_records/{id}', [App\Http\Controllers\RestaController::class, 'fetchkotRecords']);
Route::get('table_facthkot_records_edit/{voucher_no}/{id}/{settel_only}', [App\Http\Controllers\RestaController::class, 'fetchkotRecords_edit']);
Route::get('delete_foodbill/{voucher_no}', [App\Http\Controllers\RestaController::class, 'destroy']);
Route::POST('table_foodbills_store', [App\Http\Controllers\RestaController::class, 'store']);
Route::POST('table_foodbills_update', [App\Http\Controllers\RestaController::class, 'update']);

Route::get('table_foodbills_edit/{voucher_no}/{table_no}', [App\Http\Controllers\RestaController::class, 'edit']);
Route::get('table_foodbills', [App\Http\Controllers\RestaController::class, 'index']);
Route::get('table_foodbill_print_view/{voucher_no}', [App\Http\Controllers\RestaController::class, 'table_foodbill_print_view']);
Route::get('table_foodbill_settle/{voucher_no}/{id}/{settel_only}', [App\Http\Controllers\RestaController::class, 'settle_show']);
Route::group(['middleware' => ['role:super-admin|admin']], function () {

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
//---------------------------report------------
Route::get('payment_register_pageshow', [App\Http\Controllers\ReportController::class, 'payment_register_pageshow']);
Route::post('payment_register_result', [App\Http\Controllers\ReportController::class, 'payment_register_result']);
Route::get('reciept_register_pageshow', [App\Http\Controllers\ReportController::class, 'reciept_register_pageshow']);
Route::post('reciept_register_result', [App\Http\Controllers\ReportController::class, 'reciept_register_result']);
Route::get('restaurant_pageshow', [App\Http\Controllers\ReportController::class, 'restaurant_pageshow']);
Route::get('fnbrerport_pageshow', [App\Http\Controllers\ReportController::class, 'fnbrerport_pageshow']);
Route::post('fnb_result', [App\Http\Controllers\ReportController::class, 'fnb_result']);
Route::post('restaurant_report', [App\Http\Controllers\ReportController::class, 'restaurant_report']);
Route::get('roomsales_report_pageshow', [App\Http\Controllers\ReportController::class, 'roomsales_report_pageshow']);
Route::post('roomsales_report_result', [App\Http\Controllers\ReportController::class, 'roomsales_report_result']);
Route::get('room_food_gstreport_pageshow', [App\Http\Controllers\ReportController::class, 'room_food_gstreport_pageshow']);
Route::post('roomfood_gstreport', [App\Http\Controllers\ReportController::class, 'roomfood_gstreport']);
Route::get('b2bsales_pageshow', [App\Http\Controllers\ReportController::class, 'b2bsales_pageshow']);
Route::post('b2bsales', [App\Http\Controllers\ReportController::class, 'b2bsales']);
Route::get('b2csales_pageshow', [App\Http\Controllers\ReportController::class, 'b2csales_pageshow']);
Route::post('b2csales', [App\Http\Controllers\ReportController::class, 'b2csales']);
route::get('my_checkout_register_pageshow', [App\Http\Controllers\ReportController::class, 'my_checkout_register_pageshow']);
route::post('my_checkout_register', [App\Http\Controllers\ReportController::class, 'my_checkout_register']);
route::get('checkout_register_pageshow', [App\Http\Controllers\ReportController::class, 'checkout_register_pageshow']);
route::post('checkout_register_only', [App\Http\Controllers\ReportController::class, 'checkout_register_only']);
route::get('handover_report_pageshow', [App\Http\Controllers\ReportController::class, 'handover_report_pageshow']);
route::post('handover_report', [App\Http\Controllers\ReportController::class, 'handover_report']);
Route::get('/handover_view', [App\Http\Controllers\ReportController::class, 'handover_view']);
Route::post('/handover', [App\Http\Controllers\ReportController::class, 'handover']);
Route::get('/dayend_datewise', [App\Http\Controllers\ReportController::class, 'dayend_datewise']);
Route::post('/datewisedayend', [App\Http\Controllers\ReportController::class, 'datewisedayend']);
route::get('roomcheckin_guest_profile_print/{voucher_no}', [App\Http\Controllers\ReportController::class, 'roomcheckin_guest_profile_print']);
//----------------attendance-----------------
Route::get('/attendance_index', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance_report', [AttendanceController::class, 'report'])->name('attendance.report');
Route::post('/attendance_report', [AttendanceController::class, 'reportShow'])->name('attendance.report.show');

//---------------------------------batch setting------------------------------------
Route::get('/batchseeting', [App\Http\Controllers\LabelsettingController::class, 'batchseeting'])->name('batchseeting');
Route::post('/save_batchseeting', [App\Http\Controllers\LabelsettingController::class, 'store']);
Route::get('/batch_lebel_edit/{id}', [App\Http\Controllers\LabelsettingController::class, 'batch_lebel_edit']);
Route::put('/update_lable', [App\Http\Controllers\LabelsettingController::class, 'update_lable']);
Route::post('store_batch', [App\Http\Controllers\BatchController::class, 'store']);
Route::get('/searchbatch/{batch_id}', [App\Http\Controllers\BatchController::class, 'searchbatch']);
Route::resource('batchs', BatchController::class);

// -------------------------------------Crusher new table------------------------------------------------
Route::resource('crusher',Crushercontroller::class);
Route::get('vehicledetail',[App\Http\Controllers\Crushercontroller::class,'vehicledetail'])->name('vehicledetail');
Route::post('vehicledetailstore', [App\Http\Controllers\Crushercontroller::class, 'vehicledetailstore'])
    ->name('vehicledetail.store');
Route::post('crusher/addstore', [Crushercontroller::class, 'crusher_addstore'])
    ->name('crusher.addstore');


// ---------------------------------vehicle detail C------------------------------------
Route::get('vehicledetail', [Crushercontroller::class, 'vehicledetailindex'])
    ->name('vehicledetail.index');

Route::get('vehicledetail/create', [Crushercontroller::class, 'vehicledetailcreate'])
    ->name('vehicledetail.create');
Route::get('vehicledetail/{id}/edit', [Crushercontroller::class, 'vehicledetailedit'])
    ->name('vehicledetail.edit');
Route::delete('vehicledetaildestroy/{id}', [Crushercontroller::class, 'vehicledetaildestroy'])
    ->name('vehicledetail.destroy'); 

route::put('vehicledetailupdate/{id}', [App\Http\Controllers\Crushercontroller::class, 'vehicledetailupdate'])
    ->name('vehicledetail.update');
//=================================================attandance APP=================================================================
route::resource('attendances',photoattendancecontroller::class)->names  ('attendances');
route::get('attendancecheckin', [App\Http\Controllers\photoattendancecontroller::class, 'showform'])->name('attendance.checkin');
Route::get('/employeename/{id}', [photoattendancecontroller::class, 'getEmployeeName']);

route::resource('attendancephoto', attendancecheck::class)->names  ('attendancephoto');
// Route::get('/attendance-status', [Attendancecheck::class, 'attendanceStatus'])
//      ->name('attendance.status');
Route::post('/advance-salary/store', [photoattendanceController::class, 'saveAdvanceSalary'])
     ->name('advance.store');
     
Route::post('/attendance/update-status', 
    [attendancecheck::class, 'updateStatus']
)->name('attendancephoto.updateStatus');

Route::get('employee/print/{id}', [photoattendanceController::class, 'print'])->name('employee.print');
Route::put('/advance-salary/{id}', [photoattendancecontroller::class, 'updateAdvance'])
     ->name('advance.update');
Route::put(
    '/salary-monthly/{id}',
    [photoattendancecontroller::class, 'updateMonthlySalary']
)->name('salary.monthly.update');




//----------------------------purchase- sales invetory  stock managment -------------------------
Route::resource('purchases', PurchaseController::class);
Route::get('purchases_show/{id}',[App\Http\Controllers\purchasecontroller::class,'purchase_show']);
Route::get('purchase_print_view/{id}',[App\Http\Controllers\purchasecontroller::class,'purchase_print_view']);
Route::get('purchase_print_view2/{id}',[App\Http\Controllers\purchasecontroller::class,'purchase_print_view2']);
Route::get('purchase_print_view3/{id}',[App\Http\Controllers\purchasecontroller::class,'purchase_print_view3']);
Route::resource('inventories', InventoryController::class);
Route::resource('stocktransfers', StocktransferController::class);
route::get('purchase_view/{id}',[App\Http\Controllers\StocktransferController::class,'purchase_view']);
route::get('stocktransfer_print_view/{id}',[App\Http\Controllers\StocktransferController::class,'stocktransfer_print_view']);
Route::get('liqour_stock_brand_wise', [App\Http\Controllers\InventoryController::class, 'liqour_stock_brand_wise']);
Route::get('store_to_stocktransfer/{id}', [App\Http\Controllers\StocktransferController::class, 'store_to_stocktransfer']);
Route::get('store_to_purchase/{id}', [App\Http\Controllers\PurchaseController::class, 'store_to_purchase']);
Route::get('store_to_modify_purchase/{id}', [App\Http\Controllers\PurchaseController::class, 'store_to_modify_purchase']);


Route::get('store_to_sale/{id}', [App\Http\Controllers\SaleController::class, 'store_to_sale']);
Route::get('store_wise_stock', [App\Http\Controllers\InventoryController::class, 'show']);
Route::get('item_wise_stock_pageshow', [App\Http\Controllers\InventoryController::class, 'item_wise_stock_pageshow']);
Route::Post('item_wise_stock', [App\Http\Controllers\InventoryController::class, 'item_wise_stock']);

Route::get('fetchItemRecords_inventory/{id}', [App\Http\Controllers\PurchaseController::class, 'fetchItemRecords_inventory']);

Route::resource('sales', SaleController::class);
Route::get('print_sale_select/{id}', [App\Http\Controllers\SaleController::class, 'print_sale_select']);
route::get('sale_print_view/{id}', [App\Http\Controllers\SaleController::class, 'sale_print_view']);
route::get('sale_print_view2/{id}', [App\Http\Controllers\SaleController::class, 'sale_print_view2']);
route::get('sale_print_view3/{id}', [App\Http\Controllers\SaleController::class, 'sale_print_view3']);

route::get('sale_print_view4/{id}', [App\Http\Controllers\SaleController::class, 'sale_print_view4']);

// Route::get('print_select',[App\Http\Controllers\SaleController::class, 'print_select']);
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

//----------------------------------godown---------------------
Route::resource('godowns', GodownController::class);
//-----------------------hotel front page------------------------
route::get('/{firm_id}', [App\Http\Controllers\HotelfrontController::class, 'index']);
route::get('/hotel_about/{firm_id}', [App\Http\Controllers\HotelfrontController::class, 'about']);
route::get('/hotel_room/{firm_id}', [App\Http\Controllers\HotelfrontController::class, 'room']);
route::get('/hotel_gallery/{firm_id}', [App\Http\Controllers\HotelfrontController::class, 'gallery']);
route::get('/hotel_blog/{firm_id}', [App\Http\Controllers\HotelfrontController::class, 'blog']);
route::get('/hotel_contact/{firm_id}', [App\Http\Controllers\HotelfrontController::class, 'contact']);

// ==================================================[for cctv viit ]====================================================================

