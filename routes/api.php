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
Route::any('webservice/{sv}/applications/{application}/version', ['uses' => 'Service\AppController@version']);
Route::any('webservice/{sv}/applications/{application}/detail', ['uses' => 'Service\AppController@detail']);
Route::any('webservice/{sv}/applications/{application}/categories', ['uses' => 'Service\AppController@categories']);
Route::any('webservice/{sv}/applications/{application}/categories/{category}/detail', ['uses' => 'Service\AppController@categoryDetail']);

Route::get('webservice/{sv}/applications/{application}/contents', ['uses' => 'Service\AppController@contents']);
Route::any('webservice/{sv}/applications/{applicationID}/receipt', ['uses' => 'Service\AppController@receipt']);
Route::any('webservice/{sv}/applications/{application}/androidrestore', ['uses' => 'Service\AppController@androidRestore']);

Route::any('webservice/{sv}/applications/authorized_application_list', ['uses' => 'Service\AppController@authorizedApplicationList']);
Route::any('webservice/{sv}/applications/login_application', ['uses' => 'Service\AppController@loginApplication']);
Route::any('webservice/{sv}/applications/fblogin', ['uses' => 'Service\AppController@facebookLogin']);

// WS-Contents
Route::any('webservice/{sv}/contents/{content}/version', ['uses' => 'Service\ContentServiceController@version']);
Route::any('webservice/{sv}/contents/{contentID}/detail', ['uses' => 'Service\ContentServiceController@detail']);
Route::any('webservice/{sv}/contents/{content}/cover-image', ['uses' => 'Service\ContentServiceController@coverImage']);
Route::any('webservice/{sv}/contents/{content}/file', ['uses' => 'Service\ContentServiceController@file']);

//// WS-Statistics
Route::any('webservice/{sv}/statistics', ['uses' => 'Service\StatisticController@create']);
Route::any('webservice/{sv}/graff_statistics', array('uses' => 'Service\StatisticController@graff'));
////WS-Topic
Route::any('webservice/{sv}/topic', ['uses' => 'Service\TopicController@topic']);
Route::any('webservice/{sv}/application-topic', ['uses' => 'Service\TopicController@applicationTopic']);
// </editor-fold>