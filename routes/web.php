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
Route::get('login', 'AuthenticationController@login');
Route::post('post_login', 'AuthenticationController@postLogin');
Route::get('logout', 'AuthenticationController@logout');

Route::get('error_404', 'ErrorController@error404');

Auth::routes();

Route::get('/', 'HomeController@index');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('profile', 'UserController@profile')->name('profile');
Route::get('reset-password', 'UserController@resetPassword')->name('reset-password');
Route::post('update_user', 'UserController@update');
Route::post('update_password', 'UserController@updatePassword');

Route::get('users', 'UserController@index');
Route::get('users/create', 'UserController@create');
Route::post('users/store', 'UserController@store');
Route::get('users/{id}', 'UserController@edit');
Route::post('users/update', 'UserController@update');
Route::post('users/delete', 'UserController@delete');

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

Route::get('item_uoms', 'ItemController@itemUomIndex');
Route::get('item_uoms/create', 'ItemController@itemUomCreate');
Route::post('item_uoms/store', 'ItemController@itemUomStore');
Route::get('item_uoms/{id}', 'ItemController@itemUomEdit');
Route::post('item_uoms/update', 'ItemController@itemUomUpdate');
Route::post('item_uoms/delete', 'ItemController@itemUomDelete');

Route::get('package_uoms', 'PackageController@packageUomIndex');
Route::get('package_uoms/create', 'PackageController@packageUomCreate');
Route::post('package_uoms/store', 'PackageController@packageUomStore');
Route::get('package_uoms/{id}', 'PackageController@packageUomEdit');
Route::post('package_uoms/update', 'PackageController@packageUomUpdate');
Route::post('package_uoms/delete', 'PackageController@packageUomDelete');


Route::get('cost_of_sales', 'AccountController@costOfSale');
