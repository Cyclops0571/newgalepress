<?php
if(!isset($transparent)) $transparent = 0;
if(!isset($bgcolor)) $bgcolor = '#151515';
if(!isset($iconcolor)) $iconcolor = '#da0606';
if(!isset($boxopacity)) $boxopacity = 1;
if($transparent == 1)
{
    $bgcolor = "transparent";
    $boxopacity = 0;
}
$vFile = path('public').$filename;
if(File::exists($vFile) && is_file($vFile)) {
    $fname = File::name($vFile);
    $fext = File::extension($vFile);
    $vFile = $fname.'.'.$fext;
} else {
    $vFile = '';
}

if(!$preview) {
    $vFile = $baseDirectory.'comp_'.$id.'/'.$vFile;
    $baseDirectory = $baseDirectory . "tooltip";
} else {
    $vFile = '/'.$filename;
    $baseDirectory = $baseDirectory . "comp_";
}

$vFile2 = path('public').$filename2;
if(File::exists($vFile2) && is_file($vFile2)) {
    $fname2 = File::name($vFile2);
    $fext2 = File::extension($vFile2);
    $vFile2 = $fname2.'.'.$fext2;
}
else {
    $vFile2 = '';
}
if(!$preview)
{
    $vFile2 = $baseDirectory.'comp_'.$id.'/'.$vFile2;
}
else
{
    $vFile2 = '/'.$filename2;
}
//hex to rgb
$hex = str_replace("#", "", $bgcolor);

if(strlen($hex) == 3) {
    $r = hexdec(substr($hex,0,1).substr($hex,0,1));
    $g = hexdec(substr($hex,1,1).substr($hex,1,1));
    $b = hexdec(substr($hex,2,1).substr($hex,2,1));
} else {
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));
}
$rgb = array($r, $g, $b);
?>
        <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1"/>
    <link href="{{ $baseDirectory }}/css/prettify.css" type="text/css" rel="stylesheet" />
    <link href="{{ $baseDirectory }}/ckeditor/fonts/fonts.css" type="text/css" rel="stylesheet" />
    <style type="text/css">
        body{
            overflow: hidden;
        }
        *{
            -webkit-tap-highlight-color: transparent !important;
            font-family: roboto;
        }
        .hs-spot-object{
            position: fixed;
            cursor: pointer;
            z-index:1;
            @if($option == 1)
            width: auto;
            height:auto;
            border-radius:50%;
            -moz-border-radius:50%;
            -webkit-border-radius:50%;
            -khtml-border-radius: 50%;
            color: #058ae5;
            border: 2px solid #d2d2d2;
            background: {{ $iconcolor }};
            padding: 6%;
            background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAANtJREFUeNrs2LENwjAQhWHbgt59Go/ABuANmCYt1HTZADZgA9gARqChT5+GO8USJBLlRUr0P+kUuYn1OXKK551h1qd3lMdNZiPTyuSurp5W+wVnm32BaBR2sNzMGpNG6zhnzKQBAwYMGDBgwIABAwYMGDBgwPyNL3WQtijJ4P1bmd3P+iVzMdhHa6yrYh7uWwfNOW1YCEQTQ/lEi8hKJru+abQo6NLoLurBWdWzjbc8KbmPRzesZO9dXWV+zWDAgAEDBgwYMGDAgAEDBgwYMBNhzm7YyzWWm30EGADiORxNIOidwAAAAABJRU5ErkJggg==');
            background-size: 75% 75%;
            background-repeat: no-repeat;
            background-position: center center;
        @endif
        {{($init == 'right' || $init == 'bottom' ? 'top:1px; left:1px;' : ($init == 'left' ? 'top:1px; right:1px;' : ($init == 'top' ? 'bottom:1px; left:1px;' : '')))}};
        }
        .hs-spot-object .hs-spot-object-inner{
            background: {{ $iconcolor }} !important;
        }
        @if($option == 2)
    .hs-spot-object{
            background-image: url("{{$vFile}}");
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }
        @endif
    #myScrollableDiv{
            position: fixed;
            word-wrap: break-word;
            overflow-y: scroll;
            overflow-x: hidden;
            z-index:0;
            background: rgba({{$rgb[0]}},{{$rgb[1]}},{{$rgb[2]}},{{ $boxopacity }});
            /*text-align:center;*/
        }
        #myScrollableDiv > .myContent:first-child{
            padding: 5% 14% 9% 7%;
        }
        .closed{
            display: none;
        }
        /*SCROLLBAR ADDITIONAL STYLES*/
        .slimScrollDiv{
            position: fixed !important;
            display: none;
        }
        .slimScrollBar{
            background: #058ae5 !important;
            -webkit-box-shadow: 1px 1px 3px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 1px 1px 3px 0px rgba(0,0,0,0.75);
            box-shadow: 1px 1px 3px 0px rgba(0,0,0,0.75);
            right: 0.5% !important;
            /*width: 5% !important;*/
            opacity: 0.75 !important;
            margin: 0 2%;
        }
        .slimScrollRail{
            right: 1% !important;
            /*width: 3% !important;*/
            margin: 2% 1.3%;
            height: 97% !important;
        }
    </style>
</head>
<body>
<div class="hs-spot-object" style="display:none;"></div>
<div id="myScrollableDiv" class="closed">
    <div class="myContent">
        {{$content}}
    </div>
</div>
<script src="{{ $baseDirectory }}/lib/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="{{ $baseDirectory }}/js/prettify.js"></script>
<script type="text/javascript" src="{{ $baseDirectory }}/js/jquery.slimscroll.min.js"></script>
<script>
    $(document).ready(function() {
        var ua = navigator.userAgent.toLowerCase();
        var isAndroid = ua.indexOf("android") > -1;
        if(isAndroid) {
            setInterval(function(){
                $('body').css('background-image',"url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6M0FGRDNDQ0EwRUIwMTFFNThENTJGODhCQzcyNDE1NjQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6M0FGRDNDQ0IwRUIwMTFFNThENTJGODhCQzcyNDE1NjQiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDozQUZEM0NDODBFQjAxMUU1OEQ1MkY4OEJDNzI0MTU2NCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDozQUZEM0NDOTBFQjAxMUU1OEQ1MkY4OEJDNzI0MTU2NCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PhYwDdYAAAAPSURBVHjaYvj//z9AgAEABf4C/i3Oie4AAAAASUVORK5CYII=')");
                $('body').css('background-repeat','no-repeat');
            },100);
        }

        $('#myScrollableDiv').slimScroll({
            alwaysVisible: true,
            size: "4px",
            railVisible: true
        });

        var bodyHeight=$(document).height();
        var bodyWidth=$(document).width();

        var bodyWidthFromTasarlayici={{$w}};
        var bodyHeightFromTasarlayici={{$h}};

        var calcIconWidth=(35/bodyWidthFromTasarlayici)*100;
        $('.hs-spot-object').css('padding',(calcIconWidth/2)+'%');
        $('.hs-spot-object').fadeIn(1000);

        @if($option==1)
        $('.hs-spot-object').click(function(){
            if($('#myScrollableDiv').hasClass('closed'))
            {
                setTimeout(function(){
                    $('#myScrollableDiv').slimScroll().attachWheel;
                    // $('.slimScrollBar').scrollTop(10);
                },500);
                $('#myScrollableDiv,.slimScrollDiv').removeClass('closed').css('display','block');
                $(this).css('background-image',"url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAadJREFUeNrU2sttwkAQBuD9LeWee5pIB4gKUkKggoQLReQCHUAnKQGniNy555JZwJJl2d7XzOx4pJHBzIr5JFhpVoajePr6PdDl092jpVz/7V+uzngM+wbd8G8OgzrzIOr7RJdN/15DuRqpfaX8pgXPS4F0mJ+JNSZBU5AOc6S8LgE0B7lhHv+LtXVQCEKxRa/41jTlVNPVNoUYCPV1xmCROVAsxL/AyGIzoBTIKMYKKBUyiakNyoHMYmqBciFBjDaoBBKF0QKVQqIx0iAOSBJGCsQFScZwgzghWRguEDckG1MKkoAUYXJBUpBiTCpIEsKCSQC1khA2TCTISUJYMQUgFgg7JgPEBhHB9ECXQNmOIEfO722EZquPiJp37kMSiZ9ZaPsVm4dQEcIOahQh4udyjRJk6xQOGqEB6bZf6YkVWhCNiRWaEGkQtCGSINSASIFQCyIBQk0INwi1IZwgWIBwgWAFwgGCJUgpCNYgJSBYhOSCYBWSA4JlSCoI1iEpIP9Uk0ecLENiQX7SfFsCxAf10s5NrHNPNZmCxIA85jzygUlICPQvwAAYXM4RLb8QqQAAAABJRU5ErkJggg==')");
                $(this).css('background-size','60% 60%');
            }
            else
            {
                $('#myScrollableDiv,.slimScrollDiv').addClass('closed').css('display','none');;
                $(this).css('background-image',"url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADMAAAAzCAYAAAA6oTAqAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAANtJREFUeNrs2LENwjAQhWHbgt59Go/ABuANmCYt1HTZADZgA9gARqChT5+GO8USJBLlRUr0P+kUuYn1OXKK551h1qd3lMdNZiPTyuSurp5W+wVnm32BaBR2sNzMGpNG6zhnzKQBAwYMGDBgwIABAwYMGDBgwPyNL3WQtijJ4P1bmd3P+iVzMdhHa6yrYh7uWwfNOW1YCEQTQ/lEi8hKJru+abQo6NLoLurBWdWzjbc8KbmPRzesZO9dXWV+zWDAgAEDBgwYMGDAgAEDBgwYMBNhzm7YyzWWm30EGADiORxNIOidwAAAAABJRU5ErkJggg==')");
                $(this).css('background-size','75% 75%');
            }
            render();
        });
        @endif

        @if($option==2)
        $('.hs-spot-object').click(function(){
            if($('#myScrollableDiv').hasClass('closed'))
            {
                $(this).css('background-image','url("' + <?php echo json_encode($vFile2) ?> + '")');
                $('#myScrollableDiv,.slimScrollDiv').removeClass('closed').css('display','block');
            }
            else
            {
                $(this).css('background-image','url("' + <?php echo json_encode($vFile) ?> + '")');
                $('#myScrollableDiv,.slimScrollDiv').addClass('closed').css('display','none');;
            }
        });

        var calcHeight;
        var calcWidth;
        var image = new Image();
        image.src = "{{$vFile}}";
        image.onload = function() {
            var imgWidth={{$iconwidth}};
            calcWidth=(imgWidth/bodyWidthFromTasarlayici)*100;
            var imgHeight={{$iconheight}};
            calcHeight=(imgHeight/bodyHeightFromTasarlayici)*100;
            $('.hs-spot-object').css('width',calcWidth+'%').css('height',calcHeight+'%');
            render();
        };
        @endif

        function render(){
            var spotWidth = $('.hs-spot-object').outerWidth();
            var spotHeight = $('.hs-spot-object').outerHeight();

            ('{{$init}}' == 'right' || '{{$init}}' == 'bottom' ? $('#myScrollableDiv').css('left',spotWidth/2).css('top',spotHeight/2)
                    : ('{{$init}}' == 'left' ? $('#myScrollableDiv').css('right',spotWidth/2).css('top',spotHeight/2)
                    : ('{{$init}}' == 'top' ? $('#myScrollableDiv').css('left',spotWidth/2).css('bottom',spotHeight/2) : '')));

            spotWidthPerc=(spotWidth/bodyWidthFromTasarlayici)*100;
            spotHeightPerc=(spotHeight/bodyWidthFromTasarlayici)*100;

            @if($option==1)
              $('#myScrollableDiv').css('width',100-(spotWidthPerc/2)+'%');
            $('#myScrollableDiv').css('height',100-(spotHeightPerc/2)+'%');
            @endif
            @if($option==2)
              $('#myScrollableDiv').css('width',(100-calcWidth)-10+'%');
            $('#myScrollableDiv').css('height',(100-calcHeight)-10+'%');
            @endif
            $('.slimScrollDiv').attr('style',$('#myScrollableDiv').attr('style'));
        }
    });
</script>
</body>
</html>