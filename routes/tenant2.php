<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PicController;
use App\Http\Controllers\temController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\accountController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ItemgroupController;
use App\Http\Controllers\ComponyinfoController;
use App\Http\Controllers\LandingpageController;
use App\Http\Middleware\ComonvariableMiddleware;
use App\Http\Controllers\CompinfofooterController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    
ComonvariableMiddleware::class,
])->group(function () {
    // Route::get('/', function () {
    //     dd(tenant()->toarray());
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // });
    
Route::get('/second_index', [LandingpageController::class, 'show_secondindexpage'])->name('second_index');
    Route::get('/', function () {
        return view('index');
    });
    
    
      Auth::routes();
      Auth::routes(['verify' => true]);
      Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
      


      Route::get('/account', [App\Http\Controllers\userprofileController::class, 'show'])->name('account');
Route::get('/userprofile', [App\Http\Controllers\userprofileController::class, 'show_userprofile'])->name('userprofile');
Route::get('/deleteprofile/{id}', [App\Http\Controllers\userprofileController::class, 'delete_userprofile'])->name('delete_userprofil');
Route::get('/viwprofileform/{id}', [App\Http\Controllers\userprofileController::class, 'show_user_form'])->name('viwprofileform');

Route::post('/modify', [App\Http\Controllers\userprofileController::class, 'modify']);

Route::get('/account', [App\Http\Controllers\userprofileController::class, 'show'])->name('account');
Route::get('/userprofile', [App\Http\Controllers\userprofileController::class, 'show_userprofile'])->name('userprofile');
Route::get('/deleteprofile/{id}', [App\Http\Controllers\userprofileController::class, 'delete_userprofile'])->name('delete_userprofil');
Route::get('/viwprofileform/{id}', [App\Http\Controllers\userprofileController::class, 'show_user_form'])->name('viwprofileform');

Route::post('/modify', [App\Http\Controllers\userprofileController::class, 'modify']);
// master Route---item_group -----------------------------------------------
 Route::get('itemgroups',[ItemgroupController::class,'index']);
 Route::Post('itemgroups',[ItemgroupController::class,'store']);
 Route::get('deleteitemgroups/{id}',[ItemgroupController::class,'destroy']);
 Route::get('howediteditemgroups/{id}',[ItemgroupController::class,'show']);










// master Route---item-----------------------------------------------
Route::get('/item', [App\Http\Controllers\ItemController::class, 'index'])->name('item');
Route::get('/deleteitem/{id}', [App\Http\Controllers\ItemController::class, 'destroy']);
Route::get('itemform', [App\Http\Controllers\ItemController::class, 'itemform']);
Route::post('saveitem', [App\Http\Controllers\ItemController::class, 'insertitem']);
Route::get('/showedititem/{id}', [App\Http\Controllers\ItemController::class, 'show_item_form_edit']);
Route::put('/edititem', [App\Http\Controllers\ItemController::class, 'edit_item']);
Route::get('/itemformview/{id}', [App\Http\Controllers\ItemController::class, 'itemformview']);
// master Route---Comapny-----------------------------------------------
Route::get('/company', [App\Http\Controllers\CompanyController::class, 'index'])->name('company');
Route::get('/savecompany', [App\Http\Controllers\CompanyController::class, 'create']);
Route::post('/savecompany', [App\Http\Controllers\CompanyController::class, 'create']);
Route::get('/deletecompany/{id}', [App\Http\Controllers\CompanyController::class, 'destroy']);
Route::get('/showeditecompany/{id}', [App\Http\Controllers\CompanyController::class, 'show_company_form_edit']);
Route::put('/editcompany', [App\Http\Controllers\CompanyController::class, 'edit_company']);

//Account Route ---------------------------------------------------------------------------
Route::get('/account',[App\Http\Controllers\accountController::class,'index'])->name('account');
Route::get('/accountform', [App\Http\Controllers\accountController::class, 'accountform']);
Route::post('/create', [App\Http\Controllers\accountController::class, 'create']);
Route::get('/deleteaccount/{id}', [App\Http\Controllers\accountController::class, 'destroy']);
Route::get('/showeditaccount/{id}', [App\Http\Controllers\accountController::class, 'show_account_form_edit']);
Route::put('/editaccount', [App\Http\Controllers\accountController::class, 'edit_account']);
Route::get('/accountformview/{id}', [App\Http\Controllers\accountController::class, 'accountformview']);
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
route::get('comp_pic_form',[App\Http\Controllers\picController::class,'index']);
route::put('comp_pic_store',[App\Http\Controllers\picController::class,'store']);
route::put('comp_pic_qrstore',[App\Http\Controllers\picController::class,'comp_pic_qrstore']);
route::put('comp_pic_sealstore',[App\Http\Controllers\picController::class,'comp_pic_sealstore']);
route::put('comp_pic_signaturestore',[App\Http\Controllers\picController::class,'comp_pic_signaturestore']);
route::put('comp_pic_brandstore',[App\Http\Controllers\picController::class,'comp_pic_brandstore']);
route::get('comp_info_footer',[App\Http\Controllers\CompinfofooterController::class,'index']);
route::put('comp_info_footer',[App\Http\Controllers\CompinfofooterController::class,'store']);


});
