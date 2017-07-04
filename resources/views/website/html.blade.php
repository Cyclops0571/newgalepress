<!DOCTYPE html>
<!--[if lte IE 10]>
<script type="text/javascript">
    window.location = "http://browser-update.org/update.html";
</script>
<![endif]-->
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{__('website.title')}}</title>
    <meta name="keywords" content="{{__('website.keywords')}}"/>
    <meta name="description" content="{{__('website.description')}}">
    <meta name="author" content="galepress.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Pinterest Code -->
    <meta name="p:domain_verify" content="bd06007c526f4484a919814eab99d5e6"/>
    <link rel="shortcut icon" href="/images/website/favicon2.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Web Fonts Start -->
    <script src="https://use.typekit.net/gyn6uqi.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>
    <!-- Web Fonts End -->

    {{--<link rel="stylesheet" href="{{ elixir('css/website.css') }}">--}}

    <link rel="stylesheet" href="http://www.galepress.com/website/styles/font-awesome.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/owl.carousel.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/owl.theme.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/slit-slider-style.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/slit-slider-custom.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/idangerous.swiper.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/yamm.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/animate.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/prettyPhoto.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/bootstrap-slider.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/device-mockups2.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/bootstrap.min.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/main.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/main-responsive.css?v=96">
    <link id="primary_color_scheme" rel="stylesheet"
          href="http://www.galepress.com/website/styles/theme_royalblue.css?v=96">
    <link rel="stylesheet" href="http://www.galepress.com/website/styles/myStyles.css?v=96">
    <script src="http://www.galepress.com/website/scripts/vendor/modernizr.js"></script>
    <noscript>
        <link rel="stylesheet" href="http://www.galepress.com/website/styles/styleNoJs.css?v=96">
    </noscript>


@if(App::isLocale('tr'))
<!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var $_Tawk_API = {}, $_Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/57986662bcbba63963f953aa/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
@endif

<!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TTGX2S');</script>
    <!-- End Google Tag Manager -->


</head>


<body>
<!-- End Google Tag Manager (noscript) -->
<div id="load"></div>
<div class="page">
    @include('website.header')
    @yield('body-content')
    @include('website.footer')
    <?php if(!App::isLocale('tr')): ?>
    <div id="back_to_top"><a href="#" class="fa fa-arrow-up fa-lg"></a></div>
    <?php endif; ?>
</div>

<script type="text/javascript" src="{{ elixir('js/website.js') }}"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-42887832-1', 'galepress.com');
    ga('send', 'pageview');
</script>
<div class="search-result" style="position:absolute; top:-100px; left:0">
    <script>
        (function () {
            var cx = '003558081527571790912:iohyqlcsz2m';
            var gcse = document.createElement('script');
            gcse.type = 'text/javascript';
            gcse.async = true;
            gcse.src = 'https://www.google.com/cse/cse.js?cx=' + cx;
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(gcse, s);
        })();
    </script>
    <gcse:search></gcse:search>
</div>

<script type="text/javascript">
    var SelectedLanguage = {!! json_encode(App::getLocale()) !!}
    var Languages = {!! json_encode(config('app.languages')) !!}
    $(function () {
        var j = 1;
        for (var i = 0; i < Languages.length; i++) {
            if (SelectedLanguage === Languages[i]) {
                $('.dropdown.languageChange > a').attr('href', '/' + Languages[i]);
                $('.dropdown.languageChange > a img').attr('src', '/images/website/flags/' + Languages[i] + 'Flag.png');
            } else if (Languages[i] != 'tr') {
                $('.dropdown.languageChange ul li:nth-child(' + j + ') a').attr('href', '/' + Languages[i]);
                $('.dropdown.languageChange ul li:nth-child(' + j + ') a img').attr('src', '/images/website/flags/' + Languages[i] + 'Flag.png');
                j++;
            }
        }

        $('.dropdown.languageChange ul li').click(function (event) {
            var target = $(event.target);
            if (target.is('a')) {
                $('.dropdown.languageChange > a img').attr('src', $(event.target).find('img').attr('src'));
                for (var i = 0; i < Languages[i]; i++) {
                    if (SelectedLanguage === Languages[i]) {
                        $('.dropdown.languageChange ul li:first-child a img').attr('src', '/images/website/flags/' + Languages[i] + 'Flag.png');
                    }
                }
            }
        });

        if ($('#blogIframe').length > 0 || $('#blogIframeNews').length > 0 || $('#blogIframeTutorials').length > 0) {
            var waitForFinalEvent = (function () {
                var timers = {};
                return function (callback, ms, uniqueId) {
                    if (!uniqueId) {
                        uniqueId = "Don't call this twice without a uniqueId";
                    }
                    if (timers[uniqueId]) {
                        clearTimeout(timers[uniqueId]);
                    }
                    timers[uniqueId] = setTimeout(callback, ms);
                };
            })();

            if ($('#blogIframe').length > 0) {
                $('#blogIframe').load(function () {
                    $('#blogIframe').css('min-height', $('#blogIframe').contents().find('body').height() + 50);
                });
            }
            if ($('#blogIframeNews').length > 0) {
                $('#blogIframeNews').load(function () {
                    $('#blogIframeNews').css('min-height', $('#blogIframeNews').contents().find('body').height() + 50);
                });
            }
            if ($('#blogIframeTutorials').length > 0) {
                $('#blogIframeTutorials').load(function () {
                    $('#blogIframeTutorials').css('min-height', $('#blogIframeTutorials').contents().find('body').height() + 50);
                });
            }

            $(window).resize(function () {
                waitForFinalEvent(function () {
                    if ($('#blogIframe').length > 0) {
                        $('#blogIframe').css('min-height', $('#blogIframe').contents().find('body').height() + 50);
                    }
                    if ($('#blogIframeNews').length > 0) {
                        $('#blogIframeNews').css('min-height', $('#blogIframeNews').contents().find('body').height() + 50);
                    }
                    if ($('#blogIframeTutorials').length > 0) {
                        $('#blogIframeTutorials').css('min-height', $('#blogIframeTutorials').contents().find('body').height() + 50);
                    }
                }, 500, "resizeMyIframe");
            });
        }
    })
</script>
<noscript><img height="1" width="1" alt="" style="display:none"
               src="https://www.facebook.com/tr?ev=6022106543310&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1"/>
</noscript>
</body>
</html>