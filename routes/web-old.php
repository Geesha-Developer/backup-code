<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovalEmail;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExternalController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\ChartController;

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
    return view('auth/login');
});

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    // Protected routes here
    Route::get('/', [DashboardController::class, 'index']);
});


// Customer Controller Route //
Route::get('/customer', [CustomerController::class, 'customer'])->name('customer');
Route::match(['get', 'post'],'/customer_insert', [CustomerController::class, 'customer_insert'])->name('customer_insert');
Route::delete('/delete-customer/{id}', [CustomerController::class, 'delete_customer'])->name('delete.customer');
Route::get('/home', [CustomerController::class, 'index'])->name('home');
Route::get('/customer-list', [CustomerController::class, 'customerlist'])->name('customerlist');
Route::get('/getcustomers', [CustomerController::class, 'getcustomers'])->name('getcustomers');
Route::get('/customers/search', [CustomerController::class, 'search'])->name('customer.search');
Route::match(['get', 'post'],'/profile/add', [CustomerController::class, 'profile_add'])->name('profile.add');
Route::get('/get-states-by-country', [CustomerController::class, 'getStatesByCountry'])->name('get.states.by.country');
Route::get('/profile/edit/{profile}', [CustomerController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update/{id}', [CustomerController::class, 'update'])->name('profile.update');
Route::match(['get', 'post'],'/profile_insert', [CustomerController::class, 'profile_insert'])->name('profile_insert');
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
});

// External Controller Route //
Route::get('/carrier', [ExternalController::class, 'carrier'])->name('carrier');
Route::post('/insert_carrier', [ExternalController::class, 'insert_carrier'])->name('insert_carrier');
Route::get('/carrier-list', [ExternalController::class, 'carrier_list'])->name('carrier_list');
Route::post('/externals/delete/{id}', [ExternalController::class, 'delete_external'])->name('delete_external');

// Shipper Controller Route //
Route::get('/shipper', [ShipperController::class, 'shipper'])->name('shipper');
Route::post('/shipper_insert', [ShipperController::class, 'shipper_insert'])->name('shipper_insert');
Route::get('/shipper-list', [ShipperController::class, 'shipper_list'])->name('shipper_list');
Route::delete('/delete-shipper/{id}', [ShipperController::class, 'delete_shipper'])->name('delete.shipper');


// Load Controller Route //
Route::get('/load', [LoadController::class, 'load'])->name('load');
Route::get('load', [LoadController::class, 'DataGetLoad'])->name('get.load');
Route::match(['get', 'post'],'/load-insert', [LoadController::class, 'load_insert'])->name('load_insert');


// Consignee Controller
Route::get('consignee', [ConsigneeController::class, 'add_consignee'])->name('consignee');
Route::get('/consignee-list', [ConsigneeController::class, 'consignee_list'])->name('consignee_list');
Route::delete('/consignees/{id}', [ConsigneeController::class, 'destroy'])->name('consignees.destroy');
Route::get('/consignees/{id}/edit', [ConsigneeController::class, 'edit'])->name('consignees.edit');
Route::put('/consignees/{id}', [ConsigneeController::class, 'update'])->name('consignees.update');
Route::post('/consignee-data', [ConsigneeController::class, 'store'])->name('consignee.data.post');

// Admin Login Controller
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');


Route::group(['middleware' => 'auth'], function () {
    // Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});

Route::get('/admin/dashboard', [AdminCustomerController::class, 'userChart'])->name('admin.dashboard');
Route::get('/broker_data', [AdminCustomerController::class, 'broker_data'])->name('broker_data');
Route::get('/datatable', [AdminCustomerController::class, 'index']);
Route::get('/data', [AdminCustomerController::class, 'getData'])->name('data');
Route::get('api/myData', [AdminCustomerController::class, 'apiGetAdminTabel'])->name('getadminapi');
Route::post('/update-status/{id}', [AdminCustomerController::class, 'updateStatus'])->name('update.status');
Route::put('/approve-customer/{id}', [AdminCustomerController::class, 'approveCustomer'])->name('approveCustomer');
Route::delete('/customer-delete/{id}', [AdminCustomerController::class, 'delete_customer'])->name('delete.delete');
Route::get('/edit-customer/{id}', [AdminCustomerController::class, 'editCustomer'])->name('edit.customer');
Route::put('/update-customer/{id}', [AdminCustomerController::class, 'updateCustomer'])->name('update.customer');
Route::get('carrier-data', [AdminCustomerController::class, 'carrier_data'])->name('carrier.data');
Route::delete('/carrier-delete/{id}', [AdminCustomerController::class, 'delete_carrier_data'])->name('carrier.delete');
Route::delete('/external-delete/{id}', [AdminCustomerController::class, 'delete_carrier_data'])->name('external.delete');
Route::post('/process-approval/{customerId}', 'CustomerController@processApproval');
Route::get('get-load-data',[AdminCustomerController::class, 'get_external_load'])->name('get-load-data');
Route::get('/customers/{id}/edit', [AdminCustomerController::class, 'customer_edit'])->name('customers.edit');
Route::get('user_resgister', function () {
    return view('admin/login');
})->name('admin.user_register');
Route::get('/office/added', [AdminCustomerController::class, 'officeAdded'])->name('office.added');
Route::post('/add-office', [AdminCustomerController::class, 'addOffice'])->name('add.office');
Route::get('/add-leader', [AdminCustomerController::class, 'addLeader'])->name('add.leader');
Route::post('/leader-add', [AdminCustomerController::class, 'LeaderAdd'])->name('leader.add');
Route::delete('/manager/delete/{id}', [AdminCustomerController::class, 'mangerdelete'])->name('manager.delete');
Route::delete('/tl/delete/{id}', [AdminCustomerController::class, 'tldelete'])->name('tl.delete');
Route::get('/edit-teamleader/{id}', [AdminCustomerController::class, 'edit_teamleader'])->name('edit.team.leader');
Route::put('/update-tl/{id}', [AdminCustomerController::class, 'updatetl'])->name('update.tl');
Route::put('/update-manager/{id}', [AdminCustomerController::class, 'manager_update'])->name('update.manager');
Route::get('/edit-manager/{id}', [AdminCustomerController::class, 'edit_manager'])->name('edit.manager');
