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

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::get('tickets', 'Api\TicketController@getAll');
    Route::get('userTickets', 'Api\TicketController@getUserTickets');
    Route::post('tickets', 'Api\TicketController@create');
    Route::put('tickets', 'Api\TicketController@update');
    Route::delete('tickets', 'Api\TicketController@delete');
    Route::post('answer-ticket', 'Api\TicketController@answer');

    Route::post('logout', 'Api\AuthController@logout');
    Route::post('test', 'testController@test');
});