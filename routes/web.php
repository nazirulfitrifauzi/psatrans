<?php

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

// Homepage
Route::get('/', 'DashboardController@redirect');

Auth::routes();

// Dashboard
Route::get('/dashboard', 'DashboardController@index')->name('home');
Route::get('ajaxdata/getDashboard1', 'AjaxdataController@getdashboard1')->name('ajaxdata.getdashboard1');
Route::get('ajaxdata/getDashboard2', 'AjaxdataController@getdashboard2')->name('ajaxdata.getdashboard2');
Route::get('ajaxdata/getDashboard3', 'AjaxdataController@getdashboard3')->name('ajaxdata.getdashboard3');
Route::get('ajaxdata/getDashboard4', 'AjaxdataController@getdashboard4')->name('ajaxdata.getdashboard4');
Route::get('/dashboard/consignmentHQ', 'DashboardController@consignmentHQ')->name('dashboard.consignmentHQ');
Route::get('/dashboard/consignmentSouth', 'DashboardController@consignmentSouth')->name('dashboard.consignmentSouth');
Route::get('/dashboard/consignmentNorth', 'DashboardController@consignmentNorth')->name('dashboard.consignmentNorth');
Route::get('/dashboard/outForDelivery', 'DashboardController@outForDelivery')->name('dashboard.outForDelivery');
Route::patch('/dashboard/consignmentHQ/{id}', 'DashboardController@updateconsignmentHQ')->name('dashboard.consignmentHQ.update');
Route::patch('/dashboard/consignmentSouth/{id}', 'DashboardController@updateconsignmentSouth')->name('dashboard.consignmentSouth.update');
Route::patch('/dashboard/consignmentNorth/{id}', 'DashboardController@updateconsignmentNorth')->name('dashboard.consignmentNorth.update');
Route::patch('/dashboard/OutForDelivery/{id}', 'DashboardController@updateOutForDelivery')->name('dashboard.OutForDelivery.update');
Route::get('/dashboard/download/{attachment}', 'DashboardController@downloadAttachment')->name('dashboard.downloadAttachment');
Route::post('/dashboard/driverOFD', 'DashboardController@downloadDriverOFD')->name('driverOFD.download');

// All about User
Route::resource('user', 'userController');
Route::get('ajaxdata/getDataUser', 'AjaxdataController@getdatauser')->name('ajaxdata.getdatauser');
Route::get('/user-activation', 'signupController@activateUser')->name('user-activation');
Route::resource('signup', 'signupController');

// Manifest
Route::resource('manifest', 'manifestController');
Route::post('manifest/search', 'manifestController@manifestSearch')->name('manifest.manifestSearch');

// Invoice
Route::resource('invoice', 'invoiceController');
Route::post('/invoice/download', 'invoiceController@download')->name('invoice.download');
Route::get('/reprint', 'invoiceController@reprint')->name('invoice.reprint');
Route::post('/reprint/download', 'invoiceController@redownload')->name('invoice.redownload');

// Report
Route::resource('report', 'reportController');
Route::get('ajaxdata/getDataReport', 'AjaxdataController@getdatareport')->name('ajaxdata.getdatareport');
Route::get('ajaxdata/getDataReportUnpaid', 'AjaxdataController@getdatareport_unpaid')->name('ajaxdata.getdatareport_unpaid');
Route::get('statement', 'reportController@statement')->name('report.statement');
Route::post('statement/search', 'reportController@statementSearch')->name('report.statementSearch');

// Tracking
Route::resource('tracking', 'trackingController');
Route::post('/tracking/search', 'trackingController@search')->name('tracking.search');
Route::get('ajaxdata/getDataTracking', 'AjaxdataController@getdatatracking')->name('ajaxdata.getdatatracking');

// Call Log
Route::resource('call', 'callController');
Route::get('ajaxdata/getDataCall', 'AjaxdataController@getdatacall')->name('ajaxdata.getdatacall');

// Company
Route::resource('company-setup', 'companyController');

// Parameter
Route::resource('parameter', 'parameterController');

// Shipping
Route::resource('shipping', 'shippingController');
Route::post('/shipping/search', 'shippingController@search')->name('shipping.search');
Route::get('ajaxdata/getDataShipping', 'AjaxdataController@getdatashipping')->name('ajaxdata.getdatashipping');

// Destination
Route::resource('destination', 'destinationController');
Route::post('/destination/search', 'destinationController@search')->name('destination.search');
Route::get('ajaxdata/getDataDestination', 'AjaxdataController@getdatadestination')->name('ajaxdata.getdatadestination');

// Charges
Route::resource('charges', 'chargesController');
Route::post('/charges/search', 'chargesController@search')->name('charges.search');
Route::post('/charges/update-charges', 'chargesController@updateCharges')->name('charges.updateall');

// Transaction
Route::resource('consignment', 'consignmentController');
Route::post('/consignment/search', 'consignmentController@search')->name('consignment.search');
Route::get('ajaxdata/getChargesDestination', 'AjaxdataController@getchargesdestination')->name('ajaxdata.getchargesdestination');
Route::get('ajaxdata/getChargesData', 'AjaxdataController@getchargesdata')->name('ajaxdata.getchargesdata');

// Task List
Route::resource('task', 'taskController');
Route::get('ajaxdata/getDataTask', 'AjaxdataController@getdatatask')->name('ajaxdata.getdatatask');

// Log history
Route::get('/loghistory', 'DashboardController@log')->name('log');
Route::get('ajaxdata/getDataLog', 'AjaxdataController@getdatalog')->name('ajaxdata.getdatalog');

// create symlink
/*
Route::get('/foo', function(){
    Artisan::call('storage:link');
});
*/
