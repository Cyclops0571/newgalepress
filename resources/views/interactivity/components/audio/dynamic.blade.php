<?php
$vFile = public_path($filename);
if(File::exists($vFile) && is_file($vFile)) {
    $fname = File::name($vFile);
    $fext = File::extension($vFile);
    $vFile = $fname.'.'.$fext;
}
else {
    $vFile = '';
}

if(!$preview)
{
    $vFile = $baseDirectory.'comp_'.$id.'/'.$vFile;
    $baseDirectory = $baseDirectory . "audio";
}
else
{
    $vFile = '/'.$filename;
    $baseDirectory = $baseDirectory . "comp_";
}
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Gale Press</title>
    <meta name="viewport" content="user-scalable=no">
    <link rel="stylesheet" type="text/css" href="{{ $baseDirectory }}/css/index.css" />
    <script type="text/javascript" src="{{ $baseDirectory }}/CrbUI/audio/button/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{ $baseDirectory }}/CrbUI/audio/button/js/modernizr.js"></script>
    <script type="text/javascript" src="{{ $baseDirectory }}/CrbUI/audio/button/js/swfobject.js"></script>
    <script type="text/javascript" src="{{ $baseDirectory }}/CrbUI/audio/button/js/CrbUI_AudioButton-0.74.adv.js"></script>
    <script type="text/javascript">
        CrbUI_A_CONF['COLOR'] = '#0091ec';
        CrbUI_A_CONF['PATH'] = '{{ $baseDirectory }}/';
    </script>
    <style type="text/css">
        *{
            -webkit-tap-highlight-color: transparent !important;
        }
    </style>
</head>
<body>
<div id="{{ ((int)$option == 1 ? $vFile : $url) }}" class="CrbUI_AudioButton"></div>
<script type="text/javascript">
    $(document).ready(function() {
        @if($videoinit == "onload")
            $(document).ready(function() {
            setTimeout(function(){
                $('.CrbUI_AudioButton img').click();
                $('audio').attr('autoplay',"true");
            },500);
        });
        @endif
        $('.CrbUI_AudioButton').css('width','100%');
        $('.CrbUI_AudioButton').css('height','100%');
        $('.CrbUI_AudioButton canvas').css('width','66%');
        $('.CrbUI_AudioButton canvas').css('height','66%');
        $('.CrbUI_AudioButton canvas').css('left','17%');
        $('.CrbUI_AudioButton canvas').css('top','17%');
        $('.CrbUI_AudioButton img').css('width','100%');
        $('.CrbUI_AudioButton img').css('height','100%');
    });
</script>
</body>
</html>