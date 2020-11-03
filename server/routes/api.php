<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login','AuthController@login');
Route::post('logout','AuthController@logout');
Route::get('profile','AuthController@getAuthenticatedUser');
Route::get('checkuser','AuthController@checkAuthenticatedUser');

Route::post('register','UserController@register');
Route::post('adduser','UserController@addUser');
Route::put('updateprofile','UserController@editProfile');

Route::get('files','FileUploadController@index');
Route::get('userfiles','FileUploadController@userIndex');
Route::post('files','FileUploadController@store');
Route::put('files/{id}', 'FileUploadController@update');
Route::delete('files/{id}', 'FileUploadController@delete');

// Route::get('tasks', 'TaskController@index');
// Route::get('task/{id}', 'TaskController@show');
// Route::post('task', 'TaskController@store');
// Route::put('task/{id}', 'TaskController@update');
// Route::delete('task/{id}', 'TaskController@delete');

Route::middleware('auth:api')->get('/User', function(Request $request){
  return $request->user();
});