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

Route::post('login', 'LoginController@login');
Route::post('register', 'RegisterController@register');

Route::middleware('auth:api')->group(function () {
    Route::get('details', 'UserController@details');
    Route::get('logout', 'UserController@logout');
    Route::get('notes/public', 'NoteController@getPublic')->name('notes.public');
    Route::apiResource('notes', 'NoteController');
    Route::apiResource('notes/{note}/comments', 'CommentController', [
        'except' => ['show'],
    ]);
});
