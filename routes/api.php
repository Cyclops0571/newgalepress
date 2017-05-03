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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/search', 'Service\SearchController@search');
Route::post('/searchgraff', 'Service\SearchController@searchGraff');


/***********CALISMAYANLAR *****************/

// <editor-fold defaultstate="collapsed" desc="New Webservice Routes">
Route::get('Service/{ws}/applications/{applicationID}/version', ['uses' => 'Service.applications@version']);
Route::post('Service/(:num)/applications/(:num)/version', ['uses' => 'Service.applications@version']);
Route::get('Service/(:num)/applications/(:num)/detail', ['uses' => 'Service.applications@detail']);
Route::post('Service/(:num)/applications/(:num)/detail', ['uses' => 'Service.applications@detail']);
Route::get('Service/(:num)/applications/(:num)/categories', ['uses' => 'Service.applications@categories']);
Route::get('Service/(:num)/applications/(:num)/categories/(:num)/detail', ['uses' => 'Service.applications@categoryDetail']);

Route::get('Service/(:num)/applications/(:num)/contents', ['uses' => 'Service.applications@contents']);
Route::post('Service/(:num)/applications/(:num)/receipt', ['uses' => 'Service.applications@receipt']);
Route::post('Service/(:num)/applications/(:num)/androidrestore', ['uses' => 'Service.applications@androidrestore']);


Route::get('Service/(:num)/applications/authorized_application_list', ['uses' => 'Service.applications@authorized_application_list']);
Route::post('Service/(:num)/applications/authorized_application_list', ['uses' => 'Service.applications@authorized_application_list']);
Route::post('Service/(:num)/applications/login_application', ['uses' => 'Service.applications@login_application']);
Route::get('Service/(:num)/applications/login_application', ['uses' => 'Service.applications@login_application']);
Route::post('Service/(:num)/applications/fblogin', ['uses' => 'Service.applications@fblogin']);
// WS-Contents
Route::get('Service/(:num)/contents/(:num)/version', ['uses' => 'Service.contents@version']);
Route::get('Service/(:num)/contents/(:num)/detail', ['uses' => 'Service.contents@detail']);
Route::get('Service/(:num)/contents/(:num)/cover-image', ['uses' => 'Service.contents@coverImage']);
Route::get('Service/(:num)/contents/(:num)/file', ['uses' => 'Service.contents@file']);
// WS-Statistics
Route::post('Service/(:num)/statistics', ['uses' => 'Service.statistics@create']);
//WS-Topic
Route::any('Service/(:num)/topic', ['uses' => 'Service.topic@topic']);
Route::any('Service/(:num)/application-topic', ['uses' => 'Service.topic@applicationTopic']);
// </editor-fold>