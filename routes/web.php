<?php

use App\Events\WebRouteLoadedEvent;

Route::get('test', ['as' => 'mahmut', 'uses' => 'TTestController@index']);
Route::get('test2', ['as' => 'mytest2', 'uses' => 'TTestController@test2']);
Route::get('test3', function ()
{
    return View::make('test/test3');
});

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => 'auth'], function ()
{
    Route::get(trans('route.home'), ['as' => 'home', 'uses' => 'CommonController@home']);

    // <editor-fold defaultstate="collapsed" desc="Crop">
    Route::get(trans('route.crop_image'), ['as' => 'crop_image', 'before' => 'auth', 'uses' => 'CropController@image']);
    Route::post(trans('route.crop_image'), ['as' => 'crop_image_post', 'before' => 'auth', 'uses' => 'CropController@save']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Contents">
    Route::get("contents/remove_from_mobile/(:num)", ["as" => "content_remove_from_mobile", 'uses' => 'ContentController@remove_from_mobile']);
    Route::get(trans('route.contents'), ['as' => 'contents_list', 'uses' => 'ContentController@index']);
    Route::get(trans('route.contents_request'), ['as' => 'contents_request', 'uses' => 'ContentController@request']);
    Route::get(trans('route.contents_new'), ['as' => 'contents_new', 'uses' => 'ContentController@newly']);
    Route::get(trans('route.contents') . "/{content}", ['as' => 'contents_show', 'uses' => 'ContentController@show']);
    Route::post(trans('route.contents_save'), ['as' => 'contents_save', 'uses' => 'ContentController@save']);
    Route::get('/copy/(:num)/(:all)', ['as' => 'copy', 'uses' => 'ContentController@copy']);
    Route::post(trans('route.contents_delete'), ['as' => 'contents_delete', 'uses' => 'ContentController@delete']);
    Route::post(trans('route.contents_uploadfile'), ['as' => 'contents_uploadfile', 'uses' => 'ContentController@uploadfile']);
    Route::post(trans('route.contents_uploadcoverimage'), ['as' => 'contents_uploadcoverimage', 'uses' => 'ContentController@uploadCoverImage']);
    // </editor-fold>


    Route::get(trans('route.forgotmypassword'), ['as' => 'CommonController_forgotmypassword_get', function ()
    {
        return View::make('pages.forgotmypassword');
    }]);
    Route::post(trans('route.forgotmypassword'), ['as' => 'CommonController_forgotmypassword_post', 'uses' => 'CommonController@forgotmypassword']);

    Route::get(trans('route.resetmypassword'), ['as' => 'common_resetmypassword_get', 'uses' => 'CommonController@resetPasswordPage']);
    Route::post(trans('route.resetmypassword'), ['as' => 'common_resetmypassword_post', 'uses' => 'CommonController@resetmypassword']);

    Route::get(trans('route.logout'), ['as' => 'common_logout', 'uses' => 'CommonController@logout']);

    Route::get(trans('route.mydetail'), ['as' => 'common_mydetail_get', 'uses' => 'CommonController@myDetailPage']);
    Route::post(trans('route.mydetail'), ['as' => 'common_my_detail_post', 'uses' => 'CommonController@mydetail']);

    // <editor-fold defaultstate="collapsed" desc="Banners">
    Route::get(trans('route.banners'), ['as' => 'banners_list', 'uses' => 'BannerController@index']);
    Route::get(trans('route.banners_show'), ['as' => 'banners_show', 'uses' => 'BannerController@show']);
    Route::get(trans('route.banners_new'), ['as' => 'banners_new', 'uses' => 'BannerController@newly']);
    Route::post(trans('route.banners_save'), ['as' => 'banners_save', 'uses' => 'BannerController@save']);
    Route::post(trans('route.banners_setting_save'), ['as' => 'banners_setting_save', 'uses' => 'BannerController@save_banner_setting']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="maps">
    Route::get(trans('route.maps_new'), ['as' => 'maps_new', 'uses' => 'MapController@create']);
    Route::get(trans('route.maps_show'), ['as' => 'maps_show', 'uses' => 'MapController@show']);
    Route::post(trans('route.maps_save'), ['as' => 'maps_save', 'uses' => 'MapController@save']);
    Route::get(trans('route.maps_location') . "{id}", ['as' => 'maps_location', 'uses' => 'MapController@location']);
    Route::get(trans('route.maps'), ['as' => 'maps_list', 'uses' => 'MapController@index']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Clients">
    Route::get(trans('route.clients'), ['as' => 'clients_list', 'uses' => 'clients@index']);
    Route::get(trans('route.clients_new'), ['as' => 'clients_new', 'uses' => 'clients@newly']);
    Route::get(trans('route.clients_show'), ['as' => 'clients_show', 'uses' => 'clients@show']);
    Route::post(trans('route.clients_save'), ['as' => 'clients_save', 'uses' => 'clients@save']);
    Route::post(trans('route.clients_send'), ['as' => 'clients_send', 'uses' => 'clients@send']);
    Route::post(trans('route.clients_delete'), ['as' => 'clients_delete', 'uses' => 'clients@delete']);

    Route::get(trans('route.clients_register'), ['as' => 'clients_register', 'uses' => 'clients@clientregister']);
    Route::get(trans('route.clients_update'), ['as' => 'clients_register_save', 'uses' => 'clients@updateclient']);
    Route::get(trans('route.clients_registered'), ['as' => 'clients_registered', 'uses' => 'clients@registered']);
    Route::get(trans('route.clients_forgotpassword'), ['as' => 'clients_forgot_password', 'uses' => 'clients@forgotpassword']);
    Route::get(trans('route.clients_resetpw'), ['as' => 'clients_reset_password', 'uses' => 'clients@resetpw']);
    Route::get(trans('route.clients_pw_reseted'), ['as' => 'clients_password_renewed', 'uses' => 'clients@passwordreseted']);

    // </editor-fold

    // <editor-fold defaultstate="collapsed" desc="Applications">
    Route::get(trans('route.applications'), ['as' => 'applications', 'uses' => 'ApplicationController@index']);
    Route::get(trans('route.applications_new'), ['as' => 'applications_new', 'uses' => 'ApplicationController@create']);
    Route::get(trans('route.applications_show'), ['as' => 'applications_show', 'uses' => 'ApplicationController@show']);
    Route::post(trans('route.applications_pushnotification'), ['as' => 'applications_push', 'uses' => 'ApplicationController@push']);
    Route::post(trans('route.applications_save'), ['as' => 'applications_save', 'uses' => 'ApplicationController@save']);
    Route::post(trans('route.applications_delete'), ['as' => 'applications_delete', 'uses' => 'ApplicationController@delete']);
    Route::post(trans('route.applications_uploadfile'), ['as' => 'applications_uploadfile', 'uses' => 'ApplicationController@uploadFile']);
    Route::get(trans('route.applications_settings'), ['as' => 'application_setting', 'uses' => 'ApplicationSettingController@show']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Reports">
    Route::get(trans('route.reports'), ['as' => 'reports', 'before' => 'auth', 'uses' => 'ReportController@index']);
    Route::get(trans('route.reports') . "/{id}", ['as' => 'reports_show', 'before' => 'auth', 'uses' => 'ReportController@show']);
    Route::get(trans('route.reports_location_country'), ['as' => 'reports_location_country', 'before' => 'auth', 'uses' => 'ReportController@country']);
    Route::get(trans('route.reports_location_city'), ['as' => 'reports_location_city', 'before' => 'auth', 'uses' => 'ReportController@city']);
    Route::get(trans('route.reports_location_district'), ['as' => 'reports_location_district', 'before' => 'auth', 'uses' => 'ReportController@district']);
    // </editor-fold>

    Route::post('applications/applicationSetting', ['as' => 'application_setting_save', 'uses' => 'ApplicationSettingController@update']);
});


Route::post('banners/imageupload', ['as' => 'banners_imageupload', 'uses' => 'BannerController@imageupload']);
Route::get("banners/delete", ['as' => 'banners_delete', 'before' => 'auth', 'uses' => 'BannerController@delete']);
Route::post("banners/order/{applicationId}", ['as' => 'banners_order', 'before' => 'auth', 'uses' => 'BannerController@order']);
Route::get("banners/service_view/{applicationId}", ['as' => 'banners_service_view', 'uses' => 'BannerController@service_view']);


define("ENV_TEST", "test");
define("ENV_LOCAL", "local");
define("ENV_LIVE", "live");
define("APP_VER", 94);
define("IMAGE_CROPPED_NAME", "cropped_image");
define("IMAGE_CROPPED_2048", "cropped_image_1536x2048.jpg");
define("IMAGE_ORJ_EXTENSION", "_org.jpg");
define("IMAGE_ORIGINAL", "original");
define("IMAGE_EXTENSION", ".jpg");
define("CATEGORY_GENEL_ID", 1);
define("SHOW_IMAGE_CROP", "showImageCrop");
define("PATH_TEMP_FILE", "files/temp");
define("TAB_COUNT", 2);
define("GO_BACK_TO_SHOP", 'gobacktoshop');


Route::group(['prefix' => LaravelLocalization::setLocale()], function ()
{
    Route::get('/', ['as' => 'website_home', 'uses' => 'WebsiteController@index']);

    // <editor-fold defaultstate="collapsed" desc="website">
    Route::get(trans('route.website_showcase'), ['as' => 'website_showcase', 'uses' => function ()
    {
        return View::make('website.pages.showcase');
    }]);

    Route::get(trans('route.website_tutorials'), ['as' => 'website_tutorials', 'uses' => function ()
    {
        return View::make('website.pages.tutorials');
    }]);

    Route::get(trans('route.website_contact'), ['as' => 'website_contact', 'uses' => function ()
    {
        return View::make('website.pages.contact');
    }]);

    Route::get(trans('route.website_sectors'), ['as' => 'website_sectors', 'uses' => function ()
    {
        return View::make('website.pages.sectors');
    }]);

    Route::get(trans('route.website_sectors_retail'), ['as' => 'website_sectors_retail', 'uses' => function ()
    {
        return View::make('website.pages.sectors-retail');
    }]);
    Route::get(trans('route.website_sectors_humanresources'), ['as' => 'website_sectors_humanresources', 'uses' => function ()
    {
        return View::make('website.pages.sectors-humanresources');
    }]);
    Route::get(trans('route.website_sectors_education'), ['as' => 'website_sectors_education', 'uses' => function ()
    {
        return View::make('website.pages.sectors-education');
    }]);

    Route::get(trans('route.website_sectors_realty'), ['as' => 'website_sectors_realty', 'uses' => function ()
    {
        return View::make('website.pages.sectors-realty');
    }]);
    Route::get(trans('route.website_sectors_medicine'), ['as' => 'website_sectors_medicine', 'uses' => function ()
    {
        return View::make('website.pages.sectors-medicine');
    }]);
    Route::get(trans('route.website_sectors_digitalpublishing'), ['as' => 'website_sectors_digitalpublishing', 'uses' => function ()
    {
        return View::make('website.pages.sectors-digitalpublishing');
    }]);
    Route::get(trans('route.website_why_galepress'), ['as' => 'website_why_galepress', 'uses' => function ()
    {
        return View::make('website.pages.why-galepress');
    }]);
    Route::get(trans('route.website_tryit'), ['as' => 'website_tryit', 'uses' => function ()
    {
        return View::make('website.pages.tryit');
    }]); //571571 MeCaptcha\Captcha not found...

    Route::get('deneyin-test', ['as' => 'deneyin-test', 'uses' => function ()
    {
        return View::make('website.pages.tryit-test');
    }]);//571571 MeCaptcha\Captcha not found...

    Route::get(trans('route.login'), ['middleware' => 'RedirectIfAuthenticated', 'as' => 'common_login_get', 'uses' => function ()
    {
        return view('pages.login');
    }]);
    Route::post(trans('route.login'), ['as' => 'common_login_post', 'uses' => 'CommonController@login']);

    // </editor-fold>
});

Route::group(['middleware' => 'auth'], function ()
{
    Route::post("contents/order/{myApplication}", ['as' => 'contents_order', 'uses' => 'ContentController@order']);
    Route::post('iyzicoqr', 'IyzicoController@save');
    Route::get('open_iyzico_iframe/{qrCode}', 'IyzicoController@openIyzicoIframe');
    Route::any('checkout_result_form', ['as' => 'get_checkout_result_form', 'uses' => 'IyzicoController@checkoutIyzicoResultForm']);
});

/** Website Post */
Route::post(trans('route.website_tryit'), ['as' => 'website_tryit_post', 'uses' => 'WebsiteController@tryIt']); //571571 Test It
Route::post('deneyin-test', ['as' => 'website_tryit_test_post', 'uses' => 'WebsiteController@tryIt']);//571571 Test It
Route::post(trans('route.facebook_attempt'), ['as' => 'website_facebook_attempt_post', 'uses' => 'CommonController@facebookAttempt']); //571571 Test It

// <editor-fold defaultstate="collapsed" desc="Test">
Route::get('test/iosInternalTest', 'test@iosInternalTest');
Route::get("move", "test@moveInteractivite");
Route::get("test/image", "test@image");
Route::post("test/image", "test@image");
Route::get("test/download", "test@download");
Route::post("test/download", "test@download");

Route::get('test/v(:num)', 'test@routetest');
Route::get('test/interactive', 'test@interactive');
// </editor-fold>
//<editor-fold defaultstate="collapesd" desc="Qr Code">
Route::get('iyzicoqr/{user}', 'IyzicoController@index');
Route::post('iyzicoqr', 'IyzicoController@save');
Route::get('open_iyzico_iframe/{qrCode}', 'IyzicoController@openIyzicoIframe');
Route::any('checkout_result_form', ['as' => 'get_checkout_result_form', 'uses' => 'IyzicoController@checkoutIyzicoResultForm']);
//</editor-fold>


Route::post("clients/excelupload", ['before' => 'auth', 'uses' => "clients@excelupload"]);
Route::post("maps/excelupload/{application}", ['before' => 'auth', 'uses' => "MapController@excelupload"]);
Route::get("maps/delete", ['before' => 'auth', 'uses' => "MapController@delete"]);
Route::post((string)trans('route.contents_interactivity_status'), ['uses' => "ContentController@interactivityStatus"]);

Route::post('/contactmail', ['as' => 'contactmail', 'uses' => 'WebsiteController@contactForm']);
Route::post('/search', 'webservice.search@search');
Route::post('/searchgraff', 'webservice.search@searchgraff');


Route::get(trans('appcreatewithface'), ['as' => 'appcreatewithface', 'uses' => 'WebsiteController@app_create_face']);

Route::get(trans('route.website_article_workflow'), ['as' => 'website_article_workflow_get', 'uses' => 'WebsiteController@article_workflow']);
Route::get(trans('route.website_article_brandvalue'), ['as' => 'website_article_brandvalue_get', 'uses' => 'WebsiteController@article_brandvalue']);
Route::get(trans('route.website_article_whymobile'), ['as' => 'website_article_whymobile_get', 'uses' => 'WebsiteController@articleWhyMobile']);


//<editor-fold desc="Payment">
Route::get(trans('route.shop'), ['as' => 'payment_shop', 'uses' => 'payment@shop']);
Route::get('payment-galepress', ['as' => 'website_payment_galepress_get', 'before' => 'auth', 'uses' => 'payment@payment_galepress']);
Route::post('payment-galepress', ['as' => 'website_payment_galepress_post', 'before' => 'auth', 'uses' => 'payment@payment_galepress']);
Route::post(trans('route.payment_card_info'), ['as' => 'payment_card_info', 'before' => 'auth', 'uses' => 'payment@card_info']);
Route::post(trans('route.payment_approvement'), ['as' => 'payment_approvement', 'before' => 'auth', 'uses' => 'payment@payment_approval']);
Route::get(trans('route.website_payment_result'), ['as' => 'website_payment_result_get', 'uses' => 'payment@payment_result']);
//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Common">


Route::get(trans('route.confirmemail'), ['as' => 'common_confirmemail_get', 'uses' => 'CommonController@confirmEmailPage']);
Route::get(trans('route.my_ticket'), ['as' => 'my_ticket', 'before' => 'auth', 'uses' => 'CommonController@ticketPage']);

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Users">
Route::get(trans('route.users'), ['as' => 'users', 'before' => 'auth', 'uses' => 'users@index']);
Route::get(trans('route.users_new'), ['as' => 'users_new', 'before' => 'auth', 'uses' => 'users@newly']);
Route::get(trans('route.users_show'), ['as' => 'users_show', 'before' => 'auth', 'uses' => 'users@show']);
Route::post(trans('route.users_save'), ['as' => 'users_save', 'before' => 'auth|csrf', 'uses' => 'users@save']);
Route::post(trans('route.users_send'), ['as' => 'users_send', 'before' => 'auth|csrf', 'uses' => 'users@send']);
Route::post(trans('route.users_delete'), ['as' => 'users_delete', 'before' => 'auth|csrf', 'uses' => 'users@delete']);
// </editor-fold>


// <editor-fold defaultstate="collapsed" desc="Customers">
Route::get(trans('route.customers'), ['as' => 'customers', 'before' => 'auth', 'uses' => 'customers@index']);
Route::get(trans('route.customers_new'), ['as' => 'customers_new', 'before' => 'auth', 'uses' => 'customers@newly']);
Route::get(trans('route.customers_show'), ['as' => 'customers_show', 'before' => 'auth', 'uses' => 'customers@show']);
Route::post(trans('route.customers_save'), ['as' => 'customers_save', 'before' => 'auth|csrf', 'uses' => 'customers@save']);
Route::post(trans('route.customers_delete'), ['as' => 'customers_delete', 'before' => 'auth|csrf', 'uses' => 'customers@delete']);
// </editor-fold>


// <editor-fold defaultstate="collapsed" desc="Password">
Route::get(trans('route.contents_passwords'), ['as' => 'contents_passwords', 'before' => 'auth', 'uses' => 'contentpasswords@index']);
Route::post(trans('route.contents_passwords_save'), ['as' => 'contents_passwords_save', 'before' => 'auth|csrf', 'uses' => 'contentpasswords@save']);
Route::post(trans('route.contents_passwords_delete'), ['as' => 'contents_passwords_delete', 'before' => 'auth', 'uses' => 'contentpasswords@delete']);
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Orders">
Route::get(trans('route.application_form_create'), ['as' => 'application_form_create', 'uses' => 'orders@appForm']);
Route::get(trans('route.orders'), ['as' => 'orders', 'before' => 'auth', 'uses' => 'orders@index']);
Route::get(trans('route.orders_new'), ['as' => 'orders_new', 'before' => 'auth', 'uses' => 'orders@newly']);
Route::get(trans('route.orders_show'), ['as' => 'orders_show', 'before' => 'auth', 'uses' => 'orders@show']);
Route::post(trans('route.orders_save'), ['as' => 'orders_save', 'uses' => 'orders@save']);
Route::post(trans('route.orders_delete'), ['as' => 'orders_delete', 'before' => 'auth|csrf', 'uses' => 'orders@delete']);
Route::post(trans('route.orders_uploadfile'), ['as' => 'orders_uploadfile', 'uses' => 'orders@uploadfile']);
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Category">
Route::get(trans('route.categories'), ['as' => 'categories', 'before' => 'auth', 'uses' => 'categories@index']);
Route::post(trans('route.categories_save'), ['as' => 'categories_save', 'before' => 'auth|csrf', 'uses' => 'categories@save']);
Route::post(trans('route.categories_delete'), ['as' => 'categories_delete', 'before' => 'auth', 'uses' => 'categories@delete']);
// </editor-fold>


// <editor-fold defaultstate="collapsed" desc="Interactivity">
Route::get(trans('route.interactivity_preview'), ['as' => 'interactivity_preview', 'before' => 'auth', 'uses' => 'interactivity@preview']);
Route::get(trans('route.interactivity_show'), ['as' => 'interactivity_show', 'before' => 'auth', 'uses' => 'interactivity@show']);
Route::get(trans('route.interactivity_fb'), ['as' => 'interactivity_fb', 'uses' => 'interactivity@fb']);
Route::post(trans('route.interactivity_check'), ['as' => 'interactivity_check', 'before' => 'auth', 'uses' => 'interactivity@check']);
Route::post(trans('route.interactivity_save'), ['as' => 'interactivity_save', 'before' => 'auth|csrf', 'uses' => 'interactivity@save']);
Route::post(trans('route.interactivity_transfer'), ['as' => 'interactivity_transfer', 'before' => 'auth', 'uses' => 'interactivity@transfer']);
Route::post(trans('route.interactivity_refreshtree'), ['as' => 'interactivity_refreshtree', 'before' => 'auth', 'uses' => 'interactivity@refreshtree']);
Route::post(trans('route.interactivity_upload'), ['as' => 'interactivity_upload', 'before' => 'auth', 'uses' => 'interactivity@upload']);
Route::post(trans('route.interactivity_loadpage'), ['as' => 'interactivity_loadpage', 'before' => 'auth', 'uses' => 'interactivity@loadpage']);
// </editor-fold>


Route::get(trans('route.sign_up'), function ()
{
    return view('website.signup');
});
Route::get(trans('route.forgot_password'), function ()
{
    return view('website.forgotpassword');
});
Route::get(trans('route.sign_in'), function ()
{
    return view('website.signin');
});


// <editor-fold defaultstate="collapsed" desc="managements">
Route::get(trans('route.managements_list'), ['as' => 'managements_list', 'uses' => 'managements@list']);
Route::get('managements/import', ['as' => 'managements_importlanguages', 'uses' => 'managements@importlanguages']);
Route::post('managements/import', ['as' => 'managements_importlanguages', 'uses' => 'managements@importlanguages']);
Route::post('managements/export', ['as' => 'managements_exportlanguages', 'uses' => 'managements@exportlanguages']);
// </editor-fold>


Route::post('clients/clientregister', ['as' => 'clientsregistersave', 'uses' => 'clients@clientregister']);
Route::post('clients/forgotpassword', ['as' => 'clientsregistered', 'uses' => 'clients@forgotpassword']);
Route::post("clients/resetpw", ['as' => 'clientsresetpw', 'uses' => 'clients@resetpw']);
Route::post("applications/refresh_identifier", ['as' => 'applicationrefreshidentifier', 'uses' => 'ApplicationController@refresh_identifier']);
Route::post("contents/refresh_identifier", ['as' => 'contentrefreshidentifier', 'uses' => 'ContentController@refresh_identifier']);

Route::get("/csstemplates/{filename}", ['as' => 'template_index', 'uses' => 'ApplicationTemplateController@theme']);
Route::get("/template/{application}", ['as' => 'template_index', 'before' => 'auth', 'uses' => 'ApplicationTemplateController@show']);
Route::get('maps/webview/{application}', ['as' => 'map_view', 'uses' => 'MapController@webView']);
Route::get('payment/paymentAccountByApplicationID/(:num)', ['as' => 'app_payment_data', 'uses' => 'payment@paymentAccountByApplicationID']);

Route::get('3d-secure-response', ['as' => 'iyzico_3ds_return_url', 'before' => 'auth', 'uses' => 'payment@secure_3d_response']);
Route::post('3d-secure-response', ['as' => 'iyzico_3ds_return_url', 'before' => 'auth', 'uses' => 'payment@secure_3d_response']);


// <editor-fold defaultstate="collapsed" desc="New Webservice Routes">
Route::get('webservice/{ws}/applications/{applicationID}/version', ['uses' => 'webservice.applications@version']);
Route::post('webservice/(:num)/applications/(:num)/version', ['uses' => 'webservice.applications@version']);
Route::get('webservice/(:num)/applications/(:num)/detail', ['uses' => 'webservice.applications@detail']);
Route::post('webservice/(:num)/applications/(:num)/detail', ['uses' => 'webservice.applications@detail']);
Route::get('webservice/(:num)/applications/(:num)/categories', ['uses' => 'webservice.applications@categories']);
Route::get('webservice/(:num)/applications/(:num)/categories/(:num)/detail', ['uses' => 'webservice.applications@categoryDetail']);

Route::get('webservice/(:num)/applications/(:num)/contents', ['uses' => 'webservice.applications@contents']);
Route::post('webservice/(:num)/applications/(:num)/receipt', ['uses' => 'webservice.applications@receipt']);
Route::post('webservice/(:num)/applications/(:num)/androidrestore', ['uses' => 'webservice.applications@androidrestore']);


Route::get('webservice/(:num)/applications/authorized_application_list', ['uses' => 'webservice.applications@authorized_application_list']);
Route::post('webservice/(:num)/applications/authorized_application_list', ['uses' => 'webservice.applications@authorized_application_list']);
Route::post('webservice/(:num)/applications/login_application', ['uses' => 'webservice.applications@login_application']);
Route::get('webservice/(:num)/applications/login_application', ['uses' => 'webservice.applications@login_application']);
Route::post('webservice/(:num)/applications/fblogin', ['uses' => 'webservice.applications@fblogin']);
// WS-Contents
Route::get('webservice/(:num)/contents/(:num)/version', ['uses' => 'webservice.contents@version']);
Route::get('webservice/(:num)/contents/(:num)/detail', ['uses' => 'webservice.contents@detail']);
Route::get('webservice/(:num)/contents/(:num)/cover-image', ['uses' => 'webservice.contents@coverImage']);
Route::get('webservice/(:num)/contents/(:num)/file', ['uses' => 'webservice.contents@file']);
// WS-Statistics
Route::post('webservice/(:num)/statistics', ['uses' => 'webservice.statistics@create']);
//WS-Topic
Route::any('webservice/(:num)/topic', ['uses' => 'webservice.topic@topic']);
Route::any('webservice/(:num)/application-topic', ['uses' => 'webservice.topic@applicationTopic']);


// </editor-fold>
event(new WebRouteLoadedEvent());