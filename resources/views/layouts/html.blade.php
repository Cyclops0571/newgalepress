<!DOCTYPE html>
<html>
<!--[if lte IE 10]>
<script type="text/javascript">
    window.location = "http://browser-update.org/update.html";
</script>
<![endif]-->
<head>
    @section('head')
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ config('custom.companyname') }}</title>
        <!-- Meta tags -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="content-Language" content="{{Common::metaContentLanguage()}}"/>
        <meta name="MSSmartTagsPreventParsing" content="true"/>
        <meta name="revisit-after" content="3 days"/>
        <meta name="keywords" content=""/>
        <meta name="author" content="Serdar Saygılı"/>
        <meta name="copyright" content="Gale Press Technology"/>
        <meta name="company" content="Detay Danışmanlık Bilgisayar Hiz. San. ve Dış Tic. A.Ş."/>
        <meta name="description" content=""/>
        <meta name="verify-v1" content=""/>
        <meta name="robots" content="all"/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="/images/website/favicon2.ico">

        <!-- Begin CSS-->
        <link media="print" type="text/css" rel="stylesheet" href="/css/print.css"/>
        <link media="screen" type="text/css" rel="stylesheet"
              href="/fonts/open-sans-condensed/css/open-sans-condensed.css"/>
        <link media="screen" type="text/css" rel="stylesheet" href="/uploadify/uploadify.css"/>
        <link media="screen" type="text/css" rel="stylesheet" href="/chosen_v1.0.0/chosen.css"/>
        <link media="screen" type="text/css" rel="stylesheet" href="/css/template-chooser/master.css"/>
        <link media="screen" type="text/css" rel="stylesheet" href="{{elixir('/css/galepress-all.css')}}"/>

        <!-- Begin JavaScript -->
        @include('js.language')
        <script src="/js/jquery-2.1.4.min.js"></script>
        <script src="/js/jquery-ui-1.10.4.custom.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/bootstrap-editable.min.js"></script>
        <script src="/js/bootstrap-toggle.min.js"></script>
        <script src="/js/jquery.mask.min.js"></script>
        <script src="/js/jquery.uniform.min.js"></script>
        <script src="/js/jquery.knob.js"></script>
        <script src="/js/colorpicker.js"></script>
        <script src="/js/flot/jquery.flot.min.js"></script>
        <script src="/js/flot/jquery.flot.animator.js"></script>
        <script src="/js/flot/jquery.flot.resize.js"></script>
        <script src="/js/flot/jquery.flot.grow.js"></script>
        <script src="/uploadify/jquery.uploadify-3.1.min.js"></script>
        <script src="/jupload/js/jquery.iframe-transport.js"></script>
        <script src="/jupload/js/jquery.fileupload.js"></script>
        <script src="/chosen_v1.0.0/chosen.jquery.min.js"></script>
        <script src="/js/jquery.base64.decode.js"></script>
        <script src="/js/jquery.qtip.js"></script>
        <script src="/js/jquery.cookie.js"></script>
        <script src="/jqplot/jquery.jqplot.min.js"></script>
        <script src="/jqplot/jqplot.barRenderer.min.js"></script>
        <script src="/jqplot/jqplot.highlighter.min.js"></script>
        <script src="/jqplot/jqplot.dateAxisRenderer.min.js"></script>
        <script src="/jqplot/jqplot.categoryAxisRenderer.min.js"></script>
        <script src="{{elixir('/js/gurus.js')}}"></script>
        <script src="{{elixir('/js/projectcore.js')}}"></script>
        <script src="/js/session-check.js"></script>
        <script src="/js/lib.js"></script>

    @show
</head>
@yield('body')

</html>