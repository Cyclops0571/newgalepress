<?php
if(!$preview) {
    $baseDirectory = $baseDirectory . "scroll";
} else {
    $baseDirectory = $baseDirectory . "comp_";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Gale Press</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
    <link href="{{ $baseDirectory }}/css/prettify.css" type="text/css" rel="stylesheet" />
    <link href="{{ $baseDirectory }}/ckeditor/fonts/fonts.css" type="text/css" rel="stylesheet" />
    <style type="text/css">
        *{
            -webkit-tap-highlight-color: transparent !important;
            font-family: roboto;
        }
        .overview{
            width: 100%;
            height: 100% !important;
            padding: 0px 15% 0 0;
            word-wrap: break-word;
        }
        .overview > *:first-child{
            margin: 0;
        }
        .slimScrollDiv{
            position: fixed !important;
            width: 100% !important;
            height: 97% !important;
        }
        .slimScrollBar, .slimScrollRail{
            position: fixed !important;
            right: 2% !important;
        }
    </style>
</head>
<body>
<div class="overview">
    {{$content}}
</div>
<script src="{{ $baseDirectory }}/lib/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="{{ $baseDirectory }}/js/jquery.slimscroll.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.overview').slimScroll({
            alwaysVisible: false,
            size: "2px",
            railVisible: true
        });
        var ua = navigator.userAgent.toLowerCase();
        var isAndroid = ua.indexOf("android") > -1;
        var isMobile = ua.indexOf("mobile") > -1;
        if(isAndroid && isMobile) {
            // document.body.style.fontSize = "30%";
            $('*').each(function(){
                var k =  parseInt($(this).css('font-size'));
                var redSize = ((k*90)/100) ; //here, you can give the percentage( now it is reduced to 90%)
                $(this).css('font-size',redSize);
            });
        }
        else if(isAndroid){ //KARICALANMA PROBLEMİ İÇİN...
            setInterval(function(){
                $('body').css('background-image',"url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6M0FGRDNDQ0EwRUIwMTFFNThENTJGODhCQzcyNDE1NjQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6M0FGRDNDQ0IwRUIwMTFFNThENTJGODhCQzcyNDE1NjQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozQUZEM0NDODBFQjAxMUU1OEQ1MkY4OEJDNzI0MTU2NCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDozQUZEM0NDOTBFQjAxMUU1OEQ1MkY4OEJDNzI0MTU2NCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PhYwDdYAAAAPSURBVHjaYvj//z9AgAEABf4C/i3Oie4AAAAASUVORK5CYII=')");
                $('body').css('background-repeat','no-repeat');
            },100);
        }
        var count = 0;
        $( ".overview > *" ).each(function() {
            count += $( this ).height();
        });

        if($('.overview').height() < count){
            setTimeout(function(){
                $( ".slimScrollBar" ).animate({ "top": "+=50px" }, "slow" );
                $( ".overview *:first-child" ).animate({ "margin-top": "-=50px" }, "slow", function(){
                    $( ".overview *:first-child" ).animate({ "margin-top": "0px" }, "slow");
                    $( ".slimScrollBar" ).animate({ "top": "0px" }, "slow", function(){
                        $( ".slimScrollBar" ).fadeOut(250);
                    } );
                } );
            },300);
        }

    });
</script>
</body>
</html>