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

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/changePassword', function () {
        return view('auth.passwords.changePassword');
    })->name('changePassword');
    Route::post('/updatePassword', 'UserController@changePassword')->name('updatePassword');

    Route::get('/edit-profile', function () {
        return view('auth.editUserProfile');
    })->name('edit-profile');
    Route::post('/edit-User-profile', 'UserController@editProfile')->name('edit-User-profile');

    Route::get('/show-user-profile/{user_id}', 'UserController@showProfile')->name('show-user-profile');

    Route::get('/home', 'PostController@index')->name('home');
    Route::get('/createPost', 'PostController@create')->name('createPost');
    Route::post('/storesPost', 'PostController@store')->name('storesPost');

    Route::get('/show/{post_id}', 'PostController@show')->name('show');
    Route::get('/showPost/{post_id}', 'PostController@showPost')->name('showPost');
    Route::post('/editPost', 'PostController@update')->name('editPost');
    Route::get('/deletePost/{post_id}', 'PostController@destroy')->name('deletePost');
    Route::post('/searchPost', 'PostController@search')->name('searchPost');

//Comment Route store comment && reply
    Route::post('/storesComment', 'CommentController@store')->name('storeComment');
    Route::post('/storeReply', 'CommentController@storeReply')->name('storeReply');

    Route::post('/like', 'LikeController@storelike')->name('like');
    Route::post('/getLike', 'LikeController@getByPostId')->name('getLike');

    Route::get('/contact-us',function (){
            return view('contact-us');
    })->name('contact-us');


});

