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

Route::get('/', function () {
    return redirect('/customers');
});

Route::get('/customers', 'CustomerController@index');
Route::get('/getCustomers', 'CustomerController@listCustomer');
Route::post('/createCustomer', 'CustomerController@store');
Route::get('/editCustomer/{id}', 'CustomerController@edit');
Route::put('/updateCustomer/{id}', 'CustomerController@update');