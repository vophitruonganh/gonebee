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

Auth::routes();
Broadcast::routes();
//
Route::get('login/facebook', 'FacebookController@redirectToProvider')->name('login.facebook');
Route::get('login/facebook/callback', 'FacebookController@handleProviderCallback')->name('login.facebook.call');
Route::match(['get'],'{all}', function(){
    return view('layouts.index')->with('user',json_encode(Auth::user()));
})->where(['all' => '.*']);

Route::group(['prefix' => '/api/v1.0'], function (){
    Route::post('/developer/{a?}', 'IndexController@index');
    Route::post('/book/detail/{a?}', 'IndexController@index');
    Route::post('/book/give', 'BookController@create');
    Route::post('/book/category/{a?}', 'IndexController@index');
    Route::post('user/bookstore/{a?}', 'IndexController@index');
    Route::post('user/profile/{a?}', 'IndexController@index');
    Route::post('/books','BookController@getAllBook');
    Route::post('/books/{categoryID?}','BookController@getAllBookByCategory');
    Route::post('/category', 'CategoryController@all');
    Route::post('/category/{id?}', 'BookController@getBookByCategory');
    Route::post('/user/book/given','UserController@getMyGiven');
    Route::post('/user/book/request','UserController@getMyRequest');
    Route::post('/user/book/receive','UserController@getBookByReceive');
    Route::post('/user/book/received','UserController@getBookByReceived');
    

    Route::post('user/receive-book','UserController@receive');
    Route::post('/user/book/accept-give','UserController@acceptGiveBook');
    Route::post('/user/book/cancel-give','UserController@cancelGiveBook');
});

//Route::group(['middleware' => 'web'], function(){
//    Route::match(['get','post'],'/books','BookController@all');
//});
