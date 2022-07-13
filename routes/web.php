<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Home\HomeSlideController;
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
});

// Home Slide Routes
Route::controller(HomeSlideController::class)->group(function(){
 Route::get('/home/slide', 'Index')->middleware(['auth'])->name('home_slide');

});


Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth','verified'])->name('dashboard');

require __DIR__.'/auth.php';
