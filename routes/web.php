<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if(Auth::check()){
        if(Auth::user()->role_id != 3)
            return redirect()->route('home');
        else
            return redirect()->route('user.index');
    }else {
        return view('auth.login');
    }



});

Auth::routes(['verify' => true]);


Route::get('/user/form', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::get('/user/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
Route::POST('/user/form/store/{id}', [App\Http\Controllers\UserController::class, 'store'])->name('user.store.form');

Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('home')->middleware('checkadmin');

Route::get('/admin/add-admin', [App\Http\Controllers\AdminController::class, 'create'])->name('add.admin');
Route::POST('/admin/add-admin', [App\Http\Controllers\AdminController::class, 'store'])->name('add.admin');

Route::get('/admin/profile', [App\Http\Controllers\AdminController::class, 'profile'])->name('admin.profile');
Route::post('/admin/profile', [App\Http\Controllers\AdminController::class, 'update_profile'])->name('admin.profile');
Route::get('/admin/profile/change-password', [App\Http\Controllers\AdminController::class, 'change_password'])->name('admin.change.password');

Route::get('/admin/form/create', [App\Http\Controllers\FormController::class, 'create'])->name('create.form');
Route::get('/admin/form', [App\Http\Controllers\FormController::class, 'index'])->name('index.forms');
Route::POST('/admin/form/edit/{type}/{id}', [App\Http\Controllers\FormController::class, 'edit'])->name('edit.form');
Route::get('/admin/form/details/{id}', [App\Http\Controllers\FormController::class, 'details'])->name('details.forms');
Route::get('/admin/form/edit/status/{id}/{type}', [App\Http\Controllers\FormController::class, 'editstatus'])->name('edit.status.forms');
Route::get('/admin/form/delete/{id}', [App\Http\Controllers\FormController::class, 'delete'])->name('delete.forms');
Route::POST('/admin/form/delete/question/{id}', [App\Http\Controllers\FormController::class, 'deletequestion'])->name('delete.question');
Route::POST('/admin/form/store', [App\Http\Controllers\FormController::class, 'store'])->name('add.forms');
Route::get('/admin/form/store/add-field', [App\Http\Controllers\FormController::class, 'addfield'])->name('add.addfield');
Route::get('/admin/form/question', [App\Http\Controllers\FormController::class, 'infoform'])->name('return.control');
Route::get('/admin/form/edit/question', [App\Http\Controllers\FormController::class, 'editquestion'])->name('edit.question');


Route::POST('/admin/form/export/{id}', [App\Http\Controllers\FormController::class, 'export'])->name('export');


