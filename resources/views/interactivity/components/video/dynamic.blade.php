<?php
$vFile = path('public') . $filename;
if (File::exists($vFile) && is_file($vFile)) {
    $fname = File::name($vFile);
    $fext = File::extension($vFile);
    $vFile = $fname . '.' . $fext;
} else {
    $vFile = '';
}

$vPosterImageFile = path('public') . $posterimagename;
if (File::exists($vPosterImageFile) && is_file($vPosterImageFile)) {
    $fname = File::name($vPosterImageFile);
    $fext = File::extension($vPosterImageFile);
    $vPosterImageFile = $fname . '.' . $fext;
} else {
    $vPosterImageFile = '';
}

if (!$preview) {
    $vFile = $baseDirectory . 'comp_' . $id . '/' . $vFile;
    if (!empty($vPosterImageFile)) {
        $vPosterImageFile = $baseDirectory . 'comp_' . $id . '/' . $vPosterImageFile;
    }
    $baseDirectory = $baseDirectory . "video";
} else {
    $vFile = '/' . $filename;
    if (!empty($vPosterImageFile)) {
        $vPosterImageFile = '/' . $posterimagename;
    }
    $baseDirectory = $baseDirectory . "comp_";
}
?>
        <!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1">
    <script src="{{ $baseDirectory }}/js/jquery.js"></script>
    <title>Gale Press</title>
    <link href="{{ $baseDirectory }}/css/video-js.css" rel="stylesheet" type="text/css">
    <script src="{{ $baseDirectory }}/js/video.js" type="text/javascript"></script>
    <style>
        * {
            overflow: hidden !important;
        }

        body {
            margin: 0 !important;

        }

        .video-js {
            position: fixed !important;
            width: 100% !important;
            height: 100% !important;
        }

        .vjs-control-bar {
            position: fixed !important;
        }

        /*Video JS Css*/
        .vjs-default-skin .vjs-big-play-button {
            left: 50%;
            margin-top: -22px;
            margin-left: -22px;
            top: 50%;
            font-size: 2em;
            width: 2em;
            height: 2em;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
        }

        .vjs-default-skin .vjs-big-play-button:before {
            line-height: 1.5em;
        }

    </style>
</head>
<body>
<?php //var_dump($modal XOR (!$showcontrols)); ?>
<video id="example_video_1" class="video-js vjs-default-skin" preload="auto" width="<?php echo $w;?>" height="<?php echo $h;?>"
       <?php echo $videoinit=='onload' ? 'autoplay ' : ''; ?>
       <?php echo $showcontrols==1 ? 'controls ' : ''; ?>
       <?php echo $restartwhenfinished==1 ? 'loop ' : '';?>
       <?php echo empty($vPosterImageFile) ? '' : 'poster="' . $vPosterImageFile . '"';?>
       <?php echo ($modal XOR !$showcontrols) ? 'onclick="startVideo()"' : '';?>
data-setup="{}" style="position:fixed; height:100% !important;">
<source src="{{ ($option==1 ? $vFile : $url) }}" type='video/mp4'/>
</video>

<script type="text/javascript">
    var myModal = parseInt(<?php echo json_encode($modal); ?>);
    var videoDelay = parseInt(<?php echo json_encode($videodelay) ?>);
    var mute = parseInt(<?php echo json_encode($mute); ?>);
    var o = videojs('example_video_1');

    function startVideo() {
        if (o.paused()) {
            o.play();
        } else {
            o.pause();
        }
    }

    o.ready(function () {
        if (mute) {
            this.volume(0);
        }
    });


    $(function () {
        var videoElement = $('#example_video_1');
        var allElements = $("*");
        var htmlElements = $('html');
        if (myModal == 1) {
            allElements.css('opacity', '0');
            htmlElements.css({
                'background': 'black',
                'opacity': '1'
            });
        }

        if (videoDelay != 0) {
            var playVideo = function () {
                $("video")[0].play();
            };
            setTimeout(playVideo, videoDelay);
        }

        videoElement.css({
            'width': '100%',
            'height': '100%'
        });
        setTimeout(function () {
            videoElement.css({
                'width': '100%',
                'height': '100%'
            });
            allElements.delay(200).animate({opacity: 1}, 300);
        }, 150);
    });
</script>
</body>
</html>