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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['namespace' => 'Frontend'], function () {
    Route::get('', 'HomeController@index')->name('home');
    Route::get('trending', 'HomeController@trending')->name('trending');
    Route::get('archives', 'HomeController@archives')->name('archives');
    Route::get('archives/{slug}', 'HomeController@single_archive')->name('archives.single');

    Route::post('', 'PasteController@store')->name('paste.store');
    Route::get('pastes/{paste}', 'PasteController@show')->name('paste.show');
    Route::get('raw/{paste}', 'PasteController@raw')->name('paste.raw');
    Route::get('download/{paste}', 'PasteController@download')->name('paste.download');
    Route::get('clone/{paste}', 'PasteController@clone')->name('paste.clone');
    Route::get('embed/{paste}', 'PasteController@embed')->name('paste.embed');
    Route::post('report/{paste}', 'PasteController@report')->name('paste.report');
    Route::get('print/{paste}', 'PasteController@print')->name('paste.print');

    Route::group(['middleware' => ['auth']], function () {
        Route::get('my-pastes', 'UserController@my_pastes')->name('my.pastes');
        Route::get('my-profile', 'UserController@edit')->name('my.profile');
        Route::post('my-profile', 'UserController@update')->name('my.profile.update');


        Route::get('paste/{paste}/edit', 'PasteController@edit')->name('paste.edit');
        Route::post('paste/{paste}/edit', 'PasteController@update')->name('paste.update');
        Route::get('paste/{paste}/delete', 'PasteController@destroy')->name('paste.destroy');
    });
});