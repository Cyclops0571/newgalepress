<!DOCTYPE html>
<!--[if IE 8]>          <html class="ie ie8"> <![endif]-->
<!--[if IE 9]>          <html class="ie ie9"> <![endif]-->
<!--[if gt IE 9]><!-->  <html> <!--<![endif]-->
    <head>
	@section('head')
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{ Config::get('custom.companyname') }}</title>
        <!-- Meta tags -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="content-Language" content="{{Common::metaContentLanguage()}}" />
        <meta http-equiv="imagetoolbar" content="false" />
        <meta name="MSSmartTagsPreventParsing" content="true" />
        <meta name="revisit-after" content="3 days" />
        <meta name="keywords" content="" />
        <meta name="author" content="Serdar Saygılı" />
            <meta name="copyright" content="Gale Press Technology"/>
        <meta name="company" content="Detay Danışmanlık Bilgisayar Hiz. San. ve Dış Tic. A.Ş." />
        <meta name="description" content="" />
        <meta name="verify-v1" content="" />
        <meta name="robots" content="all" />
        <link rel="shortcut icon" href="/website/img/favicon2.ico">

        <!-- Begin CSS-->
        {{ HTML::style('css/print.css?v=' . APP_VER, array('media' => 'print')) }}

	{{ HTML::style('css/bootstrap.min.css?v=' . APP_VER, array('media' => 'screen')) }}
	{{ HTML::style('css/jquery-ui.min.css?v=' . APP_VER, array('media' => 'screen')) }}
	{{ HTML::style('css/font-awesome.min.css?v=' . APP_VER, array('media' => 'screen')) }}
	{{ HTML::style('css/select2.css?v=' . APP_VER, array('media' => 'screen')) }}
	{{ HTML::style('css/stylesheet.css?v=' . APP_VER, array('media' => 'screen')) }}
	{{ HTML::style('css/backgrounds.css?v=' . APP_VER, array('media' => 'screen')) }}
	{{ HTML::style('css/themes.css?v=' . APP_VER, array('media' => 'screen')) }}
	{{ HTML::style('css/mystyles.css?v=' . APP_VER, array('media' => 'screen')) }}

        {{ HTML::style('css/general.css?v=' . APP_VER, array('media' => 'screen')) }}
        {{ HTML::style('css/fonts/open-sans-condensed/css/open-sans-condensed.css?v=' . APP_VER, array('media' => 'screen')) }}
        {{ HTML::style('css/myApp.css?v=' . APP_VER, array('media' => 'screen')) }}
        {{ HTML::style('uploadify/uploadify.css?v=' . APP_VER, array('media' => 'screen')) }}
        {{ HTML::style('js/chosen_v1.0.0/chosen.css?v=' . APP_VER,array('media' => 'screen'))}}
        {{ HTML::style('css/btn_interactive.css?v=' . APP_VER,array('media' => 'screen'))}}

        <link rel="stylesheet" href="/css/template-chooser/master.css?v=<?php echo APP_VER; ?>">
        <link rel="stylesheet" href="/website/styles/device-mockups2.css?v=<?php echo APP_VER; ?>">

        <!-- Begin JavaScript -->
        @include('js.language')

        {{ HTML::script('js/jquery-2.1.4.min.js') }}
        {{ HTML::script('js/jquery-ui-1.10.4.custom.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/jquery.mask.min.js') }}
        {{ HTML::script('js/jquery.uniform.min.js') }}
        {{ HTML::script('js/jquery.knob.js') }}
        {{ HTML::script('js/flot/jquery.flot.js') }}
        {{ HTML::script('js/flot/jquery.flot.animator.js') }}
        {{ HTML::script('js/flot/jquery.flot.resize.js') }}
        {{ HTML::script('js/flot/jquery.flot.grow.js') }}

        {{ HTML::script('uploadify/jquery.uploadify-3.1.min.js') }}
        {{ HTML::script('bundles/jupload/js/jquery.iframe-transport.js') }}
        {{ HTML::script('bundles/jupload/js/jquery.fileupload.js') }}

        {{ HTML::script('js/chosen_v1.0.0/chosen.jquery.min.js') }}
        {{ HTML::script('js/jquery.base64.decode.js') }}
        {{ HTML::script('js/jquery.qtip.js') }}
        {{ HTML::script('js/jquery.cookie.js?v=' . APP_VER) }}
        {{ HTML::script('js/gurus.common.js?v=' . APP_VER) }}
        {{ HTML::script('js/gurus.string.js?v=' . APP_VER) }}
        {{ HTML::script('js/gurus.date.js?v=' . APP_VER) }}
        {{ HTML::script('js/gurus.projectcore.js?v=' . APP_VER) }}
        {{ HTML::script('js/session-check.js?v=' . APP_VER) }}
        {{ HTML::script('js/lib.js?v=' . APP_VER) }}

        {{ HTML::script('js/jqplot/jquery.jqplot.min.js') }}
        {{ HTML::script('js/jqplot/jqplot.barRenderer.min.js') }}
        {{ HTML::script('js/jqplot/jqplot.highlighter.min.js') }}
        {{ HTML::script('js/jqplot/jqplot.dateAxisRenderer.min.js') }}
        {{ HTML::script('js/jqplot/jqplot.categoryAxisRenderer.min.js') }}

        {{ HTML::script('js/bootstrap-toggle.min.js') }}
        <!-- Begin pngfix-->
        <!--[if lt IE 7]>
        {{ HTML::script('js/DD_belatedPNG_0.0.8a.js') }}
        <script>
        DD_belatedPNG.fix('.modify, .arrow, a.extend, li.add a, li.remove a, #site_info a');
        </script>
        <![endif]-->
    </head>
    <body>
	<input class="form-control required" type="checkbox" 
	       checked data-toggle="toggle" data-size="normal" 
	       id="customerType" name="customerType" 
	       data-onstyle="success" 
	       data-offstyle="info" 
	       data-on="Bireysel" 
	       data-off="Kurumsal" 
	       data-width="200"
	       >
    </body>
</html>


<script type="text/javascript">
//    var i = 1;
//    Function.prototype.functionName = function ()
//    {
//	var name = /\W*function\s*([\w$]+)/.exec(this);
//	return name ? name[1] : 'Anonymous';
//    };
//
//    function helloWorld() {
//	alert('Hello from the ' + arguments.callee.functionName() + '() function!');
//    }

//		function deneme() {
//			alert("123");
//		};
//
//		deneme(1, 2, 3, 4, 5, 6);
//helloWorld(); //displays "Hello from the helloWorld() function!"

//a better way that reuses the existing functionality
//    Array.prototype.join = (function (originalJoin) {
//	return function (separator) {
//	    return originalJoin.call(this, separator === undefined ? '|' : separator);
//	};
//    })(Array.prototype.join);

</script>
