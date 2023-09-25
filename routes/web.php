<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Farm\GoatController;
use App\Http\Controllers\Farm\ReportController;
use App\Http\Controllers\Farm\TransactionController;
use App\Http\Controllers\Farm\HealthRecordController;
use App\Http\Controllers\Farm\CustomerController;
use App\Http\Controllers\Farm\EmployeeController;
use App\Http\Controllers\Auth\LoginController;

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
    return redirect()->route('dashboard');
});

Route::get('login',[UserController::class,'showLogin'])->name('showLogin');

Route::post('login',[UserController::class,'login'])->name('login');


Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard',[UserController::class,'dashboard'])->name('dashboard');

    Route::resource('user', UserController::class);

    // farm
    //goat
    Route::get('goat',[GoatController::class,'index'])->name('goat.index');
    Route::get('goat/add',[GoatController::class,'add'])->name('goat.add');
    Route::post('goat/store',[GoatController::class,'store'])->name('goat.store');
    Route::get('goat/dead/{id}',[GoatController::class,'dead'])->name('goat.dead');
    Route::post('goat/remove',[GoatController::class,'remove'])->name('goat.remove');
    Route::get('goat/castrate/{id}',[GoatController::class,'castrate'])->name('goat.castrate');
    Route::post('goat/castrate_store',[GoatController::class,'castrate_store'])->name('goat.castrate_store');

    Route::get('fetchDetails/{id}', [GoatController::class,'fetchDetails'])->name('fetchDetails');


//report
    Route::get('report',[ReportController::class,'index'])->name('report.index');
    Route::get('report/add',[ReportController::class,'add'])->name('report.add');
    Route::post('report/store',[ReportController::class,'store'])->name('report.store');
    Route::get('report/edit/{id}',[ReportController::class,'edit'])->name('report.edit');
    Route::post('report/edit_store/{id}',[ReportController::class,'edit_store'])->name('report.edit_store');
    Route::delete('report/delete/{id}',[ReportController::class,'delete'])->name('report.delete');

    //transaction
    Route::get('transaction',[TransactionController::class,'index'])->name('transaction.index');
    Route::get('transaction/add',[TransactionController::class,'add'])->name('transaction.add');
    Route::post('transaction/store',[TransactionController::class,'store'])->name('transaction.store');

    //healthrecord
    Route::get('healthrecord',[HealthRecordController::class,'index'])->name('healthrecord.index');

    //customer
    Route::get('customer',[CustomerController::class,'index'])->name('customer.index');
    Route::get('customer/add',[CustomerController::class,'add'])->name('customer.add');
    Route::post('customer/store',[CustomerController::class,'store'])->name('customer.store');
    Route::get('customer/edit/{id}',[CustomerController::class,'edit'])->name('customer.edit');
    Route::post('customer/edit_store/{id}',[CustomerController::class,'edit_store'])->name('customer.edit_store');
    Route::delete('customer/delete/{id}',[CustomerController::class,'delete'])->name('customer.delete');


    //employee
    Route::get('employee',[EmployeeController::class,'index'])->name('employee.index');

});
