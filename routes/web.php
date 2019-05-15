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

Route::get('/language/{lang}', 'LocaleController@setLocale');
Route::get('/language.json', 'LocaleController@getJSON');

Route::post('/upload', 'DependencyUploadController@uploadFile');
Route::post('/publish', 'UploadController@publishGroup');

Route::get('/f/{slug}', 'DownloadController@getFile')->name('downloadFile');
Route::get('/g/{slug}', 'DownloadController@getGroup')->name('showGroup');
Route::get('/g/{slug}/dl', 'DownloadController@getGroupZip')->name('downloadGroup');
