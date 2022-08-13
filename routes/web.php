<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Application\ApplicationController;
use App\Http\Controllers\Home\HomeSlideController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('user.index');
// });

// Admin Routes
Route::controller(AdminController::class)->group(function(){
 Route::get('/', 'HomeIndex')->name('user.index');
 Route::get('/admin/logout', 'destroy')->name('admin.logout');
 Route::get('/admin/profile_view', 'ProfileView')->middleware(['auth'])->name('admin.profile_view');
 Route::get('/admin/change_password', 'ChangePassword')->middleware(['auth'])->name('change_password');
 Route::get('/add/services', 'AddServices')->middleware(['auth'])->name('add_services');
});

// Home Slide Routes
Route::controller(HomeSlideController::class)->group(function(){
 Route::get('/home/slide', 'Index')->middleware(['auth'])->name('home_slide');

});

// Application  Routes start
Route::controller(ApplicationController::class)->group(function(){
    Route::get('app_home', 'Home')->middleware(['auth'])->name('App_Dashboard');
    Route::get('app_home', 'Dashboard')->middleware(['auth'])->name('Dashboard');
    Route::get('dynamic_dashboard/{mainservice}', 'DynamicDashboard')->middleware(['auth'])->name('DynamicDashboard');
    Route::get('new/application', 'index')->middleware(['auth'])->name('new_application');
    Route::get('update/application', 'updateApplication')->middleware(['auth'])->name('update_application');
    Route::get('edit/application/{id}', 'Edit')->middleware(['auth'])->name('edit_application');
    Route::get('download/docs/{id}', 'Download_Files')->middleware(['auth'])->name('download_documents');
    Route::get('delete/docs/{id}', 'Delete_File')->middleware(['auth'])->name('delete_document');
    Route::get('download/ack/{id}', 'Download_Ack')->middleware(['auth'])->name('download_ack');
    Route::get('download/doc/{id}', 'Download_Doc')->middleware(['auth'])->name('download_doc');
    Route::get('download/paymentreceipt/{id}', 'Download_Pay')->middleware(['auth'])->name('download_pay');
    Route::get('multiple/documents/delete/{array}', 'MultipleDocDelete')->middleware(['auth'])->name('multiple_doc_delete');
    Route::get('bookmarks', 'Bookmarks')->middleware(['auth'])->name('Bookmarks');
    Route::get('search/{key}', 'GlobalSearch')->middleware(['auth'])->name('global_search');


});


// Global  Search  Routes start
Route:: get('search/{key}', [ApplicationController::class,'Search']);

Route::get('new_temp', [ApplicationController::class,'Temp']);
// Route::get('dynamic_dashboard/{mainservice}', [ApplicationController::class,'DynamicDashboard']);
Route::get('app_form', [ApplicationController::class,'List']);
Route::post('save_application', [SaveApplicaton::class,'Save']);
Route::get('/edit_app/{id}', [ApplicationController::class,'Edit']);
Route::get('download_ack/{file}', [ApplicationController::class,'Download_Ack']);
Route::get('download_pay/{file}', [ApplicationController::class,'Download_Pay']);
Route::post('update_app/{id}', [ApplicationController::class,'Update']);
Route::get('/selected_date_app/{date}', [ApplicationController::class,'SelectedDateList']);
Route::get('/previous_day_app', [ApplicationController::class,'PreviousDay']);
Route::get('/open_app/{id}', [ApplicationController::class,'Open_Application']);
Route::get('/update_open_app/{id}', [ApplicationController::class,'Update_Application']);
Route::get('/delete_app/{id}', [ApplicationController::class,'Delete']);
Route::get('/delete_app_per/{id}', [ApplicationController::class,'DeletePermanently']);
Route::get('/view_recycle_bin', [ApplicationController::class,'ViewRecycleBin']);
Route::get('/restore_app/{id}', [ApplicationController::class,'Restore']);
Route::get('balance_list', [ApplicationController::class,'BalanceList']);
Route::get('app_status_list/{service}', [ApplicationController::class,'AppStatusList']);
Route::get('selected_ser_bal_lis/{value}', [ApplicationController::class,'Selected_Ser_Balance_List']);
Route::get('/print_ack/{id}', [ApplicationController::class,'PrintAck']);
Route::get('bookmarks', [ApplicationController::class,'Bookmarks']);
Route::get('statusmodule', [ApplicationController::class,'StatusModule']);
Route::get('signup', [SignupController::class,'index']);
Route::post('signup', [SignupController::class,'Save']);


Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth','verified'])->name('dashboard');

require __DIR__.'/auth.php';
