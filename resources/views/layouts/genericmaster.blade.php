<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ Config::get('custom.companyname') }}</title>
    <!-- Meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="content-Language" content="{{Common::metaContentLanguage()}}"/>
    <meta http-equiv="imagetoolbar" content="false"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Serdar Saygılı"/>
    <meta name="copyright" content="Gale Press Technology"/>
    <meta name="company" content="Detay Danışmanlık Bilgisayar Hiz. San. ve Dış Tic. A.Ş."/>
    <link rel="shortcut icon" href="/website/img/favicon2.ico">

    <!-- Latest compiled and minified CSS -->
    {{ Html::style('css/mobilestyle.css?v=' . APP_VER) }}
    {{ Html::style('css/bootstrap.min.css?v=' . APP_VER) }}
    {{ Html::script('js/jquery-2.1.4.min.js') }}
    {{ Html::script('js/jquery-ui-1.10.4.custom.min.js') }}
    {{ Html::script('js/bootstrap.min.js') }}
    {{ Html::script('js/generic.js?v=' . APP_VER) }}
    {{ Html::script('js/client.js?v=' . APP_VER) }}
</head>
<body>
<script>
    var currentLanguage = <?php echo json_encode(app()->getLocale()); ?>;
</script>
<style>
    /* statusbar */
    .statusbar {
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 10px;
        background: rgba(0, 0, 0, 0.70);
        z-index: 99;
    }

    .statusbar .statusbar-icon {
        float: left;
        margin-right: 10px;
        padding: 3px 0;
    }

    .statusbar .statusbar-icon [class^=icon] {
        font-size: 20px;
        line-height: 24px;
    }

    .statusbar .statusbar-text {
        font-size: 12px;
        font-weight: lighter;
        color: #FFF;
        float: left;
        padding-right: 30px;
        line-height: 30px;
    }

    .statusbar .statusbar-body {
        float: left;
        padding-right: 30px;
    }

    .statusbar .statusbar-close {
        position: absolute;
        right: 15px;
        top: 50%;
        margin-top: -8px;
        cursor: pointer;
        opacity: 0.2;
        filter: alpha(opacity=20);
    }

    .statusbar .statusbar-close:hover {
        opacity: 0.5;
        filter: alpha(opacity=50);
    }

    .statusbar.statusbar-info {
        background: rgba(47, 132, 177, 0.70);
    }

    /* #2F84B1 */
    .statusbar.statusbar-danger {
        background: rgba(175, 47, 47, 0.70);
    }

    /* #AF2F2F */
    .statusbar.statusbar-success {
        background: rgba(89, 173, 47, 0.70);
    }

    /* #FFA91F */
    .statusbar.statusbar-warning {
        background: rgba(255, 169, 31, 0.70);
    }

    /* #59AD2F */
    /* eof statusbar */
</style>
<div class="col-md-12">
    @yield('content')
</div>
</body>
</html>