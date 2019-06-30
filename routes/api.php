<?php

use Illuminate\Http\Request;

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::group([

    'middleware' => 'api',

], function () {

    Route::get('tickets', 'Api\TicketController@getAll');
    Route::get('user-tickets', 'Api\TicketController@getUserTickets');
    Route::post('tickets', 'Api\TicketController@create');
    Route::put('tickets', 'Api\TicketController@update');
    Route::delete('tickets', 'Api\TicketController@delete');
    Route::post('answer-ticket', 'Api\TicketController@answer');

    Route::post('logout', 'Api\AuthController@logout');
    Route::post('test', 'testController@test');
});