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
    Route::group(['namespace' => 'App\Http\Controllers'], function (){
        Route::get('/displayuser', 'UsersController@displayUser')->name('displayuser');
    });
    
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
    // Post hard deleting routes
    Route::delete('/postlists/{id}/destroy', [PostlistController::class, 'destroy'])->name('postlist.destroy');
    // User soft deleting routes
    Route::delete('/users/{id}/destroy', [UsersController::class, 'destroy'])->name('user.destroy');
    //Player routes
    Route::get('/createuser', 'UsersController@createUser')->name('registeruser');
    Route::post('/registerconfirm', 'UsersController@confirmRegister')->name('registerconfirm');
    Route::post('/store-registeruser', 'UsersController@storeRegisterUser')->name('storeRegisterUser');

    // Route::get('/displayuser', 'UsersController@displayUser')->name('displayuser');

    Route::get('/showprofile/{id}', 'UsersController@showProfile')->name('showprofile');
    Route::post('/editprofile/{id}', 'UsersController@editProfile')->name('editprofile');
    // Route::post('/updateprofile/{id}', 'UsersController@update')->name('update_profile');
    Route::patch('/updateprofile/{id}', [UsersController::class, 'updateProfile'])->name('updateprofile');

    //User Password Changing
    Route::get('/change_password/{id}', 'UsersController@changePassword')->name('change_password');
    Route::post('/change_password/{id}', 'UsersController@updatePassword')->name('update_password');

    Route::get('/forgot_password', 'UsersController@forgotPassword')->name('forgot_password');
    Route::get('/reset_password', 'UsersController@resetPassword')->name('reset_password');

    Route::get('/upload_file', 'PostsController@uploadFile')->name('upload_file');
    Route::post('/upload-csv', 'PostsController@uploadCsv')->name('upload_csv');
    Route::get('/postlists/export', 'PostsController@export')->name('postlists.export');
});
