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
    return view('welcome');
});
Route::get('companies', 'AjaxdataController@index')->name('ajaxdata');
Route::get('employees', 'AjaxdataController@indexx')->name('ajaxdata1');
Route::get('companies/getdata', 'AjaxdataController@getdata')->name('ajaxdata.getdata');
Route::get('employees/getdata1', 'AjaxdataController@getdata1')->name('ajaxdata1.getdata1');
Route::post('companies/postdata', 'AjaxdataController@postdata')->name('ajaxdata.postdata');
Route::post('employees/postdata1', 'AjaxdataController@postdata1')->name('ajaxdata1.postdata1');
Route::get('companies/fetchdata', 'AjaxdataController@getdata')->name('ajaxdata.fetchdata');
Route::get('employees/fetchdata1', 'AjaxdataController@getdata1')->name('ajaxdata1.fetchdata1');
Route::get('companies/removedata', 'AjaxdataController@removedata')->name('ajaxdata.removedata');
Route::get('/uploadfile', 'UploadfileController@index');
Route::post('/uploadfile', 'UploadfileController@upload');
Route::get('/main', 'MainController@index');
Route::post('/main/checklogin', 'MainController@checklogin');
Route::get('main/successlogin', 'MainController@successlogin');
Route::get('main/logout', 'MainController@logout');

