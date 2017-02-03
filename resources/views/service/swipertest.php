<!DOCTYPE html>
<html>
<head style="background: red">
    <meta charset="utf-8"/>

    <title>GALERPESS BANNER SLIDER</title>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/js/Swiper-master/dist/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans"/>

    <script src="/js/jquery-2.1.4.min.js"></script>
    <script src="/js/Swiper-master/dist/js/swiper.min.js"></script>

    <style>
        html, body {
            position: relative;
            height: 100%;
        }

        body {
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .swiper-container {
            width: 100%;
            height: 100%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            /* Center slide text vertically */
            display: -webkit-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            -webkit-justify-content: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .myImage {
            max-width: 100%;
            max-height: 100%;
        }

        .image-container {
            position: relative;
        }

        .myBorder {
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            position: absolute;
            bottom: 15%;
            width: 100%;

            font-size: large;
            text-align: left;
            color: #333333;
            background-color: rgba(250, 250, 250, 0.6);
            box-shadow: 0 0 3px 3px rgba(250, 250, 250, 0.6);
        }

        .myText {
            margin-left: 5%;
            font-family: 'Open Sans';
        }

        .swiper-pagination-fraction, .swiper-pagination-custom, .swiper-container-horizontal > .swiper-pagination-bullets {
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .myswiper-pagination-bullet-active {
            opacity: 1;
            background: <?php echo $application->getBannerColor(); ?>;
        }
    </style>
</head>

<?php
/** @var Application $application */
$IntervalTime = (int)$application->BannerAutoplay * $application->BannerIntervalTime;
$TransitionRate = $application->BannerTransitionRate;
?>
<body style="background: blue">
<div class="swiper-container" style="background: yellow">
    <div class="swiper-wrapper">
        <?php foreach ($bannerSet as $savedBanner): ?>
            <div class="swiper-slide">
                <div class="image-container">
                    <?php if (!empty($savedBanner->TargetUrl)) : ?>
                    <a href="<?php echo $savedBanner->TargetUrl; ?>">
                        <?php endif; ?>
                        <img class="myImage" src="<?php echo $savedBanner->getImagePath() ?>"/>
                        <?php if (!empty($savedBanner->Description)) : ?>
                            <div class="myBorder">
					<span class="myText">
						<?php echo $savedBanner->Description; ?>
					</span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($savedBanner->TargetUrl)) : ?>
                    </a>
                <?php endif; ?>
                </div>
            </div>

        <?php endforeach; ?>
        <!-- Add Pagination -->
    </div>
    <div class="swiper-pagination"></div>
</div>

<script>
    var lastPageX = 0;
    var lastPageX2 = 0;
    var myslideNext = false;

    var swiper = new Swiper('.swiper-container', {
        bulletActiveClass: 'myswiper-pagination-bullet-active',
        speed: <?php echo $TransitionRate; ?>,
        autoplay: <?php echo $IntervalTime; ?>,
        pagination: '.swiper-pagination',
        slidesPerView: '1',
        allowSwipeToPrev: 'false',
        centeredSlides: true,
        freeModeMomentum: true,
        effect: '<?php echo $application->BannerSlideAnimation; ?>',
        loop: true,
        longSwipes: false,
        resistance: false,
        touchMoveStopPropagation: false,
        iOSEdgeSwipeDetection: true,
        iOSEdgeSwipeThreshold: 1,
        runCallbacksOnInit: false,
        noSwiping: false,
        onSlideChangeEnd: function (swiper) {
            myslideNext = false;
            swiper.slideTo(swiper.activeIndex, <?php echo $TransitionRate; ?>, false);
            swiper.startAutoplay();
        },
        onSlidePrevStart: function (swiper) {
            myslideNext = false;
        },
        onSlideNextStart: function (swiper) {
            myslideNext = false;
        },
        onTouchMove: function (swiper, event) {
            if (!event.touches) {
                return;
            } else if (!event.touches[0]) {
                return;
            }

            if (lastPageX2 != 0 && lastPageX != 0) {
                if (lastPageX2 > lastPageX && lastPageX > event.touches[0].pageX) {
                    setTimeout(slideNext, 100);
                } else if (lastPageX2 < lastPageX && lastPageX < event.touches[0].pageX) {
                    setTimeout(slidePrev, 100);
                }
            }
            lastPageX2 = lastPageX;
            lastPageX = event.touches[0].pageX;
            myslideNext = true;
        },
    });

    function slideNext() {
        if (myslideNext) {
            swiper.slideNext();
        }
    }
    function slidePrev() {
        if (myslideNext) {
            swiper.slidePrev();
        }
    }
</script>
</body>
</html>