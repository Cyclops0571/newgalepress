<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<!-- Set the viewport width to device width for mobile -->
    <title>Gale Press</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Content">
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="shortcut icon" href="/website/img/favicon2.ico">
<!-- Included CSS Files -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=all' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="/css/app.css?v=<?php echo APP_VER; ?>" type="text/css">
<link rel="stylesheet" href="/css/app-extra.css?v=<?php echo APP_VER; ?>" type="text/css">
<link rel="stylesheet" href="/css/font-awesome.css?v=<?php echo APP_VER; ?>" type="text/css">
<link rel="stylesheet" href="/css/redactor.css?v=<?php echo APP_VER; ?>" type="text/css">
<link rel="stylesheet" href="/css/colorpicker.css?v=<?php echo APP_VER; ?>" type="text/css">
<link rel="stylesheet" href="/uploadify/uploadify.css?v=<?php echo APP_VER; ?>" type="text/css">
@include('js.language')
<script src="/js/modernizr.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script><!-- IE Fix for HTML5 Tags -->

<!--
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js?v=<?php echo APP_VER; ?>"></script>
-->

<script src="/js/vendor/jquery.min.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/bootstrap.min.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/jquery.base64.decode.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/gurus.common.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/gurus.string.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/gurus.date.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/vendor/jquery-ui.js?v=<?php echo APP_VER; ?>"></script>
<script src="/uploadify/jquery.uploadify-3.1.min.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/fullscreen.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/vendor/chosen.jquery.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/vendor/jquery.placeholder.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/Equalizer.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/appreciate.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/commutator.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/datepicker.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/pagination.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/scrollbox.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/slideshow.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/tabbox.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/starbar.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/checkbox.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/radio.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/player.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/SCF.ui/currentlyPlaying.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/jquery.cookie.js?v=<?php echo APP_VER; ?>"></script>
<script src="/js/zoom_assets/jquery.smoothZoom.js?v=<?php echo APP_VER; ?>"></script>
<script src="/js/jquery.gselectable.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/jquery.component.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js?v=<?php echo APP_VER; ?>"></script>
<![endif]-->
</head>
<body>
@yield('body-content')
<script src="/js/jquery.collapse.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/jquery.easytabs.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/redactor.min.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/jquery.colorPicker.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/respond.min.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/bundles/jupload/js/jquery.iframe-transport.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/bundles/jupload/js/jquery.fileupload.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>

<?php
$components = DB::table('Component')
	->where('StatusID', '=', eStatus::Active)
	->orderBy('DisplayOrder', 'ASC')
	->get();
?>
@foreach($components as $component)
<script id="tool-{{ $component->Class }}" type="text/html">{{ View::make('interactivity.components.'.$component->Class.'.tool') }}</script>
<script id="prop-{{ $component->Class }}" type="text/html">{{ View::make('interactivity.components.'.$component->Class.'.property', array('ComponentID' => $component->ComponentID, 'PageComponentID' => 0, 'Process' => 'new', 'PageCount' => count($pages))) }}</script>
@endforeach

<script src="/js/gurus.projectcore.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/session-check.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/lib.interactivity.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
<script src="/js/ckeditor/ckeditor.js?v=<?php echo APP_VER; ?>" type="text/javascript"></script>
</body>
</html>