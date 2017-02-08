<?php
Route::get('test2', 'TestController@test2');
Route::get('test3', function(){ return View::make('test/test3'); });

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => 'auth'], function (){
    Route::get('test', 'TestController@index');
    Route::get(__('route.home'), array('as' => 'home', 'uses' => 'CommonController@home'));
    Route::get(__('route.dashboard'), array('as' => 'common_dashboard', 'before' => 'auth', 'uses' => 'CommonController@dashboard'));
    Route::get(__('route.forgotmypassword'), array('as' => 'common_forgotmypassword_get', function() {
        return View::make('pages.forgotmypassword');
    }));
    Route::post(__('route.forgotmypassword'), array('as' => 'Co0mmonController_forgotmypassword', 'uses' => 'CommonController@forgotmypassword'));

    Route::get(__('route.resetmypassword'), array('as' => 'common_resetmypassword_get', 'uses' => 'CommonController@resetPasswordPage'));
    Route::post(__('route.resetmypassword'), array('as' => 'common_resetmypassword_post', 'before' => 'csrf', 'uses' => 'CommonController@resetmypassword'));

    Route::get(__('route.logout'), array('as' => 'common_logout', 'uses' => 'CommonController@logout'));

    Route::get(__('route.mydetail'), array('as' => 'common_mydetail_get', 'uses' => 'CommonController@myDetailPage'));
    Route::post(__('route.mydetail'), array('as' => 'common_mydetail_post', 'uses' => 'CommonController@mydetail'));

    // <editor-fold defaultstate="collapsed" desc="Banners">
    Route::get(__('route.banners'), array('as' => 'banners_list', 'uses' => 'banners@index'));
    Route::get(__('route.banners_show'), array('as' => 'banners_show', 'uses' => 'banners@show'));
    Route::get(__('route.banners_new'), array('as' => 'banners_new', 'uses' => 'banners@new'));
    Route::post(__('route.banners_save'), array('as' => 'banners_save', 'uses' => 'banners@save'));
    Route::post(__('route.banners_setting_save'), array('as' => 'banners_setting_save', 'uses' => 'banners@save_banner_setting'));
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="maps">
    Route::get(__('route.maps'), array('as' => 'maps_list', 'uses' => 'maps@index'));
    Route::get(__('route.maps_show'), array('as' => 'maps_show', 'uses' => 'maps@show'));
    Route::get(__('route.maps_new'), array('as' => 'map_new', 'uses' => 'maps@new'));
    Route::post(__('route.maps_save'), array('as' => 'maps_save', 'uses' => 'maps@save'));
    Route::get(__('route.maps_location') . "{id}", array('as' => 'maps_location', 'uses' => 'maps@location'));
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Clients">
    Route::get(__('route.clients'), array('as' => 'clients_list', 'uses' => 'clients@index'));
    Route::get(__('route.clients_new'), array('as' => 'clients_new', 'uses' => 'clients@new'));
    Route::get(__('route.clients_show'), array('as' => 'clients_show', 'uses' => 'clients@show'));
    Route::post(__('route.clients_save'), array('as' => 'clients_save', 'uses' => 'clients@save'));
    Route::post(__('route.clients_send'), array('as' => 'clients_send', 'uses' => 'clients@send'));
    Route::post(__('route.clients_delete'), array('as' => 'clients_delete', 'uses' => 'clients@delete'));

    Route::get(__('route.clients_register'), array('as' => 'clients_register', 'uses' => 'clients@clientregister'));
    Route::get(__('route.clients_update'), array('as' => 'clients_register_save', 'uses' => 'clients@updateclient'));
    Route::get(__('route.clients_registered'), array('as' => 'clients_registered', 'uses' => 'clients@registered'));
    Route::get(__('route.clients_forgotpassword'), array('as' => 'clients_forgot_password', 'uses' => 'clients@forgotpassword'));
    Route::get(__('route.clients_resetpw'), array('as' => 'clients_reset_password', 'uses' => 'clients@resetpw'));
    Route::get(__('route.clients_pw_reseted'), array('as' => 'clients_password_renewed', 'uses' => 'clients@passwordreseted'));

    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Applications">
    Route::get(__('route.applications'), array('as' => 'applications', 'uses' => 'applications@index'));
    Route::get(__('route.applications_new'), array('as' => 'applications_new', 'uses' => 'applications@new'));
    Route::get(__('route.applications_show'), array('as' => 'applications_show', 'uses' => 'applications@show'));
    Route::post(__('route.applications_pushnotification'), array('as' => 'applications_push', 'uses' => 'applications@push'));
    Route::post(__('route.applications_save'), array('as' => 'applications_save', 'uses' => 'applications@save'));
    Route::post(__('route.applications_delete'), array('as' => 'applications_delete', 'uses' => 'applications@delete'));
    Route::post(__('route.applications_uploadfile'), array('as' => 'applications_uploadfile', 'uses' => 'applications@uploadfile'));
    Route::get(__('route.applications_usersettings'), array('as' => 'applications_usersettings', 'uses' => 'applications@applicationSetting'));
    // </editor-fold>

    // <editor-fold defaultstate="collapsed" desc="Contents">
    Route::post("contents/order/(:num)", array('as' => 'contents_order', 'before' => 'auth', 'uses' => 'contents@order'));
    Route::get("contents/remove_from_mobile/(:num)", array("as" => "content_remove_from_mobile", 'before' => 'auth', 'uses' => 'contents@remove_from_mobile'));
    Route::get(__('route.contents'), array('as' => 'contents_list', 'uses' => 'contents@index'));
    Route::get(__('route.contents_request'), array('as' => 'contents_request', 'uses' => 'contents@request'));
    Route::get(__('route.contents_new'), array('as' => 'contents_new', 'uses' => 'contents@new'));
    Route::get(__('route.contents_show'), array('as' => 'contents_show','uses' => 'contents@show'));
    Route::post(__('route.contents_save'), array('as' => 'contents_save','uses' => 'contents@save'));
    Route::get('/copy/(:num)/(:all)', array('as' => 'copy','uses' => 'contents@copy'));
    Route::post(__('route.contents_delete'), array('as' => 'contents_delete','uses' => 'contents@delete'));
    Route::post(__('route.contents_uploadfile'), array('as' => 'contents_uploadfile','uses' => 'contents@uploadfile'));
    Route::post(__('route.contents_uploadcoverimage'), array('as' => 'contents_uploadcoverimage', 'uses' => 'contents@uploadcoverimage'));
// </editor-fold>
});



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



Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
// <editor-fold defaultstate="collapsed" desc="website">
    Route::get(__('route.website_showcase'), function () {
        return View::make('website.pages.showcase');
    });
    Route::get(__('route.website_tutorials'), function () {
        return View::make('website.pages.tutorials');
    });
    Route::get(__('route.website_contact'), function () {
        return View::make('website.pages.contact');
    });
    Route::get(__('route.website_sectors'), function () {
        return View::make('website.pages.sectors');
    });
    Route::get(__('route.website_sectors_retail'), function () {
        return View::make('website.pages.sectors-retail');
    });
    Route::get(__('route.website_sectors_humanresources'), function () {
        return View::make('website.pages.sectors-humanresources');
    });
    Route::get(__('route.website_sectors_education'), function () {
        return View::make('website.pages.sectors-education');
    });
    Route::get(__('route.website_sectors_realty'), function () {
        return View::make('website.pages.sectors-realty');
    });
    Route::get(__('route.website_sectors_medicine'), function () {
        return View::make('website.pages.sectors-medicine');
    });
    Route::get(__('route.website_sectors_digitalpublishing'), function () {
        return View::make('website.pages.sectors-digitalpublishing');
    });
    Route::get(__('route.website_why_galepress'), function () {
        return View::make('website.pages.why-galepress');
    });
    Route::get(__('route.website_tryit'), function () {
        return View::make('website.pages.tryit');
    }); //571571 MeCaptcha\Captcha not found...
    Route::get('deneyin-test', function () {
        return View::make('website.pages.tryit-test');
    });//571571 MeCaptcha\Captcha not found...

    Route::get(__('route.login'), array('as' => 'common_login_get', 'uses' => 'CommonController@showMyLoginForm'));
    Route::post(__('route.login'), array('as' => 'common_login_post', 'uses' => 'CommonController@login'));

// </editor-fold>
});



/** Website Post */
Route::post(__('route.website_tryit'), array('as' => 'website_tryit_post', 'uses' => 'WebsiteController@tryit')); //571571 Test It
Route::post('deneyin-test', array('as' => 'website_tryit_test_post', 'uses' => 'WebsiteController@tryit'));//571571 Test It
Route::post(__('route.facebook_attempt'), array('as' => 'website_facebook_attempt_post', 'uses' => 'CommonController@facebookAttempt')); //571571 Test It

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
Route::group(['middleware' => 'auth'], function() {
    Route::post('iyzicoqr', 'IyzicoController@save');
    Route::get('open_iyzico_iframe/{qrCode}', 'IyzicoController@openIyzicoIframe');
    Route::any('checkout_result_form', array('as' => 'get_checkout_result_form', 'uses' => 'IyzicoController@checkoutIyzicoResultForm'));
});
//</editor-fold>


Route::post("clients/excelupload", array('before' => 'auth', 'uses' => "clients@excelupload"));
Route::post("maps/excelupload/(:num)", array('before' => 'auth', 'uses' => "maps@excelupload"));
Route::get("maps/delete", "maps@delete", array('before' => 'auth'));
Route::post((string)__('route.contents_interactivity_status'), array('uses' => "contents@interactivity_status"));

Route::post('/contactmail', array('as' => 'contactmail', 'uses' => 'WebsiteController@contactform'));
Route::post('/search', 'webservice.search@search');
Route::post('/searchgraff', 'webservice.search@searchgraff');


Route::get(__('appcreatewithface'), array('as' => 'appcreatewithface', 'uses' => 'WebsiteController@app_create_face'));

Route::get(__('route.website_article_workflow'), array('as' => 'website_article_workflow_get', 'uses' => 'WebsiteController@article_workflow'));
Route::get(__('route.website_article_brandvalue'), array('as' => 'website_article_brandvalue_get', 'uses' => 'WebsiteController@article_brandvalue'));
Route::get(__('route.website_article_whymobile'), array('as' => 'website_article_whymobile_get', 'uses' => 'WebsiteController@article_whymobile'));


//<editor-fold desc="Payment">
Route::get(__('route.shop'), array('as' => 'payment_shop', 'uses' => 'payment@shop'));
Route::get('payment-galepress', array('as' => 'website_payment_galepress_get', 'before' => 'auth', 'uses' => 'payment@payment_galepress'));
Route::post('payment-galepress', array('as' => 'website_payment_galepress_post', 'before' => 'auth', 'uses' => 'payment@payment_galepress'));
Route::post(__('route.payment_card_info'), array('as' => 'payment_card_info', 'before' => 'auth', 'uses' => 'payment@card_info'));
Route::post(__('route.payment_approvement'), array('as' => 'payment_approvement', 'before' => 'auth', 'uses' => 'payment@payment_approval'));
Route::get(__('route.website_payment_result'), array('as' => 'website_payment_result_get', 'uses' => 'payment@payment_result'));
//</editor-fold>

// <editor-fold defaultstate="collapsed" desc="Common">



Route::get(__('route.confirmemail'), array('as' => 'common_confirmemail_get', 'uses' => 'CommonController@confirmEmailPage'));
Route::get(__('route.my_ticket'), array('as' => 'my_ticket', 'before' => 'auth', 'uses' => 'CommonController@ticketPage'));

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Users">
Route::get(__('route.users'), array('as' => 'users', 'before' => 'auth', 'uses' => 'users@index'));
Route::get(__('route.users_new'), array('as' => 'users_new', 'before' => 'auth', 'uses' => 'users@new'));
Route::get(__('route.users_show'), array('as' => 'users_show', 'before' => 'auth', 'uses' => 'users@show'));
Route::post(__('route.users_save'), array('as' => 'users_save', 'before' => 'auth|csrf', 'uses' => 'users@save'));
Route::post(__('route.users_send'), array('as' => 'users_send', 'before' => 'auth|csrf', 'uses' => 'users@send'));
Route::post(__('route.users_delete'), array('as' => 'users_delete', 'before' => 'auth|csrf', 'uses' => 'users@delete'));
// </editor-fold>



// <editor-fold defaultstate="collapsed" desc="Customers">
Route::get(__('route.customers'), array('as' => 'customers', 'before' => 'auth', 'uses' => 'customers@index'));
Route::get(__('route.customers_new'), array('as' => 'customers_new', 'before' => 'auth', 'uses' => 'customers@new'));
Route::get(__('route.customers_show'), array('as' => 'customers_show', 'before' => 'auth', 'uses' => 'customers@show'));
Route::post(__('route.customers_save'), array('as' => 'customers_save', 'before' => 'auth|csrf', 'uses' => 'customers@save'));
Route::post(__('route.customers_delete'), array('as' => 'customers_delete', 'before' => 'auth|csrf', 'uses' => 'customers@delete'));
// </editor-fold>





// <editor-fold defaultstate="collapsed" desc="Password">
Route::get(__('route.contents_passwords'), array('as' => 'contents_passwords', 'before' => 'auth', 'uses' => 'contentpasswords@index'));
Route::post(__('route.contents_passwords_save'), array('as' => 'contents_passwords_save', 'before' => 'auth|csrf', 'uses' => 'contentpasswords@save'));
Route::post(__('route.contents_passwords_delete'), array('as' => 'contents_passwords_delete', 'before' => 'auth', 'uses' => 'contentpasswords@delete'));
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Orders">
Route::get(__('route.application_form_create'), array('as' => 'application_form_create', 'uses' => 'orders@appForm'));
Route::get(__('route.orders'), array('as' => 'orders', 'before' => 'auth', 'uses' => 'orders@index'));
Route::get(__('route.orders_new'), array('as' => 'orders_new', 'before' => 'auth', 'uses' => 'orders@new'));
Route::get(__('route.orders_show'), array('as' => 'orders_show', 'before' => 'auth', 'uses' => 'orders@show'));
//Route::post(__('route.orders_save'), array('as' => 'orders_save', 'before' => 'auth|csrf', 'uses' => 'orders@save'));
Route::post(__('route.orders_save'), array('as' => 'orders_save', 'uses' => 'orders@save'));
Route::post(__('route.orders_delete'), array('as' => 'orders_delete', 'before' => 'auth|csrf', 'uses' => 'orders@delete'));
Route::post(__('route.orders_uploadfile'), array('as' => 'orders_uploadfile', 'uses' => 'orders@uploadfile'));
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Category">
Route::get(__('route.categories'), array('as' => 'categories', 'before' => 'auth', 'uses' => 'categories@index'));
Route::post(__('route.categories_save'), array('as' => 'categories_save', 'before' => 'auth|csrf', 'uses' => 'categories@save'));
Route::post(__('route.categories_delete'), array('as' => 'categories_delete', 'before' => 'auth', 'uses' => 'categories@delete'));
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Reports">
Route::get(__('route.reports'), array('as' => 'reports', 'before' => 'auth', 'uses' => 'reports@index'));
Route::get(__('route.reports_show'), array('as' => 'reports_show', 'before' => 'auth', 'uses' => 'reports@show'));
Route::get(__('route.reports_location_country'), array('as' => 'reports_location_country', 'before' => 'auth', 'uses' => 'reports@country'));
Route::get(__('route.reports_location_city'), array('as' => 'reports_location_city', 'before' => 'auth', 'uses' => 'reports@city'));
Route::get(__('route.reports_location_district'), array('as' => 'reports_location_district', 'before' => 'auth', 'uses' => 'reports@district'));
// </editor-fold>


// <editor-fold defaultstate="collapsed" desc="Interactivity">
Route::get(__('route.interactivity_preview'), array('as' => 'interactivity_preview', 'before' => 'auth', 'uses' => 'interactivity@preview'));
Route::get(__('route.interactivity_show'), array('as' => 'interactivity_show', 'before' => 'auth', 'uses' => 'interactivity@show'));
Route::get(__('route.interactivity_fb'), array('as' => 'interactivity_fb', 'uses' => 'interactivity@fb'));
Route::post(__('route.interactivity_check'), array('as' => 'interactivity_check', 'before' => 'auth', 'uses' => 'interactivity@check'));
Route::post(__('route.interactivity_save'), array('as' => 'interactivity_save', 'before' => 'auth|csrf', 'uses' => 'interactivity@save'));
Route::post(__('route.interactivity_transfer'), array('as' => 'interactivity_transfer', 'before' => 'auth', 'uses' => 'interactivity@transfer'));
Route::post(__('route.interactivity_refreshtree'), array('as' => 'interactivity_refreshtree', 'before' => 'auth', 'uses' => 'interactivity@refreshtree'));
Route::post(__('route.interactivity_upload'), array('as' => 'interactivity_upload', 'before' => 'auth', 'uses' => 'interactivity@upload'));
Route::post(__('route.interactivity_loadpage'), array('as' => 'interactivity_loadpage', 'before' => 'auth', 'uses' => 'interactivity@loadpage'));
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Crop">
Route::get(__('route.crop_image'), array('as' => 'crop_image', 'before' => 'auth', 'uses' => 'crop@image'));
Route::post(__('route.crop_image'), array('as' => 'crop_image', 'before' => 'auth', 'uses' => 'crop@image'));
// </editor-fold>




Route::get(__('route.sign_up'), "WebsiteController@signUp");
Route::get(__('route.forgot_password'), "WebsiteController@forgotPassword");
Route::get(__('route.sign_in'), "WebsiteController@signIn");


// <editor-fold defaultstate="collapsed" desc="managements">
Route::get(__('route.managements_list'), array('as' => 'managements_list', 'uses' => 'managements@list'));
Route::get('managements/import', array('as' => 'managements_importlanguages', 'uses' => 'managements@importlanguages'));
Route::post('managements/import', array('as' => 'managements_importlanguages', 'uses' => 'managements@importlanguages'));
Route::post('managements/export', array('as' => 'managements_exportlanguages', 'uses' => 'managements@exportlanguages'));
// </editor-fold>


Route::post('/banners/imageupload', array('as' => 'banners_imageupload', 'uses' => 'banners@imageupload'));
Route::post('clients/clientregister', array('as' => 'clientsregistersave', 'uses' => 'clients@clientregister'));
Route::post('clients/forgotpassword', array('as' => 'clientsregistered', 'uses' => 'clients@forgotpassword'));
Route::post("clients/resetpw", array('as' => 'clientsresetpw', 'uses' => 'clients@resetpw'));
Route::post("applications/refresh_identifier", array('as' => 'applicationrefreshidentifier', 'uses' => 'applications@refresh_identifier'));
Route::post("contents/refresh_identifier", array('as' => 'contentrefreshidentifier', 'uses' => 'contents@refresh_identifier'));

Route::post('applications/applicationSetting', array('as' => 'save_applications_usersettings', 'before' => 'auth', 'uses' => 'applications@applicationSetting'));
Route::get("/csstemplates/(:any)", array('as' => 'template_index', 'uses' => 'applications@theme'));
Route::get("/template/(:num)", array('as' => 'template_index', 'before' => 'auth', 'uses' => 'template@index'));
Route::get("banners/delete", array('as' => 'banners_delete', 'before' => 'auth', 'uses' => 'banners@delete'));
Route::post("banners/order/(:num)", array('as' => 'banners_order', 'before' => 'auth', 'uses' => 'banners@order'));
Route::get("banners/service_view/(:num)", array('as' => 'banners_service_view', 'uses' => 'banners@service_view'));
Route::get('maps/webview/(:num)', array('as' => 'map_view', 'uses' => 'maps@webview'));
Route::get('payment/paymentAccountByApplicationID/(:num)', array('as' => 'app_payment_data', 'uses' => 'payment@paymentAccountByApplicationID'));

Route::get('3d-secure-response', array('as' => 'iyzico_3ds_return_url', 'before' => 'auth', 'uses' => 'payment@secure_3d_response'));
Route::post('3d-secure-response', array('as' => 'iyzico_3ds_return_url', 'before' => 'auth', 'uses' => 'payment@secure_3d_response'));

// WS
Route::get('ws/latest-version', array('uses' => 'ws.index@latestVersion'));

// <editor-fold defaultstate="collapsed" desc="WS v1.0.0">
// WS v1.0.0 -----------------------------------------------------------------------------------------------
// WS-Applications
Route::get('ws/v100/applications/(:num)/version', array('uses' => 'ws.v100.applications@version'));
Route::get('ws/v100/applications/(:num)/detail', array('uses' => 'ws.v100.applications@detail'));
Route::get('ws/v100/applications/(:num)/categories', array('uses' => 'ws.v100.applications@categories'));
Route::get('ws/v100/applications/(:num)/categories/(:num)/detail', array('uses' => 'ws.v100.applications@categoryDetail'));
Route::get('ws/v100/applications/(:num)/contents', array('uses' => 'ws.v100.applications@contents'));
// WS-Contents
Route::get('ws/v100/contents/(:num)/version', array('uses' => 'ws.v100.contents@version'));
Route::get('ws/v100/contents/(:num)/detail', array('uses' => 'ws.v100.contents@detail'));
Route::get('ws/v100/contents/(:num)/cover-image', array('uses' => 'ws.v100.contents@coverImage'));
Route::get('ws/v100/contents/(:num)/file', array('uses' => 'ws.v100.contents@file'));
// WS-Statistics
Route::post('ws/v100/statistics', array('uses' => 'ws.v100.statistics@create'));
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="WS v1.0.1">
// WS v1.0.1 -----------------------------------------------------------------------------------------------
// WS-Applications
Route::get('ws/v101/applications/(:num)/version', array('uses' => 'ws.v101.applications@version'));
Route::get('ws/v101/applications/(:num)/detail', array('uses' => 'ws.v101.applications@detail'));
Route::get('ws/v101/applications/(:num)/categories', array('uses' => 'ws.v101.applications@categories'));
Route::get('ws/v101/applications/(:num)/categories/(:num)/detail', array('uses' => 'ws.v101.applications@categoryDetail'));
Route::get('ws/v101/applications/(:num)/contents', array('uses' => 'ws.v101.applications@contents'));
// WS-Contents
Route::get('ws/v101/contents/(:num)/version', array('uses' => 'ws.v101.contents@version'));
Route::get('ws/v101/contents/(:num)/detail', array('uses' => 'ws.v101.contents@detail'));
Route::get('ws/v101/contents/(:num)/cover-image', array('uses' => 'ws.v101.contents@coverImage'));
Route::get('ws/v101/contents/(:num)/file', array('uses' => 'ws.v101.contents@file'));
// WS-Statistics
Route::post('ws/v101/statistics', array('uses' => 'ws.v101.statistics@create'));
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="WS v1.0.2">
// WS v1.0.2 -----------------------------------------------------------------------------------------------
// WS-Applications
Route::get('ws/v102/applications/(:num)/version', array('uses' => 'ws.v102.applications@version'));
Route::get('ws/v102/applications/(:num)/detail', array('uses' => 'ws.v102.applications@detail'));
Route::get('ws/v102/applications/(:num)/categories', array('uses' => 'ws.v102.applications@categories'));
Route::get('ws/v102/applications/(:num)/categories/(:num)/detail', array('uses' => 'ws.v102.applications@categoryDetail'));
Route::get('ws/v102/applications/(:num)/contents', array('uses' => 'ws.v102.applications@contents'));
Route::get('ws/v102/applications/authorized_application_list', array('uses' => 'ws.v102.applications@authorized_application_list'));
Route::post('ws/v102/applications/authorized_application_list', array('uses' => 'ws.v102.applications@authorized_application_list'));
// WS-Contents
Route::get('ws/v102/contents/(:num)/version', array('uses' => 'ws.v102.contents@version'));
Route::get('ws/v102/contents/(:num)/detail', array('uses' => 'ws.v102.contents@detail'));
Route::get('ws/v102/contents/(:num)/cover-image', array('uses' => 'ws.v102.contents@coverImage'));
Route::get('ws/v102/contents/(:num)/file', array('uses' => 'ws.v102.contents@file'));
// WS-Statistics
Route::post('ws/v102/statistics', array('uses' => 'ws.v102.statistics@create'));
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="New Webservice Routes">
Route::get('webservice/(:num)/applications/(:num)/version', array('uses' => 'webservice.applications@version'));
Route::post('webservice/(:num)/applications/(:num)/version', array('uses' => 'webservice.applications@version'));
Route::get('webservice/(:num)/applications/(:num)/detail', array('uses' => 'webservice.applications@detail'));
Route::post('webservice/(:num)/applications/(:num)/detail', array('uses' => 'webservice.applications@detail'));
Route::get('webservice/(:num)/applications/(:num)/categories', array('uses' => 'webservice.applications@categories'));
Route::get('webservice/(:num)/applications/(:num)/categories/(:num)/detail', array('uses' => 'webservice.applications@categoryDetail'));

Route::get('webservice/(:num)/applications/(:num)/contents', array('uses' => 'webservice.applications@contents'));
Route::post('webservice/(:num)/applications/(:num)/receipt', array('uses' => 'webservice.applications@receipt'));
Route::post('webservice/(:num)/applications/(:num)/androidrestore', array('uses' => 'webservice.applications@androidrestore'));


Route::get('webservice/(:num)/applications/authorized_application_list', array('uses' => 'webservice.applications@authorized_application_list'));
Route::post('webservice/(:num)/applications/authorized_application_list', array('uses' => 'webservice.applications@authorized_application_list'));
Route::post('webservice/(:num)/applications/login_application', array('uses' => 'webservice.applications@login_application'));
Route::get('webservice/(:num)/applications/login_application', array('uses' => 'webservice.applications@login_application'));
Route::post('webservice/(:num)/applications/fblogin', array('uses' => 'webservice.applications@fblogin'));
// WS-Contents
Route::get('webservice/(:num)/contents/(:num)/version', array('uses' => 'webservice.contents@version'));
Route::get('webservice/(:num)/contents/(:num)/detail', array('uses' => 'webservice.contents@detail'));
Route::get('webservice/(:num)/contents/(:num)/cover-image', array('uses' => 'webservice.contents@coverImage'));
Route::get('webservice/(:num)/contents/(:num)/file', array('uses' => 'webservice.contents@file'));
// WS-Statistics
Route::post('webservice/(:num)/statistics', array('uses' => 'webservice.statistics@create'));
//WS-Topic
Route::any('webservice/(:num)/topic', array('uses' => 'webservice.topic@topic'));
Route::any('webservice/(:num)/application-topic', array('uses' => 'webservice.topic@applicationTopic'));


// </editor-fold>

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

/*Route::filter('before', function () {
    // Do stuff before every request to your application...
});

Route::filter('after', function ($response) {
    // Do stuff after every request to your application...
});

Route::filter('csrf', function () {
    if (Request::forged()) return Response::error('500');
    return null;
});

Route::filter('auth', function () {
    if (Auth::guest()) return Redirect::to(__('route.login'));
    return null;
});*/