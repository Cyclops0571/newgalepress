<!DOCTYPE html><!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ --><!--[if gt IE 9]><!-->
<html class="no-js" lang="en">
  <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <!-- Set the viewport width to device width for mobile -->
    <title>Gale Press</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Content">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="shortcut icon" href="/images/website/favicon2.ico">
    <!-- Included CSS Files -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=all" />
    <link rel="stylesheet" href="/css/interactive.css">
    <link rel="stylesheet" href="/chosen_v1.0.0/chosen.css"/>
    <link rel="stylesheet" href="/uploadify/uploadify.css">
    @include('js.language')
  </head>
  <body>
    @yield('body-content')
    @yield("components")
    <script src="/js/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/gurus.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/uploadify/jquery.uploadify-3.1.min.js" ></script>
    <script src="/js/fullscreen.js"></script>
    <script src="/js/SCF.ui.js" ></script>
    <script src="/chosen_v1.0.0/chosen.jquery.min.js" ></script>

    <script src="/js/interactive.js" ></script>

    <script src="/js/zoom_assets/jquery.smoothZoom.js"></script>
    <script src="/js/jquery.gselectable.js" ></script>
    <script src="/js/jquery.component.js" ></script>

    <script src="/js/jquery.collapse.js" ></script>
    <script src="/js/jquery.easytabs.js" ></script>
    <script src="/js/redactor.min.js" ></script>
    <script src="/js/jquery.colorPicker.js" ></script>
    <script src="/js/respond.min.js" ></script>
    <script src="/jupload/js/jquery.iframe-transport.js" ></script>
    <script src="/jupload/js/jquery.fileupload.js" ></script>

    {{--<script src="/js/gurus.projectcore.js"></script>--}}
    <script src="/js/galepress-interactivity.js"></script>
    <script src="/js/session-check.js" ></script>
    <script src="/js/lib.interactivity.js" ></script>
    <script src="/ckeditor/ckeditor.js" ></script>


  </body>
</html>