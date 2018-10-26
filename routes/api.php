<?php


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
Route::middleware('guest')->group(function () {
    Route::post('login', 'LoginController@login')->name('auth.login');
    Route::post('register', 'RegisterController@register')->name('auth.register');
});

Route::middleware('auth:api')->group(function () {
    Route::get('details', 'ProfileController@details')->name('auth.details');
    Route::get('logout', 'ProfileController@logout')->name('auth.logout');
    Route::get('notes/public', 'NoteController@getPublic')->name('notes.public');
    Route::get('notes/{note}/comments', 'NoteController@comments')->name('notes.comments');
    Route::apiResource('notes', 'NoteController');
    Route::apiResource('notes/{note}/comments', 'CommentController', [
        'except' => ['index', 'show'],
    ]);
});
