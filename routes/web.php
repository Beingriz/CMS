<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminModule\AdminController;
use App\Http\Controllers\AdminModule\BranchController;
use App\Http\Controllers\Application\ApplicationController;
use App\Http\Controllers\Ledger\Creditentry;
use App\Http\Controllers\Ledger\DebitEntryController;
use App\Http\Controllers\Home\HomeSlideController;
use App\Http\Controllers\UserModule\UserController;
use App\Http\Controllers\WhatsApp\WhatsappController;
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
Route::middleware('auth', 'auth.role:admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'AdminDashboard')->name('dashboard');
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile_view', 'ProfileView')->name('admin.profile_view');
        Route::get('/admin/change_password', 'ChangePassword')->name('change_password');
        Route::get('/add/services', 'AddServices')->name('add_services');
        Route::get('/edit/services/{id}/{type}', 'EditServices')->name('edit.services');
        Route::get('/delete/services/{id}/{type}', 'DeleteServices')->name('delete.services');
        Route::get('/usertopbar', 'UserTopBar')->name('user_top_bar');
        Route::get('/new/carousel', 'Carousel')->name('new.carousel');
        Route::get('/aboutus', 'AboutUs')->name('new.about_us');
        Route::get('/eidt/carousel/{id}', 'EditCarousel')->name('edit.carousel');
        Route::get('/eidt/about/us/{id}', 'EditAboutUs')->name('edit.aboutus');
        Route::get('/delete/about/us/{id}', 'DeleteAboutUs')->name('delete.aboutus');
        Route::get('/select/about/us/{id}', 'SelectAbout')->name('select.aboutus');
        Route::get('/edit/header/{id}', 'EditHeader')->name('edit.header');
        Route::get('/delete/carousel/{id}', 'DeleteCarousel')->name('delete.carousel');
        Route::get('/marketing/dashboard/', 'MarketingDashboard')->name('marketing.dashboard');
        Route::get('/data/migration', 'DataMigration')->name('data.migration');
        //Branches Module Routes

        Route::get('/branch/registration', 'BranchRegister')->name('branch_register');

    });
});


// Branch
Route::middleware('auth', 'auth.role:branch_admin')->group(function(){
    Route::controller(BranchController::class)->group(function (){
        Route::get('/branch/dashboard', 'BranchAdminDashboard')->name('branch_dashboard');
        Route::get('/branch/admin/logout', 'destroy')->name('branch_admin.logout');


    });
});
Route::controller(WhatsappController::class)->group(function () {
    // Route::get('/send/message/{phone}/{message}', 'sendMessage')->name('send.message');
    Route::get('/send/message/{mobile}/{name}/{service}/{time}/{page}', 'sendMessage')->name('send.message');
});
Route::controller(ApplicationController::class)->group(function () {
});


// User Authenticated Routes

Route::middleware('auth', 'auth.role:user')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/dashboard', 'UserDashboard')->name('user.dashboard');
        Route::get('/user/home/{id}', 'UserHome')->name('user.home');
        Route::get('/view/profile', 'ViewProfile')->name('view.profile');
        Route::get('/service/history/{mobile_no}', 'MyServiceHistory')->name('history');
        Route::get('/eidt/profile', 'EditProfile')->name('edit.profile');
        Route::get('/about/company', 'About')->name('about.us');
        Route::get('/serivce/list', 'ServiceList')->name('service.list');
        Route::get('/serivce/details/{id}', 'ServDetails')->name('serv.details');
        Route::get('/applyNow/{id}/{price}', 'ApplyNow')->name('apply.now');
        Route::get('/acknowledgment/{id}', 'Acknowledgment')->name('acknowledgment');
        Route::get('/track/{id}', 'Track')->name('track');
        Route::get('/view/application{id}', 'viewApplication')->name('view.user.application');
        Route::get('/view/document/{id}', 'viewDocument')->name('view.document');
        Route::get('/feedback/{id}', 'Feedback')->name('feedback');
        Route::get('/callback/{id}/{service}/{service_type}', 'CallBack')->name('callback');
        Route::get('/user/logout', 'destroy')->name('user.logout');

    });
});
Route::middleware('auth', 'auth.role:user', 'prevent.back')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/ApplyNow/{id}/{price}', 'ApplyNow')->name('apply.now');
    });
});
Route::controller(UserController::class)->group(function () {
    Route::get('/', 'Home')->name('user.index');
    Route::get('/', 'HomeIndex')->name('home');
    Route::get('/contact_us', 'ContactUs')->name('contact_us');
    Route::get('/about_us', 'AboutUS')->name('aboutus');
    Route::get('/services', 'Services')->name('services');
    Route::get('/teams', 'Teams')->name('teams');
    Route::get('/testimonials', 'Testimonials')->name('testimonials');
    Route::get('/features', 'Feature')->name('features');
    Route::get('/service/{id}', 'ServiceDetails')->name('service.details');
});



// Application Authentic Routes start
Route::middleware('auth', 'auth.role:admin' )->group(function () {
    Route::controller(ApplicationController::class)->group(function () {
        Route::get('application/home', 'Home')->name('app.home');
        Route::get('app/dashboard', 'Dashboard')->name('Dashboard');
        Route::get('dynamic_dashboard/{mainservice}', 'DynamicDashboard')->name('DynamicDashboard');
        Route::get('new/application', 'index')->name('new.application');
        Route::get('update/application', 'updateApplication')->name('update_application');
        Route::get('edit/application/{id}', 'Edit')->name('edit_application');
        Route::get('view/application/{id}', 'ViewApplication')->name('view.application');
        Route::get('delete/application/{id}', 'MovetoRecycleBin')->name('delete.application');
        Route::get('delete/docs/{id}', 'Delete_File')->name('delete_document');
        Route::get('download/paymentreceipt/{id}', 'Download_Pay')->name('download_pay');
        Route::get('multiple/documents/delete/{array}', 'MultipleDocDelete')->name('multiple_doc_delete');
        Route::get('bookmarks', 'Bookmarks')->name('Bookmarks');
        Route::get('edit/bookmarks/{id}', 'EditBookmark')->name('edit.bookmark');
        Route::get('delete/bookmarks/{id}', 'DeleteBookmark')->name('delete.bookmark');
        Route::get('search/{key}', 'GlobalSearch')->name('global_search');
        Route::get('edit/profile/{id}', 'EditProfile')->name('edit_profile');
        Route::get('new/status', 'AddStatus')->name('new.status');
        Route::get('edit/status/{id}', 'EditStatus')->name('edit.status');
        Route::get('list/app/status/{status}', 'ViewStatus')->name('view.status');
        Route::get('delete/status/{id}', 'DeleteStatus')->name('delete.status');
        Route::get('{name}/dashboard', 'DashboardUpdate')->name('update.dashboard');
        Route::get('whatsapp/chat/{mobile}', 'waGreat')->name('wa.great');
        Route::get('whatsapp/callback/{mobile}/{name}/{service}/{servicetype}', 'waCallBack')->name('wa.callback');
        Route::get('whatsapp/applynow/{mobile}/{name}/{service}/{servicetype}', 'waApplyNow')->name('wa.applynow');
        Route::get('callback/status/update/{id}/{client_id}/{name}', 'UpdateCallBackStatus')->name('update.cb.status');
        Route::get('callback/status/edit/{id}/{client_id}/{name}', 'EditCBStatus')->name('edit.status.callback');
        Route::get('callback/status/delete/{id}/{client_id}/{name}', 'DeleteCBStatus')->name('delete.status.callback');
        Route::get('Whatsapp/Enquiry/{mobile}/{name}/{service}/{time}', 'waEnquiry')->name('wa.enquiry');
        Route::get('Enquiry/dashboard/{id}', 'UpdateEnquiryDashboard')->name('update.enquiry.dashboard');
        Route::get('enquiry/status/edit/{id}]', 'EditEnquiryStatus')->name('edit.status.enquiry');
        Route::get('enquiry/status/delete/{id}/{client_id}/{name}', 'DeleteEnquiryStatus')->name('delete.status.enquiry');
        Route::get('download/docs/{id}', 'Download_Files')->name('download_documents');
        Route::get('download/ack/{id}', 'Download_Ack')->name('download_ack');
        Route::get('download/doc/{id}', 'Download_Doc')->name('download_doc');
    });
});
Route::middleware('auth', 'auth.role:admin')->group(function () {
    Route::controller(CreditEntry::class)->group(function () {
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


Route::middleware('auth', 'auth.role:admin')->group(function () {
    Route::controller(DebitEntryController::class)->group(function () {
        Route::get('Debit', 'Home')->name('Debit');
        Route::get('edit/debit/entry/{Id}', 'EditDebit')->name('edit.debit');
        Route::get('delete/debit/entry/{Id}', 'DeleteDebit')->name('delete.debit');
        //Debit Ledger Routes
        Route::get('DebitSource', 'DebitSource')->name('DebitSource');
        Route::get('edit/debit/main/source{id}', 'EidtMainSource')->name('edit.mainsource');
        Route::get('delete/debit/main/source{id}', 'DeleteMainSource')->name('delete.mainsource');
        Route::get('edit/debit/sub/source{id}', 'EditsSubSource')->name('edit.subsource');
        Route::get('delete/debit/sub/source{id}', 'DeleteSubSource')->name('delete.subsource');
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

require __DIR__ . '/auth.php';
