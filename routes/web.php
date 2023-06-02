<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Application\ApplicationController;
use App\Http\Controllers\Creditentry;
use App\Http\Controllers\DebitEntryController;
use App\Http\Controllers\Home\HomeSlideController;
use App\Http\Controllers\UserController;
use FontLib\Table\Type\name;
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

// Admin Authenticated Routes
Route::middleware('auth','auth.role:admin')->group(function(){
    Route::controller(AdminController::class)->group(function(){
        Route::get('/dashboard','AdminDashboard')->name('dashboard');
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile_view', 'ProfileView')->name('admin.profile_view');
        Route::get('/admin/change_password', 'ChangePassword')->name('change_password');
        Route::get('/add/services', 'AddServices')->name('add_services');
        Route::get('/Edit/Services/{id}/{type}', 'EditServices')->name('edit.services');
        Route::get('/Delete/Services/{id}/{type}', 'DeleteServices')->name('delete.services');
        Route::get('/usertopbar', 'UserTopBar')->name('user_top_bar');
        Route::get('/New/Carousel','Carousel')->name('new.carousel');
        Route::get('/abous_us','AboutUs')->name('new.about_us');
        Route::get('/eidt/carousel/{id}','EditCarousel')->name('edit.carousel');
        Route::get('/Eidt/AboutUs/{id}','EditAboutUs')->name('edit.aboutus');
        Route::get('/Delete/AboutUs/{id}','DeleteAboutUs')->name('delete.aboutus');
        Route::get('/Select/AboutUs/{id}','SelectAbout')->name('select.aboutus');
        Route::get('/Edit/Header/{id}','EditHeader')->name('edit.header');
        Route::get('/delete/carousel/{id}','DeleteCarousel')->name('delete.carousel');


        // --------------------Data Migration Routes -----------------
        Route::get('/data/migration','DataMigration')->name('data.migration');



    });
});
Route::controller(AdminController::class)->group(function(){
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
});
Route::controller(ApplicationController::class)->group(function(){
    Route::get('download/docs/{id}', 'Download_Files')->name('download_documents');
    Route::get('download/ack/{id}', 'Download_Ack')->name('download_ack');
    Route::get('download/doc/{id}', 'Download_Doc')->name('download_doc');
});


// User Authenticated Routes

Route::middleware('auth','auth.role:user')->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('/user/dashboard','UserDashboard')->name('user.dashboard');
        Route::get('/User/Home/{id}','UserHome')->name('user.home');
        Route::get('/View/Profile','ViewProfile')->name('view.profile');
        Route::get('/Service/History/{mobile_no}','MyServiceHistory')->name('history');
        Route::get('/Eidt/Profile','EditProfile')->name('edit.profile');
        Route::get('/About/Company','About')->name('about.us');
        Route::get('/Serivce/List','ServiceList')->name('service.list');
        Route::get('/Serivce/Details/{id}','ServDetails')->name('serv.details');
        Route::get('/ApplyNow/{id}/{price}','ApplyNow')->name('apply.now');
        Route::get('/Acknowledgment/{id}','Acknowledgment')->name('acknowledgment');
        Route::get('/Track/{id}','Track')->name('track');
        Route::get('/View/Application{id}','viewApplication')->name('view.applicaiton');
        Route::get('/View/Document/{id}','viewDocument')->name('view.document');
        Route::get('/Feedback/{id}','Feedback')->name('feedback');

        Route::get('/callback/{id}/{service}/{service_type}','CallBack')->name('callback');

    });
});
Route::middleware('auth','auth.role:user','prevent.back')->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('/ApplyNow/{id}/{price}','ApplyNow')->name('apply.now');
    });
});
Route::controller(UserController::class)->group(function(){
    Route::get('/','Home')->name('user.index');
    Route::get('/','HomeIndex')->name('home');
    Route::get('/contact_us','ContactUs')->name('contact_us');
    Route::get('/about_us','AboutUS')->name('aboutus');
    Route::get('/services','Services')->name('services');
    Route::get('/teams','Teams')->name('teams');
    Route::get('/testimonials','Testimonials')->name('testimonials');
    Route::get('/features','Feature')->name('features');
    Route::get('/service/{id}','ServiceDetails')->name('service.details');


});



// Application Authentic Routes start
Route::middleware('auth','auth.role:admin')->group(function(){
    Route::controller(ApplicationController::class)->group(function(){
        Route::get('Application/Home', 'Home')->name('app.home');
        Route::get('App/Dashboard', 'Dashboard')->name('Dashboard');
        Route::get('dynamic_dashboard/{mainservice}', 'DynamicDashboard')->name('DynamicDashboard');
        Route::get('New/Application', 'index')->name('new.application');
        Route::get('update/application', 'updateApplication')->name('update_application');
        Route::get('edit/application/{id}', 'Edit')->name('edit_application');
        Route::get('delete/docs/{id}', 'Delete_File')->name('delete_document');
        Route::get('download/paymentreceipt/{id}', 'Download_Pay')->name('download_pay');
        Route::get('multiple/documents/delete/{array}', 'MultipleDocDelete')->name('multiple_doc_delete');
        Route::get('bookmarks', 'Bookmarks')->name('Bookmarks');
        Route::get('edit/bookmarks/{id}', 'EditBookmark')->name('edit.bookmark');
        Route::get('delete/bookmarks/{id}', 'DeleteBookmark')->name('delete.bookmark');
        Route::get('global/search/{key}', 'GlobalSearch')->name('global_search');
        Route::get('edit/profile/{id}', 'EditProfile')->name('edit_profile');
        Route::get('new/status', 'AddStatus')->name('new.status');
        Route::get('edit/status/{id}', 'EditStatus')->name('edit.status');
        Route::get('List/App/status/{status}', 'ViewStatus')->name('view.status');
        Route::get('delete/status/{id}', 'DeleteStatus')->name('delete.status');
        // ------------------------------------------------------------------
        Route::get('{name}/dashboard', 'DashboardUpdate')->name('update.dashboard');
        Route::get('Whatsapp/Chat/{mobile}', 'waGreat')->name('wa.great');
        Route::get('Whatsapp/Callback/{mobile}/{name}/{service}/{servicetype}', 'waCallBack')->name('wa.callback');
        Route::get('Whatsapp/Applynow/{mobile}/{name}/{service}/{servicetype}', 'waApplyNow')->name('wa.applynow');
        Route::get('Callback/Status/Update/{id}/{client_id}/{name}', 'UpdateCallBackStatus')->name('update.cb.status');
        Route::get('Callback/Status/Edit/{id}/{client_id}/{name}', 'EditCBStatus')->name('edit.status.callback');
        Route::get('Callback/Status/Delete/{id}/{client_id}/{name}', 'DeleteCBStatus')->name('delete.status.callback');
        Route::get('Whatsapp/Enquiry/{mobile}/{name}/{service}/{time}', 'waEnquiry')->name('wa.enquiry');
        Route::get('Enquiry/dashboard/{id}', 'UpdateEnquiryDashboard')->name('update.enquiry.dashboard');
        Route::get('Enquiry/Status/Edit/{id}]', 'EditEnquiryStatus')->name('edit.status.enquiry');
        Route::get('Enquiry/Status/Delete/{id}/{client_id}/{name}', 'DeleteEnquiryStatus')->name('delete.status.enquiry');




    });
});
Route::middleware('auth','auth.role:admin')->group(function(){
    Route::controller(CreditEntry::class)->group(function(){
    Route::get('Credit', 'Home')->name('Credit');
    Route::get('edit/credit/entry/{Id}', 'EditCredit')->name('edit.credit');
    Route::get('delete/credit/entry/{Id}', 'DeleteCredit')->name('delete.credit');
    Route::get('CreditSource', 'CreditSource')->name('CreditSource');
    Route::get('edit/credit/main/source{id}', 'EidtMainSource')->name('edit.mainsource');
    Route::get('delete/credit/main/source{id}', 'DeleteMainSource')->name('delete.mainsource');
    Route::get('edit/credit/sub/source{id}', 'EditsSubSource')->name('edit.subsource');
    Route::get('delete/credit/sub/source{id}', 'DeleteSubSource')->name('delete.subsource');
    });
});


Route::middleware('auth','auth.role:admin')->group(function(){
    Route::controller(DebitEntryController::class)->group(function(){
        Route::get('Debit','Home')->name('Debit');
        Route::get('edit/debit/entry/{Id}', 'EditDebit')->name('edit.debit');
        Route::get('delete/debit/entry/{Id}', 'DeleteDebit')->name('delete.debit');

    });
});
// Global  Search  Routes start
// Route:: get('search/{key}', [ApplicationController::class,'Search']);

// Route::get('new_temp', [ApplicationController::class,'Temp']);
// // Route::get('dynamic_dashboard/{mainservice}', [ApplicationController::class,'DynamicDashboard']);
// Route::get('app_form', [ApplicationController::class,'List']);
// Route::post('save_application', [SaveApplicaton::class,'Save']);
// Route::get('/edit_app/{id}', [ApplicationController::class,'Edit']);
// Route::get('download_ack/{file}', [ApplicationController::class,'Download_Ack']);
// Route::get('download_pay/{file}', [ApplicationController::class,'Download_Pay']);
// Route::post('update_app/{id}', [ApplicationController::class,'Update']);
// Route::get('/selected_date_app/{date}', [ApplicationController::class,'SelectedDateList']);
// Route::get('/previous_day_app', [ApplicationController::class,'PreviousDay']);
// Route::get('/open_app/{id}', [ApplicationController::class,'Open_Application']);
// Route::get('/update_open_app/{id}', [ApplicationController::class,'Update_Application']);
// Route::get('/delete_app/{id}', [ApplicationController::class,'Delete']);
// Route::get('/delete_app_per/{id}', [ApplicationController::class,'DeletePermanently']);
// Route::get('/view_recycle_bin', [ApplicationController::class,'ViewRecycleBin']);
// Route::get('/restore_app/{id}', [ApplicationController::class,'Restore']);
// Route::get('balance_list', [ApplicationController::class,'BalanceList']);
// Route::get('selected_ser_bal_lis/{value}', [ApplicationController::class,'Selected_Ser_Balance_List']);
// Route::get('/print_ack/{id}', [ApplicationController::class,'PrintAck']);
// Route::get('bookmarks', [ApplicationController::class,'Bookmarks']);
// Route::get('signup', [SignupController::class,'index']);
// Route::post('signup', [SignupController::class,'Save']);


// Route::get('/dashboard', function () {
//     return view('admin.index');
// })->middleware(['auth','auth.role:admin'])->name('dashboard');

require __DIR__.'/auth.php';
