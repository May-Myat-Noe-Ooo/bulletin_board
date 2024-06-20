<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PostlistController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AuthController;

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

Route::middleware(['auth'])->group(function () {
    Route::resource('postlist', PostlistController::class);

});

//Route::resource('/login', UsersController::class);

// Authentication required for post list
// Route::middleware(['auth'])->group(function () {
//     Route::get('/postlist', [PostlistController::class, 'index'])->name('postlist');
// });

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    // Authentication routes
    Route::get('/login', 'UsersController@index')->name('login.index');
    Route::post('/login', 'UsersController@login')->name('login.store');
    Route::get('/logout', 'UsersController@logout')->name('logout');
    Route::get('/signup', 'UsersController@signup')->name('signup.form');
    Route::post('/signup', 'UsersController@signupSave')->name('signup.save');
    // Post creation routes
    Route::get('/createpost', 'PostsController@createPost')->name('createpost');
    Route::post('/createconfirm', 'PostsController@confirmPost')->name('confirm');
    Route::post('/store', 'PostsController@store')->name('store');
    // Post editing routes
    Route::get('/editpost/{id}', 'PostsController@editPost')->name('edit');
    Route::post('/confirm/{id}', 'PostsController@confirmEditPost')->name('editconfirm');
    // Post soft deleting routes
    Route::delete('/postlists/{id}/destroy', [PostlistController::class, 'destroy'])->name('postlist.destroy');
    //Player routes
    Route::get('/createuser', 'UsersController@createUser');
    Route::post('/registerconfirm', 'UsersController@confirmRegister')->name('registerconfirm');
    Route::post('/storeregisteruser', 'UsersController@storeRegisterUser')->name('storeuser');

    Route::get('/displayuser', 'UsersController@displayUser')->name('displayuser');

    Route::get('/showprofile', 'UsersController@showProfile');
    Route::post('/editprofile', 'UsersController@editProfile')->name('editprofile');

    Route::get('/change_password', 'UsersController@changePassword')->name('change_password');
    Route::get('/forgot_password', 'UsersController@forgotPassword')->name('forgot_password');
    Route::get('/reset_password', 'UsersController@resetPassword')->name('reset_password');

    Route::get('/upload_file', 'PostsController@uploadFile')->name('upload_file');
    Route::post('/upload-csv', 'PostsController@uploadCsv')->name('upload_csv');
    Route::get('/postlists/export', 'PostsController@export')->name('postlists.export');
});
