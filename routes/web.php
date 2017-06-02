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

Route::get('/', 'OutboundBotController@index');
Route::resource("outbound_bots","OutboundBotController");
Route::resource("customer_lists","CustomerListController");
Route::resource("questions","QuestionController");
Route::resource("answers","AnswerController");
Route::resource("conversations","ConversationController");