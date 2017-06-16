<?php

use App\Events\WebRouteLoadedEvent;

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


Route::get('test', ['as' => 'mahmut', 'uses' => 'TTestController@index']);
Route::get('test', ['prefix' => LaravelLocalization::setLocale(), 'as' => 'mahmut', 'uses' => 'TTestController@index']);
Route::get('test2', ['as' => 'mytest2', 'uses' => 'TTestController@test2']);
Route::get('test3', function ()
{
    return View::make('test/test3');
});


Route::group(['prefix' => LaravelLocalization::setLocale()], function ()
{

    Route::get('mobile-user/reset-password', ['as' => 'mobile_reset_password_form', 'uses' => 'Mobile\AuthController@resetPasswordForm']);
    Route::any('mobile-user/send-token-mail', ['as' => 'mobile_user_send_token_mail', 'uses' => 'Mobile\AuthController@sendTokenMail']);
    Route::post("mobile-user/update-password", ['as' => 'mobile_update_password', 'uses' => 'Mobile\AuthController@updatePassword']);


    Route::get('mobile-user/register/{application}', ['as' => 'mobile_user_register', 'uses' => 'Mobile\AuthController@register']);
    Route::post('mobile-user/store', ['as' => 'mobile_user_store', 'uses' => 'Mobile\AuthController@store']);

    Route::get('mobile-user/edit/{application}/{clientToken}', ['as' => 'clients_register_save', 'uses' => 'Mobile\AuthController@edit']);
    Route::get('mobile-user/registration-success', ['as' => 'mobile_user_registration_success', 'uses' => function ()
    {
        return view('mobile.registration_success');
    }]);
    Route::get('mobile-user/forgot-password/{application}', ['as' => 'clients_forgot_password', 'uses' => 'Mobile\AuthController@forgotPasswordForm']);
    Route::get('mobile-user/password-changed', ['as' => 'mobile_user_password_changed', 'uses' => function ()
    {
        return view('mobile.password_changed');
    }]);


    // <editor-fold defaultstate="collapsed" desc="website">
    Route::get('/', ['as' => 'website_home', 'uses' => 'WebsiteController@index']);

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
    // </editor-fold>


});


Route::get('payment/paymentAccountByApplicationID/{applicationID}', ['as' => 'app_payment_data', 'uses' => 'PaymentController@paymentAccountByApplicationID']);
Route::post('payment-galepress', ['as' => 'website_payment_galepress', 'before' => 'auth', 'uses' => 'PaymentController@paymentGalepress']);


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => 'auth'], function ()
{
    Route::get(trans('route.home'), ['as' => 'home', 'uses' => 'CommonController@home']);

    Route::any('3d-secure-response', ['as' => 'iyzico_3ds_return_url', 'uses' => 'PaymentController@secure3dResponse']);
    Route::get(trans('route.shop'), ['as' => 'payment_shop', 'uses' => 'PaymentController@shop']);
    Route::post(trans('route.payment_card_info'), ['as' => 'payment_card_info', 'uses' => 'PaymentController@cardInfo']);
    Route::post(trans('route.payment_approvement'), ['as' => 'payment_approvement', 'uses' => 'PaymentController@paymentApproval']);
    Route::get(trans('route.website_payment_result'), ['as' => 'website_payment_result', 'uses' => 'PaymentController@paymentResult']);

    // <editor-fold defaultstate="collapsed" desc="Crop">
    Route::get(trans('route.crop_image'), ['as' => 'crop_image', 'uses' => 'CropController@image']);
    Route::post(trans('route.crop_image'), ['as' => 'crop_image_post', 'uses' => 'CropController@save']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Contents">
    Route::get("contents/remove_from_mobile/{contentID}", ["as" => "content_remove_from_mobile", 'uses' => 'ContentController@remove_from_mobile']);
    Route::get(trans('route.contents'), ['as' => 'contents_list', 'uses' => 'ContentController@index']);
    Route::get(trans('route.contents_new'), ['as' => 'contents_new', 'uses' => 'ContentController@newly']);
    Route::get(trans('route.contents') . "/{content}", ['as' => 'contents_show', 'uses' => 'ContentController@show']);
    Route::post(trans('route.contents_save'), ['as' => 'contents_save', 'uses' => 'ContentController@save']);
    Route::get('/copy/(:num)/(:all)', ['as' => 'copy', 'uses' => 'ContentController@copy']);
    Route::post(trans('route.contents_delete'), ['as' => 'contents_delete', 'uses' => 'ContentController@delete']);
    Route::post(trans('route.contents_uploadfile'), ['as' => 'contents_uploadfile', 'uses' => 'ContentController@uploadfile']);
    Route::post(trans('route.contents_uploadcoverimage'), ['as' => 'contents_uploadcoverimage', 'uses' => 'ContentController@uploadCoverImage']);
    Route::post(trans('route.contents_interactivity_status'), ['uses' => "ContentController@interactivityStatus"]);
    Route::any(trans('route.contents_interactivity_status'), ['uses' => "ContentController@interactivityStatus"]);
    // </editor-fold>

    Route::get(trans('route.contents_passwords'), array('as' => 'contents_passwords', 'uses' => 'ContentController@passwordList'));
    Route::post(trans('route.contents_passwords_save'), array('as' => 'contents_passwords_save', 'uses' => 'ContentController@passwordSave'));
    Route::post(trans('route.contents_passwords_delete'), array('as' => 'contents_passwords_delete', 'uses' => 'ContentController@passwordDelete'));


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
    Route::get(trans('route.banners_new'), ['as' => 'banners_new', 'uses' => 'BannerController@newly']);
    Route::post(trans('route.banners_save'), ['as' => 'banners_save', 'uses' => 'BannerController@save']);
    Route::post(trans('route.banners_setting_save'), ['as' => 'banners_setting_save', 'uses' => 'BannerController@save_banner_setting']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="maps">
    Route::get(trans('route.maps_new'), ['as' => 'maps_new', 'uses' => 'MapController@create']);
    Route::get(trans('route.maps_show'), ['as' => 'maps_show', 'uses' => 'MapController@show']);
    Route::post(trans('route.maps_save'), ['as' => 'maps_save', 'uses' => 'MapController@save']);
    Route::get(trans('route.maps'), ['as' => 'maps_list', 'uses' => 'MapController@index']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Applications">
    Route::get(trans('route.applications_list'), ['as' => 'customer_application_list', 'uses' => 'ApplicationController@customerApplicationList']);
    Route::get(trans('route.applications_new'), ['as' => 'applications_new', 'uses' => 'ApplicationController@create']);
    Route::get(trans('route.applications_show'), ['as' => 'applications_show', 'uses' => 'ApplicationController@show']);
    Route::post(trans('route.applications_pushnotification'), ['as' => 'applications_push', 'uses' => 'ApplicationController@push']);
    Route::post(trans('route.applications_save'), ['as' => 'applications_save', 'uses' => 'ApplicationController@save']);
    Route::post(trans('route.applications_delete'), ['as' => 'applications_delete', 'uses' => 'ApplicationController@delete']);
    Route::post(trans('route.applications_uploadfile'), ['as' => 'applications_uploadfile', 'uses' => 'ApplicationController@uploadFile']);
    Route::get(trans('route.applications_settings'), ['as' => 'application_setting', 'uses' => 'ApplicationSettingController@show']);
    Route::post('applications/applicationSetting', ['as' => 'application_setting_save', 'uses' => 'ApplicationSettingController@update']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Reports">
    Route::get(trans('route.reports'), ['as' => 'reports',  'uses' => 'ReportController@index']);
    Route::get(trans('route.reports') . "/{id}", ['as' => 'reports_show',  'uses' => 'ReportController@show']);
    Route::get(trans('route.reports_location_country'), ['as' => 'reports_location_country',  'uses' => 'ReportController@country']);
    Route::get(trans('route.reports_location_city'), ['as' => 'reports_location_city',  'uses' => 'ReportController@city']);
    Route::get(trans('route.reports_location_district'), ['as' => 'reports_location_district',  'uses' => 'ReportController@district']);
    // </editor-fold>


    // <editor-fold defaultstate="collapsed" desc="Interactivity">
    Route::get(trans('route.interactivity_preview'), ['as' => 'interactivity_preview', 'before' => 'auth', 'uses' => 'InteractivityController@preview']);
    Route::get(trans('route.interactivity_show'), ['as' => 'interactivity_show', 'before' => 'auth', 'uses' => 'InteractivityController@show']);
    Route::get(trans('route.interactivity_fb'), ['as' => 'interactivity_fb', 'uses' => 'InteractivityController@fb']);
    Route::post(trans('route.interactivity_check'), ['as' => 'interactivity_check', 'before' => 'auth', 'uses' => 'InteractivityController@check']);
    Route::post(trans('route.interactivity_save'), ['as' => 'interactivity_save', 'before' => 'auth|csrf', 'uses' => 'InteractivityController@save']);
    Route::post(trans('route.interactivity_transfer'), ['as' => 'interactivity_transfer', 'before' => 'auth', 'uses' => 'InteractivityController@transfer']);
    Route::post(trans('route.interactivity_refreshtree'), ['as' => 'interactivity_refreshtree', 'before' => 'auth', 'uses' => 'InteractivityController@refreshtree']);
    Route::post(trans('route.interactivity_upload'), ['as' => 'interactivity_upload', 'before' => 'auth', 'uses' => 'InteractivityController@upload']);
    Route::post(trans('route.interactivity_loadpage'), ['as' => 'interactivity_loadpage', 'before' => 'auth', 'uses' => 'InteractivityController@loadpage']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Category">
    Route::get(trans('route.categories'), ['as' => 'categories', 'before' => 'auth', 'uses' => 'CategoryController@index']);
    Route::post(trans('route.categories_save'), ['as' => 'categories_save', 'before' => 'auth|csrf', 'uses' => 'CategoryController@save']);
    Route::post(trans('route.categories_delete'), ['as' => 'categories_delete', 'before' => 'auth', 'uses' => 'CategoryController@delete']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Clients">
    Route::get(trans('route.clients'), ['as' => 'clients_list', 'uses' => 'ClientController@index']);
    Route::get(trans('route.clients_new'), ['as' => 'clients_new', 'uses' => 'ClientController@create']);
    Route::get(trans('route.clients') . "/{client}", ['as' => 'clients_show', 'uses' => 'ClientController@show']);
    Route::post(trans('route.clients_save'), ['as' => 'clients_save', 'uses' => 'ClientController@save']);
    Route::post(trans('route.clients_send'), ['as' => 'clients_send', 'uses' => 'ClientController@send']);
    Route::post(trans('route.clients_delete'), ['as' => 'clients_delete', 'uses' => 'ClientController@delete']);


    // </editor-fold


});


Route::post('banners/imageupload', ['as' => 'banners_imageupload', 'uses' => 'BannerController@imageupload']);
Route::get("banners/delete", ['as' => 'banners_delete', 'before' => 'auth', 'uses' => 'BannerController@delete']);
Route::post("banners/order/{applicationId}", ['as' => 'banners_order', 'before' => 'auth', 'uses' => 'BannerController@order']);
Route::get("banners/service_view/{applicationId}", ['as' => 'banners_service_view', 'uses' => 'BannerController@service_view']);


Route::group(['middleware' => 'auth'], function ()
{
    Route::get('phpinfo', 'AdminController@index');
    Route::post("contents/order/{myApplication}", ['as' => 'contents_order', 'uses' => 'ContentController@order']);
    Route::post('iyzicoqr', 'IyzicoController@save');
    Route::get('open_iyzico_iframe/{qrCode}', 'IyzicoController@openIyzicoIframe');
    Route::any('checkout_result_form', ['as' => 'get_checkout_result_form', 'uses' => 'IyzicoController@checkoutIyzicoResultForm']);
    Route::post("clients/excelupload", ['uses' => "ClientController@excelupload"]);
});

/** Website Post */
Route::post(trans('route.website_tryit'), ['as' => 'website_tryit_post', 'uses' => 'WebsiteController@tryIt']); //571571 Test It
Route::post('deneyin-test', ['as' => 'website_tryit_test_post', 'uses' => 'WebsiteController@tryIt']);//571571 Test It
Route::post(trans('route.facebook_attempt'), ['as' => 'website_facebook_attempt_post', 'uses' => 'CommonController@facebookAttempt']); //571571 Test It

//<editor-fold defaultstate="collapesd" desc="Qr Code">
Route::get('iyzicoqr/{user}', 'IyzicoController@index');
Route::post('iyzicoqr', 'IyzicoController@save');
Route::get('open_iyzico_iframe/{qrCode}', 'IyzicoController@openIyzicoIframe');
Route::any('checkout_result_form', ['as' => 'get_checkout_result_form', 'uses' => 'IyzicoController@checkoutIyzicoResultForm']);
//</editor-fold>


Route::post("maps/excelupload/{application}", ['before' => 'auth', 'uses' => "MapController@excelupload"]);
Route::get("maps/delete", ['before' => 'auth', 'uses' => "MapController@delete"]);
Route::post('/contactmail', ['as' => 'contactmail', 'uses' => 'WebsiteController@contactForm']);

Route::get(trans('appcreatewithface'), ['as' => 'appcreatewithface', 'uses' => 'WebsiteController@app_create_face']);

Route::get(trans('route.website_article_workflow'), ['as' => 'website_article_workflow_get', 'uses' => 'WebsiteController@article_workflow']);
Route::get(trans('route.website_article_brandvalue'), ['as' => 'website_article_brandvalue_get', 'uses' => 'WebsiteController@article_brandvalue']);
Route::get(trans('route.website_article_whymobile'), ['as' => 'website_article_whymobile_get', 'uses' => 'WebsiteController@articleWhyMobile']);


// <editor-fold defaultstate="collapsed" desc="Common">
Route::get(trans('route.confirmemail'), ['as' => 'common_confirmemail_get', 'uses' => 'CommonController@confirmEmailPage']);
Route::get(trans('route.my_ticket'), ['as' => 'my_ticket', 'before' => 'auth', 'uses' => 'CommonController@ticketPage']);
// </editor-fold>

Route::post("applications/refresh_identifier", ['as' => 'applicationrefreshidentifier', 'uses' => 'ApplicationController@refresh_identifier']);
Route::post("contents/refresh_identifier", ['as' => 'contentrefreshidentifier', 'uses' => 'ContentController@refresh_identifier']);

Route::get("/csstemplates/{filename}", ['as' => 'template_index', 'uses' => 'ApplicationTemplateController@theme']);
Route::get("/template/{application}", ['as' => 'template_index', 'before' => 'auth', 'uses' => 'ApplicationTemplateController@show']);
Route::get('maps/webview/{application}', ['as' => 'map_view', 'uses' => 'MapController@webView']);


Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['auth', 'admin']], function ()
{
    Route::get(trans('route.applications'), ['as' => 'applications', 'uses' => 'ApplicationController@index']);

    // <editor-fold defaultstate="collapsed" desc="Users">
    Route::get(trans('route.users'), ['as' => 'users', 'uses' => 'UserController@index']);
    Route::get(trans('route.users_new'), ['as' => 'users_new', 'uses' => 'UserController@create']);
    Route::get(trans('route.users_show'), ['as' => 'users_show', 'uses' => 'UserController@show']);
    Route::post(trans('route.users_save'), ['as' => 'users_save', 'uses' => 'UserController@save']);
    Route::post(trans('route.users_send'), ['as' => 'users_send', 'uses' => 'UserController@send']);
    Route::post(trans('route.users_delete'), ['as' => 'users_delete', 'uses' => 'UserController@delete']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Customers">
    Route::get(trans('route.customers'), ['as' => 'customers', 'uses' => 'CustomerController@index']);
    Route::get(trans('route.customers_new'), ['as' => 'customers_new', 'uses' => 'CustomerController@create']);
    Route::get(trans('route.customers_show'), ['as' => 'customers_show', 'uses' => 'CustomerController@show']);
    Route::post(trans('route.customers_save'), ['as' => 'customers_save', 'uses' => 'CustomerController@save']);
    Route::post(trans('route.customers_delete'), ['as' => 'customers_delete', 'uses' => 'CustomerController@delete']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Orders">
    Route::get(trans('route.application_form_create'), ['as' => 'application_form_create', 'uses' => 'OrderController@appForm']);
    Route::get(trans('route.orders'), ['as' => 'orders', 'before' => 'auth', 'uses' => 'OrderController@index']);
    Route::get(trans('route.orders_new'), ['as' => 'orders_new', 'before' => 'auth', 'uses' => 'OrderController@create']);
    Route::get(trans('route.orders_show'), ['as' => 'orders_show', 'before' => 'auth', 'uses' => 'OrderController@show']);
    Route::post(trans('route.orders_save'), ['as' => 'orders_save', 'uses' => 'OrderController@save']);
    Route::post(trans('route.orders_delete'), ['as' => 'orders_delete', 'before' => 'auth|csrf', 'uses' => 'OrderController@delete']);
    Route::post(trans('route.orders_uploadfile'), ['as' => 'orders_uploadfile', 'uses' => 'OrderController@uploadfile']);
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="managements">
    Route::get(trans('route.managements_list'), ['as' => 'managements_list', 'uses' => 'ManagementController@index']);
    Route::any('managements/import', ['as' => 'managements_importlanguages', 'uses' => 'ManagementController@importlanguages']);
    Route::any('managements/export', ['as' => 'managements_exportlanguages', 'uses' => 'ManagementController@exportlanguages']);
    // </editor-fold>

});

event(new WebRouteLoadedEvent());
Auth::routes();