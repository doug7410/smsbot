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

Route::post("outbound_bot/initiate/{id}", "OutboundBotController@run");
Route::post("outbound_bot/replies", "OutboundBotController@reply");
