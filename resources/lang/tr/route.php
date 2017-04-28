<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Route Language Lines
    |--------------------------------------------------------------------------
    */

    'login' => 'giris',
    'forgotmypassword' => 'parolami-unuttum',
    'resetmypassword' => 'parolami-sifirla',
    'logout' => 'cikis',
    'home' => 'anasayfa',
    'dashboard' => 'dashboard',
    'mydetail' => 'kullanici-bilgilerim',
    'shop' => 'odeme',

    'users' => 'kullanicilar',
    'users_new' => 'kullanicilar/yeni',
    'users_show' => 'kullanicilar/(:num)',
    'users_save' => 'kullanicilar/kaydet',
    'users_send' => 'kullanicilar/gonder',
    'users_delete' => 'kullanicilar/sil',

    'clients' => 'mobil-kullanici',
    'clients_new' => 'mobil-kullanici/yeni',
    'clients_save' => 'mobil-kullanici/kaydet',
    'clients_send' => 'mobil-kullanici/gonder',
    'clients_delete' => 'mobil-kullanici/sil',
    'clients_register' => 'mobil-kullanici/kayitol/{application}',
    'clients_update' => 'mobil-kullanici/guncelle/(:num)/(:any)',
    'clients_register_save' => 'mobil-kullanici/kayitol',
    'clients_registered' => 'mobil-kullanici/kayit-basarili',
    'clients_forgotpassword' => 'mobil-kullanici/sifremi-unuttum/{application}',
    'clients_resetpw' => 'mobil-kullanici/parolami-sifirla',
    'clients_pw_reseted' => 'mobil-kullanici/sifre-yenilendi',

    'customers' => 'musteriler',
    'customers_new' => 'musteriler/yeni',
    'customers_show' => 'musteriler/(:num)',
    'customers_save' => 'musteriler/kaydet',
    'customers_delete' => 'musteriler/sil',

    'applications' => 'uygulamalar',
    'applications_new' => 'uygulamalar/yeni',
    'applications_show' => 'uygulamalar/{application}',
    'applications_pushnotification' => 'uygulamalar/(:num)/bildirim-gonder',
    'applications_save' => 'uygulamalar/kaydet',
    'applications_delete' => 'uygulamalar/sil',
    'applications_uploadfile' => 'uygulamalar/dosya-yukle',
    'applications_settings' => 'uygulamalar/{application}/ayarlar',
    'application_settings_save' => 'applications/applicationSetting',

    'contents' => 'icerikler',
    'contents_request' => 'icerikler/talep',
    'contents_new' => 'icerikler/yeni',
    'contents_show' => 'icerikler/(:num)',
    'contents_save' => 'icerikler/kaydet',
    'contents_delete' => 'icerikler/sil',
    'contents_uploadfile' => 'icerikler/dosya-yukle',
    'contents_uploadcoverimage' => 'icerikler/kapakresmi-yukle',
    'contents_uploadcoverimage2' => 'icerikler/kapakresmi-yukle2',

    'contents_passwords' => 'parolalar',
    'contents_passwords_save' => 'parolalar/kaydet',
    'contents_passwords_delete' => 'parolalar/sil',

    'application_form_create' => 'uygulamaformu',

    'orders' => 'siparisler',
    'orders_new' => 'siparisler/yeni',
    'orders_show' => 'siparisler/(:num)',
    'orders_save' => 'siparisler/kaydet',
    'orders_delete' => 'siparisler/sil',
    'orders_uploadfile' => 'siparisler/dosya-yukle',

    'categories' => 'kategoriler',
    'categories_save' => 'kategoriler/kaydet',
    'categories_delete' => 'kategoriler/sil',

    'reports' => 'raporlar',
    'reports_location_country' => 'raporlar/konum/ulke',
    'reports_location_city' => 'raporlar/konum/sehir',
    'reports_location_district' => 'raporlar/konum/ilce',

    'interactivity' => 'etkilesimli-pdf',
    'interactivity_show' => 'etkilesimli-pdf/{content}',
    'interactivity_refreshtree' => 'etkilesimli-pdf/agaci-yenile',
    'interactivity_fb' => 'flipbook/(:num)',
    'interactivity_preview' => 'etkilesimli-pdf/onizle',
    'interactivity_check' => 'etkilesimli-pdf/kontrolet',
    'interactivity_save' => 'etkilesimli-pdf/kaydet',
    'interactivity_transfer' => 'etkilesimli-pdf/aktar',
    //'interactivity_delete' => 'interactive-pdf/sil',
    'interactivity_upload' => 'etkilesimli-pdf/yukle',
    'interactivity_loadpage' => 'etkilesimli-pdf/sayfayukle',

    'website_advantages' => 'avantajlar',
    'website_tutorials' => 'calisma-yapisi',
    'website_contact' => 'iletisim',
    'website_sitemap' => 'site-haritasi',
    'website_search' => 'arama',
    'website_blog' => 'blog',
    'website_blog_news' => 'blog-haberler',
    'website_blog_tutorials' => 'blog-egitim-videolari',
    'website_sectors' => 'cozumler',
    'website_showcase' => 'referanslar',
    'website_sectors_retail' => 'cozumler-perakende',
    'website_sectors_humanresources' => 'cozumler-insan-kaynaklari',
    'website_sectors_education' => 'cozumler-egitim',
    'website_sectors_realty' => 'cozumler-gayrimenkul',
    'website_sectors_medicine' => 'cozumler-ilac',
    'website_sectors_digitalpublishing' => 'cozumler-dijital-yayincilik',
    'website_tryit' => 'deneyin',
    'website_captcha' => 'mecaptcha',
    'website_why_galepress' => 'nasil-calisir',
    'website_payment_result' => 'odeme-sonuc/(:all)',

    'confirmemail' => 'hesab-onayla',

    'crop_image' => 'crop/image',

    'facebook_attempt' => 'giris-facebook',

    'maps' => 'harita',
    'maps_show' => 'harita/{googleMap}',
    'maps_new' => 'harita/yeni',
    'maps_save' => 'harita/kaydet',
    'maps_location' => 'harita/konum/',

    'banners' => 'banners',
    'banners_new' => 'banners/yeni',
    'banners_save' => 'banners/kaydet',
    'banners_setting_save' => 'banners/setting_save',
    'banners_delete' => 'banners/sil/',
    'banners_order' => 'banners/sira/',

    'my_ticket' => 'mytickets',

    'managements_list' => 'managements/list',
    'managements_save' => 'managements/save',

    'sign_up' => 'musteri/kaydol',
    'forgot_password' => 'musteri/parolahatirlatma',
    'sign_in' => 'musteri/giris',

    'payment_approvement' => 'odeme/onay',
    'payment_card_info' => 'odeme/kart-bilgisi',
    'contents_interactivity_status' => 'contents/interactivity_status'
);