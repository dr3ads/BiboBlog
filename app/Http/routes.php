<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {
    //
    Route::auth();

    /*
    |--------------------------------------------------------------------------
    | Application Routes
    |--------------------------------------------------------------------------
    |
    | This route group applies the "web" middleware group to every route
    | it contains. The "web" middleware group is defined in your HTTP
    | kernel and includes session state, CSRF protection, and more.
    |
    */


    Route::get('/', 'BlogController@index');

    Route::get('blogs', 'BlogController@index');
    Route::get('blog/{slug}', 'BlogController@show');
    Route::group(['prefix' => 'blog', 'middleware' => 'auth'], function () {
        Route::get('create', 'BlogController@create');
        Route::post('store', 'BlogController@store');
        Route::get('edit/{id}', 'BlogController@edit');
        Route::post('edit/{id}', 'BlogController@update');
        Route::get('delete/{id}', 'BlogController@destroy');
        Route::post('comment', 'BlogController@commentStore');
    });
});

Route::group(['prefix' => 'auth'], function() {
    Route::post('signin', 'Api\ApiAuthController@signin');
});

Route::group(['prefix' => 'api', 'middleware' => ['api', 'jwt.auth']], function () {
    Route::get('get_all_blog', 'Api\ApiBlogController@index');
    Route::post('create', 'Api\ApiBlogController@create');
    Route::post('edit/{id}', 'Api\ApiBlogController@update');
    Route::post('delete/{id}', 'Api\ApiBlogController@destroy');

});