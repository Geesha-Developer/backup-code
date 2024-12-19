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
use App\Http\Controllers\Accounts\AccountController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\FilesUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\McCheckController;

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
// Auth::routes(['verify' => true]); // If not already included
// Route::resource('permission',App\Http\Controllers\PermissionController::class);


Route::get('/', function () {
    return view('auth/login');
});


Auth::routes();

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Customer Controller Route //
Route::get('/customer', [CustomerController::class, 'customer'])->name('customer');



Route::match(['get', 'post'],'/customer_insert', [CustomerController::class, 'customer_insert'])->name('customer_insert');
Route::delete('/delete-customer/{id}', [CustomerController::class, 'delete_customer'])->name('delete.customer');
Route::get('/home', [CustomerController::class, 'index'])->name('home');
Route::get('/dashboard/home', [CustomerController::class, 'IndexDashboard'])->name('dashboardhome');
Route::get('/customer-list', [CustomerController::class, 'customerlist'])->name('customerlist');
Route::get('/getcustomers', [CustomerController::class, 'getcustomers'])->name('getcustomers');
Route::get('/customers/search', [CustomerController::class, 'search'])->name('customer.search');
Route::match(['get', 'post'],'/profile/add', [CustomerController::class, 'profile_add'])->name('profile.add');
Route::get('/get-states-by-country', [CustomerController::class, 'getStatesByCountry'])->name('get.states.by.country');
Route::get('/profile/edit/{profile}', [CustomerController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update/{id}', [CustomerController::class, 'update'])->name('profile.update');
Route::match(['get', 'post'],'/profile_insert', [CustomerController::class, 'profile_insert'])->name('profile_insert');
Route::post('/user/reset-password', [CustomerController::class, 'resetPassword'])->name('user.resetPassword');
Route::post('/change-password', [CustomerController::class, 'changePassword'])->name('change.password');
Route::get('password/reset', [CustomerController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [CustomerController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('/update-user-details', [CustomerController::class, 'updateUserDetails'])->name('update.user.details');
Route::get('/customer/{id}/edit', [CustomerController::class, 'customerEdit'])->name('customer.edit');
Route::put('/customer/{id}', [CustomerController::class, 'customerupdate'])->name('customer.update');

// Route::get('/register', [CustomerController::class, 'showRegistrationForm'])->name('register.form');
// Route::post('/register/user', [CustomerController::class, 'registerUser'])->name('register.user');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
});
// Route::get('password/reset', [CustomerController::class, 'showLinkRequestForm']);

// External Controller Route //
Route::get('/carrier', [ExternalController::class, 'carrier'])->name('carrier');
Route::post('/insert_carrier', [ExternalController::class, 'insert_carrier'])->name('insert_carrier');
Route::get('/carrier-list', [ExternalController::class, 'carrier_list'])->name('carrier_list');
Route::post('/externals/delete/{id}', [ExternalController::class, 'delete_external'])->name('delete_external');
Route::get('/carriers/{id}/edit', [ExternalController::class, 'carrierEdit'])->name('carriers.edit');
Route::put('/carriers/{id}', [ExternalController::class, 'carriersUpdate'])->name('carriers.update');
Route::get('/carrier-get-country',[ExternalController::class, 'carrierEditGetCountry'])->name('carrier.get.country');
Route::delete('/carrier/delete/{id}', [ExternalController::class, 'destroyCarrier'])->name('carrier.delete');

// Shipper Controller Route //
Route::get('/shipper', [ShipperController::class, 'shipper'])->name('shipper');
Route::post('/shipper_insert', [ShipperController::class, 'shipper_insert'])->name('shipper_insert');
Route::get('/shipper-list', [ShipperController::class, 'shipper_list'])->name('shipper_list');
Route::delete('/delete-shipper/{id}', [ShipperController::class, 'delete_shipper'])->name('delete.shipper');
Route::get('/shipper/edit/{id}', [ShipperController::class, 'shipperEdit'])->name('shipper.edit');
Route::put('/shipper/update/{id}', [ShipperController::class, 'shipperUpdate'])->name('shipper.update');
Route::delete('/shipper/delete/{id}', [ShipperController::class, 'destroyshipper'])->name('shipper.delete.data');


// Load Controller Route //
Route::get('/load', [LoadController::class, 'load'])->name('load');

Route::get('load', [LoadController::class, 'DataGetLoad'])->name('get.load');
Route::post('/load-insert', [LoadController::class, 'load_insert'])->name('load_insert');
Route::get('/posts/{id}/edit', [LoadController::class, 'load_edit'])->name('load.insert');
Route::put('/posts/{id}', [LoadController::class, 'load_update'])->name('load.update');
Route::get('/download-pdf/{id}', [LoadController::class, 'download'])->name('download.pdf');
Route::get('/shipper-rc-pdf/{id}', [LoadController::class, 'shipperRateCoin'])->name('shipper.rc.pdf');
Route::get('/clone/load/{id}', [LoadController::class, 'cloneLoad'])->name('clone.load');
Route::get('/Broker/load/Edit/{id}', [LoadController::class, 'BrokerLoadEdit'])->name('broker.load.edit');
Route::put('/Broker/load/update/{id}', [LoadController::class, 'BrokerLoadUpdate'])->name('broker.load.update');
Route::get('/fetch-carrier-names', [LoadController::class, 'fetchCarrierNames'])->name('fetch.carrier.names');
Route::get('/fetch/customer/names', [LoadController::class, 'fetchCustomerNames'])->name('fetch.customer.names');
Route::post('/fetch-carrier-list', [LoadController::class, 'fetchCarrierList'])->name('fetch.carrier.list');
Route::post('/fetch-carrier-details', [LoadController::class, 'fetchCarrierDetails'])->name('fetch.carrier.details');
Route::get('/fetch-customer-details', [LoadController::class, 'fetchCustomerDetails'])->name('fetch.customer.details');
Route::post('/update-customer-credit', [LoadController::class, 'updateCustomerCredit']);


Route::get('/fetch-shipper-details', [LoadController::class, 'fetchShipperDetails'])->name('fetch.shipper.details');
Route::get('/fetch-consignee-details', [LoadController::class, 'fetchConsigneeDetails'])->name('fetch.consignee.details');
Route::get('/fetch-load-data', [LoadController::class, 'fetchLoadData'])->name('fetch.load.data');
Route::get('brokerloadstatus', [LoadController::class, 'BrokerLoadStatus'])->name('brokerloadstatus');
Route::get('/fetch-filtered-data', [LoadController::class, 'fetchFilteredData'])->name('fetch.filtered.data');
Route::post('/update-load-status/{id}', [LoadController::class, 'updateLoadStatus']);
Route::post('/upload-files/{id}', [LoadController::class, 'uploadFiles']);
Route::get('/shipper-location/{id}', [LoadController::class, 'getShipperLocation'])->name('shipper.location');
Route::post('/ajaxupload', [LoadController::class, 'UploadLoadStatus']);
// Route::post('/upload', [LoadController::class, 'uploadFiles'])->name('upload.files');
Route::post('file-upload', [LoadController::class,'uploadFiles'])->name('file.store');
Route::get('bol',[LoadController::class,'bol'])->name('bol');
// Route::get('mc', [LoadController::class, 'mcCheck'])->name('mc');
Route::get('cpr', [LoadController::class, 'cprCheck'])->name('cpr');
Route::get('/fetch-consignee-details-edit', [LoadController::class, 'fetchConsigneeDetailsEdit'])->name('fetch.consignee.details.edit');
Route::get('/fetch-shipper-details-edit', [LoadController::class, 'fetchShipperDetailsEdit'])->name('fetch.shipper.details.edit');
Route::get('/store-amount', [LoadController::class, 'storeAmount'])->name('store.amount');
// Route::post('/update/invoice/status', [LoadController::class, 'updateInvoiceStatus'])->name('update.invoice.status');
Route::post('/update/invoice/status', [LoadController::class, 'updateInvoiceStatus'])->name('update.invoice.status.agent');
Route::post('/get/files/carrierdoc', [LoadController::class, 'getFilesCarrierDoc'])->name('get.files.carrierdoc');
Route::post('/profile-picture/update', [LoadController::class, 'updateProfilePicture'])->name('profile.picture.update');
Route::post('/fetch-carrier-suggestions', [LoadController::class, 'fetchCarrierSuggestions'])->name('fetch.carrier.suggestions');




// Consignee Controller
Route::get('consignee', [ConsigneeController::class, 'add_consignee'])->name('consignee');
Route::get('/consignee-list', [ConsigneeController::class, 'consignee_list'])->name('consignee_list');
Route::delete('/consignees/{id}', [ConsigneeController::class, 'destroy'])->name('consignees.destroy');
Route::get('/consignees/{id}/edit', [ConsigneeController::class, 'edit'])->name('consignees.edit');
Route::put('/consignees/edit/{id}', [ConsigneeController::class, 'update'])->name('consignees.update');
Route::post('/consignee-data', [ConsigneeController::class, 'store'])->name('consignee.data.post');
Route::delete('/consignee/delete/{id}', [ConsigneeController::class, 'destroyconsignee'])->name('consignee.delete');


Route::get('/super-admin-login', [AdminCustomerController::class, 'SuperAdminLogin'])->name('SuperAdminLogin');
Route::post('/super-admin-login', [AdminCustomerController::class, 'SuperAdminLogin']);
Route::get('/admin/dashboard', [AdminCustomerController::class, 'userChart'])->name('admin.dashboard');
Route::get('/super-admin-logout', [AdminCustomerController::class, 'SuperAdminLogout'])->name('Super.Admin.Logout');
Route::get('/admin/broker/status', [AdminCustomerController::class, 'admin_broker_status'])->name('admin.broker.status');
Route::get('/admin/manager/dashboard', [AdminCustomerController::class, 'ManagerDashboard'])->name('admin.manager.dashboard');
Route::get('/admin/download/pdf/{id}', [AdminCustomerController::class, 'adminRcDownload'])->name('admin.rc.download.pdf');
Route::get('/admin/download/shipper/pdf/{id}', [AdminCustomerController::class, 'adminShipperRcDownload'])->name('admin.shipper.rc.download.pdf');
Route::delete('/office/{id}', [AdminCustomerController::class, 'officeDestroy'])->name('office.destroy');
Route::delete('/manager/{id}', [AdminCustomerController::class, 'mangerDestroy'])->name('manager.destroy');
Route::delete('/teamleader/{id}', [AdminCustomerController::class, 'teamleadDestroy'])->name('teamleader.destroy');
Route::get('/manager-edit/{id}', [AdminCustomerController::class, 'getManager']);
Route::post('/manager/update', [AdminCustomerController::class, 'updateManager']);
Route::get('/team-leader/{id}', [AdminCustomerController::class, 'getTeamLeader']);
Route::post('/teamleader/update', [AdminCustomerController::class, 'updateTeamLeader']);
Route::get('/accountuser', [AdminCustomerController::class, 'getAccountUser'])->name('accountuser');
Route::get('/account/{id}/edit', [AdminCustomerController::class, 'accountUserEdit'])->name('account.user.edit');
Route::post('/account/update', [AdminCustomerController::class, 'accountUserUpdate'])->name('account.user.update');
Route::delete('/account/{id}', [AdminCustomerController::class, 'accountUserDelete'])->name('account.user.delete');
Route::get('/user/{id}/edit', [AdminCustomerController::class, 'edit'])->name('user.edit');
Route::post('/user/update', [AdminCustomerController::class, 'update'])->name('user.update');
Route::delete('/user/{id}', [AdminCustomerController::class, 'destroy'])->name('user.delete');
Route::get('/broker_data', [AdminCustomerController::class, 'broker_data'])->name('broker_data');
Route::get('/datatable', [AdminCustomerController::class, 'index']);
Route::get('api/myData', [AdminCustomerController::class, 'apiGetAdminTabel'])->name('getadminapi');
Route::post('/update-status/{id}', [AdminCustomerController::class, 'updateStatus'])->name('update.status');
Route::put('/approve-customer/{id}', [AdminCustomerController::class, 'approveCustomer'])->name('approveCustomer');
Route::delete('/customer-delete/{id}', [AdminCustomerController::class, 'delete_customer'])->name('delete.delete');
Route::get('/edit-customer/{id}', [AdminCustomerController::class, 'editCustomer'])->name('edit.customer');
Route::put('/update-customer/{id}', [AdminCustomerController::class, 'updateCustomer'])->name('update.customer');
Route::get('carrier-data', [AdminCustomerController::class, 'carrier_data'])->name('carrier.data');
Route::get('shipper-data', [AdminCustomerController::class, 'shipper_data'])->name('shipper.data');
Route::get('consignee-data', [AdminCustomerController::class, 'consignee_data'])->name('consignee.data');
Route::get('load-data', [AdminCustomerController::class, 'load_data'])->name('load.data');
// Route::delete('/carrier-delete/{id}', [AdminCustomerController::class, 'delete_carrier_data'])->name('carrier.delete');
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
Route::get('/all/users', [AdminCustomerController::class, 'GetUsersAll'])->name('all.users');
Route::get('/edit-manager/{id}', [AdminCustomerController::class, 'edit_manager'])->name('edit.manager');
Route::get('/loads/{id}/edit', [AdminCustomerController::class, 'AdmineditLoadDeliveredData'])->name('loads.edit.customer');
Route::put('/loads/{id}', [AdminCustomerController::class, 'updateLoadDeliveredData'])->name('loads.update.customer');
Route::get('/accounts-admin', [AdminCustomerController::class, 'accounting_admin'])->name('accounts.supper.admin');
Route::get('/customer-country-state-get', [AdminCustomerController::class, 'customerCountryStateGet'])->name('customer.country.state.get');
Route::match(['get', 'post'],'/customer-insert-by-admin', [AdminCustomerController::class, 'CustomerInsertByAdmin'])->name('customer.insert.by.admin');
Route::get('/all-load-status', [AdminCustomerController::class, 'AllBrokerLoadStatus'])->name('all.load.status');
Route::delete('delete/load/{id}', [AdminCustomerController::class, 'adminDestroyLoad'])->name('admin.destroy.load');
Route::delete('/user/{id}', [AdminCustomerController::class, 'destroy'])->name('user.destroy');
Route::put('/Update-Office-Status', [AdminCustomerController::class, 'updateOfficeStatus']);
Route::put('/admin-update-load-status-as-open/{id}', [AdminCustomerController::class, 'markAsOpen'])->name('admin.update.load.status.open');
Route::put('/admin-update-invoice-status-as-back-delivered/{id}', [AdminCustomerController::class, 'adminupdateInvoiceStatusAsBackDelivered']);
Route::post('/admin-update-invoice-status-as-back-complete/{id}', [AdminCustomerController::class, 'adminmarkAsBackCompleteRecord']);
Route::post('/admin-update-invoice-status-as-back-invoice/{id}', [AdminCustomerController::class, 'adminmarkAsBackInvoiceRecord']);
Route::post('/create-login', [AdminCustomerController::class, 'AccountsCreateLogin'])->name('create.new.login');
Route::get('/accounts-create-login', [AdminCustomerController::class, 'AccountsLoginCreatePage'])->name('accounts.create.new.login');
Route::get('/user-register-form', [AdminCustomerController::class, 'showRegistrationForm'])->name('user.register.form');
Route::post('/user-register', [AdminCustomerController::class, 'registerUser'])->name('user.register');
Route::post('/update-office-status/{id}', [AdminCustomerController::class, 'OfficeUpdateStatus'])->name('update.office.status');
Route::get('/admin/load/edit/{id}', [AdminCustomerController::class, 'AdminEditLoad'])->name('admin.load.edit');
Route::put('/admin/update/load/{id}', [AdminCustomerController::class, 'AdminUpdateLoad'])->name('admin.update.load');
Route::get('/its/data', [AdminCustomerController::class, 'itsData'])->name('its.data');
// Get Office details for editing
Route::get('/admin/office/edit/{id}', [AdminCustomerController::class, 'getOffices'])->name('admin.office.edit');
Route::delete('/customer/delete/{id}', [AdminCustomerController::class, 'destroyCustomer'])->name('customer.delete');
Route::delete('/carrier/delete/{id}', [AdminCustomerController::class, 'destroyCarrier'])->name('carrier.delete');

// Update Office details
Route::put('/admin/office/{id}', [AdminCustomerController::class, 'updateOffices'])->name('admin.office.update');
Route::get('/admin/compliance', [AdminCustomerController::class, 'accountsCompliance'])->name('admin.compliance');
Route::get('/admin/vendor', [AdminCustomerController::class, 'accountsvendorManagement'])->name('admin.vendor');
Route::get('/consignee/edit/{id}', [AdminCustomerController::class, 'consignee_edit'])->name('admin.consignee.edit');
Route::post('/consignee/update/{id}', [AdminCustomerController::class, 'consignee_update'])->name('admin.consignee.update');
Route::post('/user/change-password', [AdminCustomerController::class, 'changePassword'])->name('user.changePassword');


// Account Controller
Route::get('/account-login', [AccountController::class, 'AccountLogin'])->name('account.login');
Route::post('/login/auth', [AccountController::class, 'authenticate'])->name('account.login.auth');

// Route::get('/accounts', [AccountController::class, 'index'])->name('accounts')->middleware('auth.custom');
Route::get('/accounts-accounting', [AccountController::class, 'accounting'])->name('accounts');


Route::post('/account-logout', [AccountController::class, 'AccountLogout'])->name('account.logout');
Route::get('/account-admin-dashboard', [AccountController::class, 'AccountAdminDashboard'])->name('accounts.admin.dashboard');
Route::post('/update-invoice-status/{id}', [AccountController::class, 'updateInvoiceStatus'])->name('update.invoice.status');
Route::post('/update-invoice-status-as-completed/{id}', [AccountController::class, 'updateInvoiceStatusAsCompleted']);
Route::get('/loads/{id}/edit', [AccountController::class, 'editLoadDeliveredData'])->name('loads.edit');
Route::put('/loads/{id}', [AccountController::class, 'updateLoadDeliveredData'])->name('loads.update');
Route::post('/mark-invoice-as-paid/{id}', [AccountController::class, 'markInvoiceAsPaid']);
Route::post('/update-invoice-status-as-paid-record/{id}', [AccountController::class, 'updateInvoiceStatusAsPaidRecord']);
Route::get('/accounts/broker/status', [AccountController::class, 'accounts_broker_status'])->name('accounts.broker.status');
Route::get('/accounts/manager/dashboard', [AccountController::class, 'AccountsManagerDashboard'])->name('accounts.manager.dashboard');
Route::get('/fetch-customer-details-accounts', [AccountController::class, 'fetchCustomerDetailsAccount'])->name('fetch.customer.details.accounts');
Route::get('/fetch-shipper-details-accounts', [AccountController::class, 'fetchShipperDetailsAccounts'])->name('fetch.shipper.details.accounts');
Route::get('/fetch-consignee-details-account', [AccountController::class, 'fetchConsigneeDetailsAccount'])->name('fetch.consignee.details.account');
Route::get('/fetch-consignee-location', [AccountController::class, 'fetchConsigneeLocation'])->name('fetch.consignee.location');
Route::post('/update-load-status-as-open/{id}', [AccountController::class, 'markAsOpen'])->name('update.load.status.open');
Route::put('/update-invoice-status-as-back-delivered/{id}', [AccountController::class, 'updateInvoiceStatusAsBackDelivered']);
Route::post('/update-invoice-status-as-back-complete/{id}', [AccountController::class, 'markAsBackCompleteRecord']);
Route::post('/update-invoice-status-as-back-invoice/{id}', [AccountController::class, 'markAsBackInvoiceRecord']);
Route::get('/accounting/load/edit/{id}', [AccountController::class, 'AccountsEditLoad'])->name('accounting.load.edit');
Route::put('/accounting/update/load/{id}', [AccountController::class, 'AccountsUpdateLoad'])->name('accounting.update.load');
Route::get('/fetch-invoice-details', [AccountController::class, 'fetchInvoiceDetails'])->name('fetch.invoice.details');


Route::post('/accounts-invoice-mail', [AccountController::class, 'InvoiceMail'])->name('accounts.mail');
Route::get('/invoices/{id}/print/paid', [AccountController::class, 'printInvoicePaid'])->name('invoices.print.print');
Route::get('/print-invoice/{id}', [AccountController::class, 'printInvoice'])->name('print.invoice');
Route::post('/load/update-macro', [AccountController::class, 'updateMacro'])->name('load.updateMacro');
Route::get('get-compliance-data', [AccountController::class, 'getComplianceData'])->name('get.compliance.data');


// Example route in web.php
Route::get('invoice/{loadNumber}', [AccountController::class, 'printInvoice'])->name('invoice.print');


Route::post('/send-invoice-email', [AccountController::class, 'invoiceSendEmail'])->name('send.invoice.email');
Route::get('/vendor-management', [AccountController::class, 'vendorManagement'])->name('vendor.management');
Route::post('/update-load-date', [AccountController::class, 'updateLoadDate'])->name('update.load.date');
Route::post('/update-load-checkbox', [AccountController::class, 'updateLoadCheckbox'])->name('update.load.checkbox');
Route::post('/load/update-receiving-amount', [AccountController::class, 'updateReceivingAmount'])->name('load.updateReceivingAmount');
Route::get('/fetch-files/{loadNumber}', [AccountController::class, 'fetchFiles'])->name('fetch.files');
Route::post('/delete-file', [AccountController::class, 'deleteFile'])->name('delete.file');
Route::get('/compliance', [AccountController::class, 'compliance'])->name('compliance');
Route::get('/compliance/load/{id}', [AccountController::class, 'getComplianceLoadInfo'])->name('compliance.load.info');
Route::post('/save-carrier-checks', [AccountController::class, 'saveCarrierCheck'])->name('saveCarrierChecks');
Route::post('/save-load-checks', [AccountController::class, 'saveLoadCprCheck'])->name('savecprChecks');
Route::post('/updateLoadDetails', [AccountController::class, 'vendorUpdateLoadDetails'])->name('updateLoadDetails');
Route::post('/carrier/docs/fetch', [AccountController::class, 'fetchCarrierDocs'])->name('carrier.docs.fetch');
// web.php or api.php
// In routes/web.php
Route::post('/uploadCarrierDocs', [AccountController::class, 'uploadCarrierDocs']);
Route::post('/get-files', [AccountController::class, 'getFiles'])->name('get.files');
Route::post('/delete-carrier-doc', [AccountController::class, 'deleteCarrierDoc'])->name('delete.carrier.doc');
Route::post('/delete-selected-files', [AccountController::class, 'deleteSelectedFiles'])->name('delete.selected.files');

Route::delete('/deleteUploadedFile', [AccountController::class, 'deleteUploadedFile'])->name('deleteUploadedFile');
Route::get('/fetchUploadedFiles', [AccountController::class, 'fetchUploadedFiles'])->name('fetchUploadedFiles');
Route::get('/carrier/customers/alldetail', [AccountController::class, 'customerCarriersDetails'])->name('carrier.customers.alldetail');
Route::get('/files/{id}', [AccountController::class, 'getUploadedFiles'])->name('files.get');
Route::post('/save-internal-notes', [AccountController::class, 'saveInternalNotes']);
Route::put('/account-update-customer/{id}', [AccountController::class, 'accountupdateCustomer'])->name('account.update.customer');
Route::get('/account-edit-customer/{id}', [AccountController::class, 'accounteditCustomer'])->name('account.edit.customer');

Route::get('files/{filesId}/uploads', [FilesUploadController::class, 'index'])->name('files.upload');
Route::post('files/{filesId}/uploads', [FilesUploadController::class, 'uploadFiles'])->name('files.upload.post');
Route::get('/get-files/{recordId}', [FilesUploadController::class, 'getFiles']);
Route::post('/delete-file', [FilesUploadController::class, 'deleteFile']);
Route::get('/show-form', [FilesUploadController::class, 'showForm']);
Route::post('/merge-files', [FilesUploadController::class, 'mergeFiles'])->name('merge.files');
Route::post('/delete-file-broker', [FilesUploadController::class, 'deleteFilebroker'])->name('delete.file.broker');

Route::get('add-to-log', 'HomeController@myTestAddToLog');
Route::get('logActivity', 'HomeController@logActivity');

Route::get('mc', [McCheckController::class, 'mcCheck'])->name('mc');
Route::post('/mc-check', [McCheckController::class, 'mc_check'])->name('mc.check.store');


