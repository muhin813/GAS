<?php

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

/*
 * User auth route
 * */
Route::get('registration', 'RegistrationController@index');
Route::post('registration/store', 'RegistrationController@store');

//Route::get('login', 'AuthenticationController@login')->name('login');
//Route::post('post_login', 'AuthenticationController@postLogin');
Route::get('logout', 'AuthenticationController@logout');

Route::get('login', 'AuthenticationController@login')->name('login');
Route::post('crm/post_login', 'AuthenticationController@postLogin');
//Route::get('crm/logout', 'AuthenticationController@logout');

Route::get('admin/login', 'AuthenticationController@adminLogin');
Route::post('admin/post_login', 'AuthenticationController@adminPostLogin');
//Route::get('admin/logout', 'AuthenticationController@adminLogout');

Route::get('error_404', 'ErrorController@error404');


Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/home', 'Customer\HomeController@index')->name('home');
Route::get('/crm', 'Customer\HomeController@index')->name('crm');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('profile', 'UserController@profile')->name('profile');
Route::get('reset-password', 'UserController@resetPassword')->name('reset-password');
Route::post('update_user', 'UserController@update');
Route::post('update_password', 'UserController@updatePassword');

Route::get('customer_packages', 'Customer\PackageController@index');

Route::get('service_bookings', 'ServiceController@serviceBookingIndex');
Route::get('service_bookings/create', 'ServiceController@serviceBookingcreate');
Route::post('service_bookings/store', 'ServiceController@serviceBookingstore');
Route::get('service_bookings/{id}', 'ServiceController@serviceBookingedit');
Route::post('service_bookings/update', 'ServiceController@serviceBookingupdate');
Route::post('service_bookings/delete', 'ServiceController@serviceBookingdelete');

Route::get('customers', 'CustomerController@index');
Route::get('customers/create', 'CustomerController@create');
Route::post('customers/store', 'CustomerController@store');
Route::get('customers/{id}', 'CustomerController@edit');
Route::post('customers/update', 'CustomerController@update');
Route::post('customers/delete', 'CustomerController@delete');
Route::post('customers/get_vehicles', 'CustomerController@getVehicles');

Route::get('suppliers', 'SupplierController@index');
Route::get('suppliers/create', 'SupplierController@create');
Route::post('suppliers/store', 'SupplierController@store');
Route::get('suppliers/{id}', 'SupplierController@edit');
Route::post('suppliers/update', 'SupplierController@update');
Route::post('suppliers/delete', 'SupplierController@delete');

Route::get('service_categories', 'ServiceController@serviceCategoryIndex');
Route::get('service_categories/create', 'ServiceController@serviceCategoryCreate');
Route::post('service_categories/store', 'ServiceController@serviceCategoryStore');
Route::get('service_categories/{id}', 'ServiceController@serviceCategoryEdit');
Route::post('service_categories/update', 'ServiceController@serviceCategoryUpdate');
Route::post('service_categories/delete', 'ServiceController@serviceCategoryDelete');

Route::get('service_types', 'ServiceController@serviceTypeIndex');
Route::get('service_types/create', 'ServiceController@serviceTypeCreate');
Route::post('service_types/store', 'ServiceController@serviceTypeStore');
Route::get('service_types/{id}', 'ServiceController@serviceTypeEdit');
Route::post('service_types/update', 'ServiceController@serviceTypeUpdate');
Route::post('service_types/delete', 'ServiceController@serviceTypeDelete');
Route::post('get_service_type_by_category', 'ServiceController@getServiceTypeByCategory');

Route::get('items', 'ItemController@index');
Route::get('items/create', 'ItemController@create');
Route::post('items/store', 'ItemController@store');
Route::get('items/{id}', 'ItemController@edit');
Route::post('items/update', 'ItemController@update');
Route::post('items/delete', 'ItemController@delete');

Route::get('item_uoms', 'ItemController@itemUomIndex');
Route::get('item_uoms/create', 'ItemController@itemUomCreate');
Route::post('item_uoms/store', 'ItemController@itemUomStore');
Route::get('item_uoms/{id}', 'ItemController@itemUomEdit');
Route::post('item_uoms/update', 'ItemController@itemUomUpdate');
Route::post('item_uoms/delete', 'ItemController@itemUomDelete');

Route::get('item_categories', 'ItemController@itemCategoryIndex');
Route::get('item_categories/create', 'ItemController@itemCategoryCreate');
Route::post('item_categories/store', 'ItemController@itemCategoryStore');
Route::get('item_categories/{id}', 'ItemController@itemCategoryEdit');
Route::post('item_categories/update', 'ItemController@itemCategoryUpdate');
Route::post('item_categories/delete', 'ItemController@itemCategoryDelete');

Route::get('packages', 'PackageController@index');
Route::get('packages/create', 'PackageController@create');
Route::post('packages/store', 'PackageController@store');
Route::get('packages/{id}', 'PackageController@edit');
Route::post('packages/update', 'PackageController@update');
Route::post('packages/delete', 'PackageController@delete');
Route::post('packages/get_details', 'PackageController@getDetails');

Route::get('package_uoms', 'PackageController@packageUomIndex');
Route::get('package_uoms/create', 'PackageController@packageUomCreate');
Route::post('package_uoms/store', 'PackageController@packageUomStore');
Route::get('package_uoms/{id}', 'PackageController@packageUomEdit');
Route::post('package_uoms/update', 'PackageController@packageUomUpdate');
Route::post('package_uoms/delete', 'PackageController@packageUomDelete');

Route::get('purchases', 'PurchaseController@index');
Route::get('purchases/create', 'PurchaseController@create');
Route::post('purchases/store', 'PurchaseController@store');
Route::post('purchases/get_details', 'PurchaseController@getDetails');
Route::get('purchases/{id}', 'PurchaseController@edit');
Route::post('purchases/update', 'PurchaseController@update');
Route::post('purchases/delete', 'PurchaseController@delete');

Route::get('sales', 'SaleController@index');
Route::get('sales/create', 'SaleController@create');
Route::post('sales/store', 'SaleController@store');
Route::post('sales/get_details', 'SaleController@getDetails');
Route::post('sales/get_costing_details', 'SaleController@getCostingDetails');
Route::post('sales/store_costing', 'SaleController@storeCosting');
Route::get('sales/{id}', 'SaleController@edit');
Route::post('sales/update', 'SaleController@update');
Route::post('sales/delete', 'SaleController@delete');
Route::get('service_sales_report', 'SaleController@serviceSalesReport');
Route::get('product_sales_report', 'SaleController@productSalesReport');

Route::get('stock_record', 'InventoryController@stockRecord');

Route::get('stock_issues', 'InventoryController@stockIssueIndex');
Route::get('stock_issues/create', 'InventoryController@stockIssueCreate');
Route::post('stock_issues/store', 'InventoryController@stockIssueStore');
Route::get('stock_issues/{id}', 'InventoryController@stockIssueEdit');
Route::post('stock_issues/update', 'InventoryController@stockIssueUpdate');
Route::post('stock_issues/delete', 'InventoryController@stockIssueDelete');
Route::post('stock_issues/get_purchase_details', 'InventoryController@getPurchaseDetails');

Route::get('stock_returns', 'InventoryController@stockReturnIndex');
Route::get('stock_returns/create', 'InventoryController@stockReturnCreate');
Route::post('stock_returns/store', 'InventoryController@stockReturnStore');
Route::get('stock_returns/{id}', 'InventoryController@stockReturnEdit');
Route::post('stock_returns/update', 'InventoryController@stockReturnUpdate');
Route::post('stock_returns/delete', 'InventoryController@stockReturnDelete');

Route::get('cash_books', 'AccountController@cashBook');
Route::get('cash_books/create', 'AccountController@cashBookCreate');
Route::post('cash_books/store', 'AccountController@cashBookStore');
Route::get('cash_books/{id}', 'AccountController@cashBookEdit');
Route::post('cash_books/update', 'AccountController@cashBookUpdate');
Route::post('cash_books/delete', 'AccountController@cashBookDelete');

Route::get('bank_books', 'AccountController@bankBook');
Route::get('bank_books/create', 'AccountController@bankBookCreate');
Route::post('bank_books/store', 'AccountController@bankBookStore');
Route::post('bank_books/get_cheques_by_month', 'AccountController@getBankBookByMonth');
Route::get('bank_books/{id}', 'AccountController@bankBookEdit');
Route::post('bank_books/update', 'AccountController@bankBookUpdate');
Route::post('bank_books/delete', 'AccountController@bankBookDelete');

Route::get('bank_reconciliations', 'AccountController@bankReconciliation');
Route::get('bank_reconciliations/create', 'AccountController@bankReconciliationCreate');
Route::post('bank_reconciliations/store', 'AccountController@bankReconciliationStore');
Route::post('bank_reconciliations/get_details', 'AccountController@getDetails');
Route::get('bank_reconciliations/{id}', 'AccountController@bankReconciliationEdit');
Route::post('bank_reconciliations/update', 'AccountController@bankReconciliationUpdate');
Route::post('bank_reconciliations/delete', 'AccountController@bankReconciliationDelete');

Route::get('supplier_payments', 'AccountController@supplierPayment');
Route::get('supplier_payments/create', 'AccountController@supplierPaymentCreate');
Route::post('supplier_payments/store', 'AccountController@supplierPaymentStore');
Route::get('supplier_payments/{id}', 'AccountController@supplierPaymentEdit');
Route::post('supplier_payments/update', 'AccountController@supplierPaymentUpdate');
Route::post('supplier_payments/delete', 'AccountController@supplierPaymentDelete');

Route::get('other_payments', 'AccountController@otherPayment');
Route::get('other_payments/create', 'AccountController@otherPaymentCreate');
Route::post('other_payments/store', 'AccountController@otherPaymentStore');
Route::get('other_payments/{id}', 'AccountController@otherPaymentEdit');
Route::post('other_payments/update', 'AccountController@otherPaymentUpdate');
Route::post('other_payments/delete', 'AccountController@otherPaymentDelete');

Route::get('income_taxes', 'AccountController@incomeTax');
Route::get('income_taxes/create', 'AccountController@incomeTaxCreate');
Route::post('income_taxes/store', 'AccountController@incomeTaxStore');
Route::post('income_taxes/update', 'AccountController@incomeTaxUpdate');
Route::get('income_taxes/{id}', 'AccountController@incomeTaxEdit');
Route::post('income_taxes/delete', 'AccountController@incomeTaxDelete');

Route::get('monthly_profit_losses', 'AccountController@monthlyProfitLoss');

Route::get('job_wise_profitabilities', 'AccountController@jobWiseProfitability');
Route::get('job_wise_profitabilities/create', 'AccountController@jobWiseProfitabilityCreate');
Route::post('job_wise_profitabilities/store', 'AccountController@jobWiseProfitabilityStore');
Route::get('job_wise_profitabilities/{id}', 'AccountController@jobWiseProfitabilityEdit');
Route::post('job_wise_profitabilities/update', 'AccountController@jobWiseProfitabilityUpdate');
Route::post('job_wise_profitabilities/delete', 'AccountController@jobWiseProfitabilityDelete');

//Route::get('cost_of_sales', 'AccountController@costOfSale');

Route::get('banks','BankController@index');
Route::get('banks/create', 'BankController@create');
Route::post('banks/store', 'BankController@store');
Route::post('banks/update', 'BankController@update');
Route::get('banks/{id}', 'BankController@edit');
Route::post('banks/delete', 'BankController@delete');

Route::get('bank_branches','BankController@bankBranch');
Route::get('bank_branches/create', 'BankController@bankBranchCreate');
Route::post('bank_branches/store', 'BankController@bankBranchStore');
Route::post('bank_branches/update', 'BankController@bankBranchUpdate');
Route::get('bank_branches/{id}', 'BankController@bankBranchEdit');
Route::post('bank_branches/delete', 'BankController@bankBranchDelete');

Route::get('bank_accounts','BankController@bankAccount');
Route::get('bank_accounts/create', 'BankController@bankAccountCreate');
Route::post('bank_accounts/store', 'BankController@bankAccountStore');
Route::post('bank_accounts/update', 'BankController@bankAccountUpdate');
Route::get('bank_accounts/{id}', 'BankController@bankAccountEdit');
Route::post('bank_accounts/delete', 'BankController@bankAccountDelete');

Route::get('cheque_books','BankController@chequeBook');
Route::get('cheque_books/create', 'BankController@chequeBookCreate');
Route::post('cheque_books/store', 'BankController@chequeBookStore');
Route::post('cheque_books/update', 'BankController@chequeBookUpdate');
Route::get('cheque_books/{id}', 'BankController@chequeBookEdit');
Route::post('cheque_books/delete', 'BankController@chequeBookDelete');

Route::get('party_categories','BankController@partyCategories');
Route::get('party_categories/create', 'BankController@partyCategoryCreate');
Route::post('party_categories/store', 'BankController@partyCategoryStore');
Route::post('party_categories/update', 'BankController@partyCategoryUpdate');
Route::get('party_categories/{id}', 'BankController@partyCategoryEdit');
Route::post('party_categories/delete', 'BankController@partyCategoryDelete');

Route::get('parties','BankController@parties');
Route::get('parties/create', 'BankController@partyCreate');
Route::post('parties/store', 'BankController@partyStore');
Route::post('parties/update', 'BankController@partyUpdate');
Route::get('parties/{id}', 'BankController@partyEdit');
Route::post('parties/delete', 'BankController@partyDelete');

Route::get('bookings','OperationController@booking');
Route::get('bookings/{id}', 'OperationController@bookingEdit');
Route::post('bookings/update', 'OperationController@bookingUpdate');
Route::post('bookings/delete', 'OperationController@bookingDelete');

Route::get('jobs','OperationController@job');
Route::get('jobs/create', 'OperationController@jobCreate');
Route::post('jobs/store', 'OperationController@jobStore');
Route::post('jobs/update', 'OperationController@jobUpdate');
Route::get('jobs/{id}', 'OperationController@jobEdit');
Route::post('jobs/delete', 'OperationController@jobDelete');

Route::get('job_duration_trackings','OperationController@jobDurationTracking');

Route::get('mechanics', 'SettingController@mechanic');
Route::get('mechanics/create', 'SettingController@mechanicCreate');
Route::post('mechanics/store', 'SettingController@mechanicStore');
Route::get('mechanics/{id}', 'SettingController@mechanicEdit');
Route::post('mechanics/update', 'SettingController@mechanicUpdate');
Route::post('mechanics/delete', 'SettingController@mechanicDelete');

Route::get('users', 'UserController@index');
Route::get('users/create', 'UserController@create');
Route::post('users/store', 'UserController@store');
Route::get('users/{id}', 'UserController@edit');
Route::post('users/update', 'UserController@update');
Route::post('users/delete', 'UserController@delete');

Route::get('general_settings', 'SettingController@generalSetting');
Route::post('general_settings/update', 'SettingController@generalSettingUpdate');
