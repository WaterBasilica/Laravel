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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/serch', 'PostsController@serch');
Route::get('/', 'PostsController@index');
Route::get('/fromclick', 'PostsController@fromclick');
Route::get('/{userid}', 'PostsController@index');

Route::post('/deleteAccount','Auth\DeleteAccountController@deleteAccount')->name('deleteAccount');
// Route::get('/logout', 'HomeController@login');
// Route::get('/login', 'PostsController@index');
// Route::get('/posts/{id}', 'PostsController@show');
// Route::get('/{userid}/posts/{post}', 'PostsController@show2')->where('post','[0-9]+');
Route::get('/posts/{post}', 'PostsController@show')->where('post','[0-9]+');
// Route::get('/posts/{userid}/{post}', 'PostsController@show')->where('post','[0-9]+');
Route::get('/posts/create', 'PostsController@create');
Route::post('/posts', 'PostsController@store');
Route::get('/posts/{post}/edit', 'PostsController@edit');
Route::patch('/posts/{post}', 'PostsController@update');
Route::post('/posts/{post}/like', 'PostsController@goodCountsControll');
Route::post('/posts/{post}', 'PostsController@storeGoodCounts');
Route::delete('/posts/{post}', 'PostsController@destroy');
Route::delete('/posts/{post}/comments/{comment}', 'CommentsController@destroy');
// Route::delete('/posts/comments/{comment}', 'CommentsController@destroy2');
Route::post('/posts/{post}/comments', 'CommentsController@store');
Route::get('/image_input', 'ImageController@getImageInput');
Route::post('/image_confirm', 'ImageController@postImageConfirm');
Route::post('/image_complete', 'ImageController@postImageComplete');
