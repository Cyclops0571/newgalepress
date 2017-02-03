<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en"> <!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <title>404</title>
    <meta name="author" content="ukieweb" />
    <meta name="keywords" content="404 page, worker, css3, template, html5 template" />
    <meta name="description" content="404 - Page Template" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!-- Libs CSS -->
    <link type="text/css" media="all" href="/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Template CSS -->
    <link type="text/css" media="all" href="/css/error404.css" rel="stylesheet" />
    <!-- Responsive CSS -->
<!--    <link type="text/css" media="all" href="/css/respons.css" rel="stylesheet" />-->

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicons/favicon144x144.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicons/favicon114x114.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicons/favicon72x72.png" />
    <link rel="apple-touch-icon" href="/img/favicons/favicon57x57.png" />
    <link rel="shortcut icon" href="/img/favicons/favicon.png" />
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300italic,800italic,800,700italic,700,600italic,600,400italic,300' rel='stylesheet' type='text/css' />
    <!-- Scripts -->
    <script src="/js/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/js/modernizr.js" type="text/javascript"></script>
    <script src="/js/jquery.nicescroll.min.js" type="text/javascript"></script>

</head>
<body>

<!-- Load page -->
<div class="animationload">
    <div class="loader">
    </div>
</div>
<!-- End load page -->


<!-- Content Wrapper -->
<div id="wrapper">
    <div class="container">

        <!-- brick of wall -->
        <div class="brick"></div>
        <!-- end brick of wall -->

        <!-- Number -->
        <div class="number">
            <div class="four"></div>
            <div class="zero">
                <div class="nail"></div>
            </div>
            <div class="four"></div>
        </div>
        <!-- end Number -->

        <!-- Info -->
        <div class="info">
            <h3><?php echo __('error.something_went_wrong'); ?></h3>
            <p><?php echo __('error.your_page_not_found'); ?></p>
            <a href="/" class="btn" style="text-transform: uppercase"><?php echo __('route.home'); ?></a>
        </div>
        <!-- end Info -->


    </div>
    <!-- end container -->
</div>
<!-- end Content Wrapper -->

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <!-- Worker -->
        <div class="worker"></div>
        <!-- Tools -->
        <div class="tools"></div>
    </div>
    <!-- end container -->
</footer>
<!-- end Footer -->
<script type="text/javascript">
    $(function () {
        "use strict";
        $(".loader").delay(400).fadeOut();
        $(".animationload").delay(400).fadeOut("fast");
    });

    /*
     ----------------------------------------------------------------------
     Nice scroll
     ----------------------------------------------------------------------
     */
    $("html").niceScroll({
        cursorcolor: '#fff',
        cursoropacitymin: '0',
        cursoropacitymax: '1',
        cursorwidth: '2px',
        zindex: 999999,
        horizrailenabled: false,
        enablekeyboard: false
    });


</script>


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</body>
</html>