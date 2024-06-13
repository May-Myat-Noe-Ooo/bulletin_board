<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostlistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/login', UsersController::class);
Route::resource('/postlist', PostlistController::class);

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/createpost', 'PostsController@createPost');
    Route::post('/createconfirm', 'PostsController@confirmPost')->name('confirm');
    Route::post('/store', 'PostsController@store')->name('store');

    Route::get('/editpost/{id}', 'PostsController@editPost')->name('edit');
    Route::post('/confirm/{id}', 'PostsController@confirmEditPost')->name('editconfirm');

    Route::get('/createuser', 'UsersController@createUser');
    Route::post('/registerconfirm', 'UsersController@confirmRegister')->name('registerconfirm');
    Route::post('/storeregisteruser', 'UsersController@storeRegisterUser')->name('storeuser');

    Route::get('/displayuser', 'UsersController@displayUser')->name('displayuser');

    Route::get('/showprofile', 'UsersController@showProfile');
    Route::post('/editprofile', 'UsersController@editProfile')->name('editprofile');

    Route::get('/change_password', 'UsersController@changePassword')->name('change_password');
    Route::get('/forgot_password', 'UsersController@forgotPassword')->name('forgot_password');
    Route::get('/reset_password', 'UsersController@resetPassword')->name('reset_password');
});
