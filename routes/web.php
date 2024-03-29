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

Route::get('/', 'ThreadController@index');

Auth::routes();

Route::view('scan', 'scan');
// Route::get('home', 'HomeController@index')->name('home');
Route::get('threads', 'ThreadController@index');
Route::get('threads/create', 'ThreadController@create')->middleware('confirm-email');
Route::get('threads/search', 'SearchController@show');
Route::get('threads/{channel}', 'ThreadController@index');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::patch('threads/{channel}/{thread}', 'ThreadController@update');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('threads', 'ThreadController@store')->middleware('confirm-email');
Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store');

Route::patch('threads/{channel}/{thread}', 'ThreadController@update')->name('threads.update');

Route::post('locked-threads/{thread}', 'LockedThreadController@store')->name('locked-threads.store')->middleware('administrator');
Route::delete('locked-threads/{thread}', 'LockedThreadController@destroy')->name('locked-threads.store')->middleware('administrator');


Route::post('threads/{channel}/{thread}/subscribtions', 'ThreadSubscriptionController@store')->middleware('auth');
Route::delete('threads/{channel}/{thread}/subscribtions', 'ThreadSubscriptionController@destroy')->middleware('auth');

Route::post('replies/{reply}/favorites', 'FavoriteController@store');
Route::delete('replies/{reply}/favorites', 'FavoriteController@destroy');
Route::patch('replies/{reply}', 'ReplyController@update');
Route::delete('replies/{reply}', 'ReplyController@destroy')->name('replies.destory');

Route::post('replies/{reply}/best', 'BestReplyController@store');

Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');
Route::get('/profiles/{user}/notifications', 'UserNotificationController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy');

Route::get('/confirmation', 'Auth\RegisterConfirmationController@confirmation');

// API Routes
Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');

Route::get('/api/users', 'Api\UserController@index');
Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')->name('avatar');
