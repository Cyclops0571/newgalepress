<?php
if (!isset($files)) $files = array();
if (!isset($autoplay)) $autoplay = false;
if (!isset($modal)) $modal = 0;
if (!isset($transparent)) $transparent = 0;
if (!isset($bgcolor)) $bgcolor = '#151515';

if(!$preview) {
    $sourceFilesDirectory = $baseDirectory . "slideshow";
} else {
    $sourceFilesDirectory = $baseDirectory . "comp_";
}

?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Gale Press</title>
    <meta content="Touch-enabled image gallery and content slider plugin, that focuses on providing great user experience on every desktop and mobile device."
          name="description">
    <meta name="keywords" content="content slider, gallery, plugin, jquery, banner rotator">
    <meta name="author" content="Dmitry Semenov">
    <meta name="viewport" content="user-scalable=no">
    <!-- slider JS files -->
    <script class="rs-file" src="{{ $sourceFilesDirectory }}/assets/royalslider/jquery-1.8.3.min.js"></script>
    <script class="rs-file"
            src="{{ $sourceFilesDirectory }}/assets/royalslider/jquery.royalslider.min.js"></script>
    <link class="rs-file" href="{{ $sourceFilesDirectory }}/assets/royalslider/royalslider.css" rel="stylesheet">
    <!-- syntax highlighter -->
    <script src="{{ $sourceFilesDirectory }}/assets/preview-assets/js/highlight.pack.js"></script>
    <script src="{{ $sourceFilesDirectory }}/assets/preview-assets/js/jquery-ui-1.8.22.custom.min.js"></script>
    <script> hljs.initHighlightingOnLoad();</script>
    <!-- preview-related stylesheets -->
    <link href="{{ $sourceFilesDirectory }}/assets/preview-assets/css/reset.css" rel="stylesheet">
    <link href="{{ $sourceFilesDirectory }}/assets/preview-assets/css/smoothness/jquery-ui-1.8.22.custom.css"
          rel="stylesheet">
    <link href="{{ $sourceFilesDirectory }}/assets/preview-assets/css/github.css" rel="stylesheet">
    <!-- slider stylesheets -->
    <link class="rs-file"
          href="{{ $sourceFilesDirectory }}/assets/royalslider/skins/default-inverted/rs-default-inverted.css"
          rel="stylesheet">
    <!-- slider css -->
    <style>
        html {
            overflow: hidden;
            width: 100%;
            height: 100%;
        }

        body {
            overflow: hidden;
            width: 100%;
            height: 100%;
            @if((int)$transparent == 1)
                       background: transparent !important;
            @else
                       background: {{ $bgcolor }}            !important;
        @endif
        }

        <?php if($modal):?>
        #slider-in-laptop {
            margin: 0 auto;
            padding: 0;
            text-align: center;
            background: none;
        }

        <?php else: ?>
        #slider-in-laptop {
            width: 100% !important;
            height: 100% !important;
            padding: 0 0 0;
            background: none;
        }

        <?php endif; ?>

        #slider-in-laptop .rsOverflow,
        #slider-in-laptop .rsSlide,
        #slider-in-laptop .rsVideoFrameHolder,
        #slider-in-laptop .rsThumbs {
            /*background: #151515;*/
            background: transparent !important;
        }

        .imgBg {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: auto;
        }

        .laptopBg {
            position: relative;
            width: 100%;
            height: auto;
        }

        #slider-in-laptop .rsBullets {
            bottom: 30px;
        }

        #page-navigation {
            display: none;
        }

        @if($modal)
        .royalSlider {
            width: 100%;
            height: 100%;
        }

        .rsOverflow .grab-cursor {
            width: 100%;
            height: 100%;
        }

        @else
        #slider-in-laptop .rsSlide img {
            width: 100% !important;
            height: 100% !important;
        }

        @endif

        .rsDefaultInv .rsBullet {
            width: 15px;
            height: 15px;
            display: inline-block;
            padding: 6px;
        }

        .rsDefaultInv .rsBullet span {
            display: block;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: none !important;
            border: 1px solid #BBB !important;
        }

        .rsDefaultInv .rsBullet.rsNavSelected span {
            background: black !important;
            border: none !important;
        }

        .noTouch {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            pointer-events: none;
        }

    </style>
</head>
<body>
<!-- slider code start -->
<div id="slider-in-laptop" class="royalSlider rsDefaultInv">
    <?php
    //var_dump($files);
    foreach ($files as $file) {
        $filename = public_path($file);
        if (File::exists($filename) && is_file($filename)) {
            $fname = File::name($filename);
            $fext = File::extension($filename);
            $filename = $fname . '.' . $fext;

            if (!$preview) {
                $vFile = $baseDirectory . 'comp_' . $id . '/' . $filename;
            } else {
                $vFile = '/' . $file;
            }
            echo '<img src="' . $vFile . '"/>';

        }
    }
    ?>
</div>
<?php if ($modal): ?>
<script>
    $(function ($) {
        window.addEventListener("orientationchange", function () {
            for (var i = 0; i < 30; i++) {
                setTimeout(function () {
                    arrangeImageTopMargin();
                }, 100 * i);
            }
        });

        $.extend($.rsProto, {
            _initGlobalCaption: function () {
                var self = this;
                var i = 0;
                self.ev.on('rsAfterContentSet', function () {
                    arrangeImageTopMargin();
                });
                self.ev.on('rsBeforeMove', function () {
                    setTimeout(function () {
                        arrangeImageTopMargin();
                    }, 100);
                });
            }
        });
        $.rsModules.globalCaption = $.rsProto._initGlobalCaption;
    });

    function arrangeImageTopMargin() {
        $.each($('img'), function (i, obj) {
            var imgHeight = $(obj).height();
            if (imgHeight < $(document).height()) {
                var verticalCalc = ($(document).height() - imgHeight) / 2;
                //$('img').animate({marginTop:verticalCalc});
                $(obj).css('marginTop', verticalCalc);
            } else {
                $(obj).css('marginTop', 0);
            }
        });
    }
</script>
<?php endif; ?>
<script id="addJS">
    var autoplay = <?php echo json_encode((boolean)$autoplay); ?>;


    $(function ($) {
        var rsi = $('#slider-in-laptop').royalSlider({
            autoHeight: false,
            arrowsNav: false,
            fadeinLoadedSlide: false,
            controlNavigationSpacing: 0,
            imageScaleMode: 'fit-if-smaller',
            imageAlignCenter: false,
            loop: true,
            loopRewind: false,
            numImagesToPreload: 6,
            keyboardNavEnabled: true,
            autoScaleSlider: false,
            autoScaleHeight: false,
            autoPlay: {
                // autoplay options go gere
                enabled: autoplay,
                pauseOnHover: true
            }
        }).data('royalSlider');

        $('#slider-next').click(function () {
            rsi.next();
        });

        $('#slider-prev').click(function () {
            rsi.prev();
        });

        $(document).bind(
                'touchmove',
                function (e) {
                    e.preventDefault();
                }
        );
        var length = $('.rsSlide').children().length;
        if (length == 1) {
            $('.rsDefaultInv .rsBullet').css('display', 'none');
            $('.royalSlider').addClass('noTouch');
        }
    });
</script>
</body>
</html>