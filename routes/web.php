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
use App\Province;
use App\Sector;
use App\Cell;
use App\District;




Route::get('/', function () {
    return view('welcome');
});

// Route::get('/create', function () {
//     return view('payments.create');
// });
Route::get('/show', function () {
    return view('show');
});
Route::get('/addresscart', function () {
    return view('addresscart');
});

Route::get('/form', function () {
    return view('form');
});

Auth::routes();

# view routes
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/view/{id}', 'ViewController@show')->name('get_view');
Route::post('/view/{id}', 'ViewController@store')->name('set_view');


# service routes
Route::get('/service/create/{house_id}', 'ServiceController@create')->name('create_service');
Route::post('/service', 'ServiceController@store')->name('store_service');
Route::post('/service/callback/{service_id}', 'ServiceController@callback')->name('callback_service');
Route::get('/service/{service_id}', 'ServiceController@show')->name('show_service');
Route::post('/service/{service_id}', 'ServiceController@update')->name('update_service');

# location routes
Route::get('/provinces/{id}', function($id) {
  echo (json_encode(Province::where('country_id', $id)->get()));
        
})->name('get_provinces');
Route::get('/districts/{id}', function($id) {
  echo (json_encode(District::where('province_id', $id)->get()));
})->name('get_districts');
Route::get('/sectors/{id}', function($id) {
  echo (json_encode(Sector::where('district_id', $id)->get()));
})->name('get_sectors') ;
Route::get('/cells/{id}', function($id) {
  echo (json_encode(Cell::where('sector_id', $id)->get()));
})->name('get_cells') ;

# admin routes
Route::prefix('admin')->group(function () {
    
    # house controller
    Route::resource('houses', 'AdminHouseController');
    Route::get('/houses/delete/{id}', 'AdminHouseController@delete')->name('admin.houses.delete');
    
    # uploads controller
    Route::get('/uploads/{house_id}', 'AdminUploadsController@index')->name('admin.uploads.index');
    Route::get('/uploads/{house_id}/create', 'AdminUploadsController@create')->name('admin.uploads.create') ;
    Route::post('/uploads', 'AdminUploadsController@store')->name('admin.uploads.store') ;
    Route::delete('/uploads/{id}', 'AdminUploadsController@destroy')->name('admin.uploads.delete') ;
    
});

# houseOwner routes
Route::group(['prefix' => 'owner', 'middleware' =>'auth'], function(){
    
  # house controller
  Route::resource('houses', 'OwnerHouseController');
  Route::get('/houses/delete/{id}', 'OwnerHouseController@delete')->name('owner.houses.delete');
  
  # uploads controller
  Route::get('/uploads/{house_id}', 'OwnerUploadsController@index')->name('owner.uploads.index');
  Route::get('/uploads/{house_id}/create', 'OwnerUploadsController@create')->name('owner.uploads.create') ;
  Route::post('/uploads', 'OwnerUploadsController@store')->name('owner.uploads.store') ;
  Route::delete('/uploads/{id}', 'OwnerUploadsController@destroy')->name('owner.uploads.delete') ;
  
  #report  
  Route::resource('reports', 'ReportsController');  

  #message
  Route::get('message', 'MessagesController@create');
  Route::post('message', 'MessagesController@saveMessage');

    
});

// Route::get('/home', 'HomeController@index');
Route::get('/payments', 'PaymentController@create');
Route::post('/payments', 'PaymentController@store');
Route::get('/index', 'PaymentController@view');
Route::get('/test', 'PaymentController@store');

Route::get('/paymentmode', 'PaymentModeController@create');
Route::post('/paymentmode', 'PaymentModeController@store');
Route::get('/indexx', 'PaymentModeController@index');
Route::get('/edit', 'PaymentModeController@edit');
Route::get('/del', 'PaymentModeController@destroy');

#MASTER LAYOUT
Route::get('/master', function(){
    return view('layouts.master');
    });