<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/anwser', 'FrontController@getAnwser');
Route::post('/get-user', 'FrontController@getUser');
Route::post('/anwser', 'FrontController@postAnwser')->name('anwser.post');

Route::get('/login', 'UserController@getLogin')->name('users.getLogin')->middleware('guest');
Route::post('/', 'UserController@postLogin')->name('users.postLogin');
Route::get('/', 'UserController@getLogout')->name('users.getLogout');

Route::prefix('admin')->middleware(['auth'])->group(function () {

//    Users
//     Route::prefix('users')->group(function(){
//         Route::get('/', 'UserController@index')->name('users');
//         Route::get('/create', 'UserController@create')->name('user.create');
//         Route::get('/edit/{id}', 'UserController@edit')->name('user.edit');
//         Route::post('/store', 'UserController@store')->name('user.store');
//         Route::put('/update/{id}', 'UserController@update')->name('user.update');
//         Route::delete('/delete/{id}', 'UserController@destroy')->name('user.destroy');
//     });

// //    Category
//     Route::prefix('categories')->group(function(){
//         Route::get('/', 'CategoryController@index')->name('categories');
//         Route::get('/create', 'CategoryController@create')->name('category.create');
//         Route::get('/edit/{id}', 'CategoryController@edit')->name('category.edit');
//         Route::post('/store', 'CategoryController@store')->name('category.store');
//         Route::put('/update/{id}', 'CategoryController@update')->name('category.update');
//         Route::delete('/destroy/{id}', 'QuestionController@destroy')->name('category.destroy');
//     });

    Route::resource('users', 'UserController')->except(['show']);
    Route::resource('categories', 'CategoryController')->except(['show']);
    Route::post('categories/{id}/copy', 'CategoryController@copy')->name('categories.copy');
    Route::resource('questions', 'QuestionController')->except(['show']);
    Route::post('questions/{id}/copy', 'QuestionController@copy')->name('questions.copy');

});