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
    <link rel="stylesheet" href="{{elixir('css/interactive.css')}}">
    <link rel="stylesheet" href="/uploadify/uploadify.css">
    @include('js.language')
  </head>
  <body>
    @yield('body-content')
    @yield("components")

    <script src="{{elixir('/js/jquery.js')}}"></script>
    <script src="{{elixir('/js/jquery-ui.js')}}"></script>
    <script src="{{elixir('/js/gurus.js')}}"></script>
    <script src="{{elixir('/js/galepress-interactivity.js')}}"></script>
    <script src="/js/SCF.ui.js" ></script>
    <script src="{{elixir('/js/interactive.js')}}" ></script>
    <script src="/uploadify/jquery.uploadify-3.1.min.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/chosen_v1.0.0/chosen.jquery.js" ></script>
    <script src="/js/zoom_assets/jquery.smoothZoom.js?v=<?php echo APP_VER; ?>"></script>
    <script src="/js/jquery.gselectable.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/js/jquery.component.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/js/jquery.collapse.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/js/jquery.easytabs.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/js/redactor.min.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/js/jquery.colorPicker.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/js/respond.min.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/jupload/js/jquery.iframe-transport.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/jupload/js/jquery.fileupload.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/js/session-check.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/js/lib.interactivity.js?v=<?php echo APP_VER; ?>" ></script>
    <script src="/ckeditor/ckeditor.js?v=<?php echo APP_VER; ?>" ></script>
  </body>
</html>