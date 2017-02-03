<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>

    <title>GALERPESS BANNER SLIDER</title>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/js/Swiper-master/dist/css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans"/>

    <script src="/js/jquery-2.1.4.min.js"></script>
    <script src="/js/Swiper-master/dist/js/swiper.min.js"></script>

    <style>
        html {
            position: relative;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
            overflow-y: hidden;
        }

        body {
            position: relative;
            width: 100%;
            height: 100%;
            background: #eee;
            font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .swiper-container {
            max-width: 100% !important;
            max-height: 100% !important;
        }

        .swiper-wrapper {
            max-width: 100% !important;
            max-height: 100% !important;
        }

        .swiper-slide {
            width: auto;
            text-align: center;
            font-size: 18px;
            background: transparent;
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
            bottom: 3px;
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
<body>
<div class="swiper-container">
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
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
</div>

<script>
    var lastPageX = 0;
    var lastPageX2 = 0;
    var myslideNext = false;
    var myslidePrev = false;
    var myBulletClass = undefined;
    var sliderAnimation = '<?php echo $application->BannerSlideAnimation; ?>';
    $('.image-container').css('height', $('body').height());
    $('.swiper-slide').css('width', Math.ceil($('body').height() * 2.3125));

    if (sliderAnimation == 'cube') {
        myBulletClass = 'hidden';
    }

    var swiper = new Swiper('.swiper-container', {
        autoHeight: true,
        bulletClass: myBulletClass,
        bulletActiveClass: 'myswiper-pagination-bullet-active',
        speed: <?php echo $TransitionRate; ?>,
        autoplay: <?php echo $IntervalTime; ?>,
        pagination: '.swiper-pagination',
        slidesPerView: 'auto',
        loop: true,
        loopedSlides: 0,
        centeredSlides: true,
        spaceBetween: 10,
        effect: sliderAnimation,
        longSwipes: false,
        resistance: false,
        touchMoveStopPropagation: false,
        runCallbacksOnInit: false,
        noSwiping: false,
        onSlideChangeEnd: function (swiper) {
            myslideNext = false;
            swiper.startAutoplay();
        },
        onSlidePrevStart: function (swiper) {
            myslidePrev = false;
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
                    swiper.stopAutoplay();
                    setTimeout(slideNext, 100);
                    myslideNext = true;
                } else if (lastPageX2 < lastPageX && lastPageX < event.touches[0].pageX) {
                    swiper.stopAutoplay();
                    setTimeout(slidePrev, 100);
                    myslidePrev = true;
                }
            }
            lastPageX2 = lastPageX;
            lastPageX = event.touches[0].pageX;
        }
    });

    function slideNext() {
        if (myslideNext) {
            swiper.slideNext();
        }
    }

    function slidePrev() {
        if (myslidePrev) {
            swiper.slidePrev();
        }
    }
</script>
</body>
</html>