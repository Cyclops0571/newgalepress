@extends('website.html')

@section('body-content')
  <section id="home" class="demo-1">
    <!-- Start slider-wrapper-->
    <div id="slider" style="display:none;" class="sl-slider-wrapper">
      {{--<div class="fluid-width-video-wrapper" style="z-index:98;">--}}
      {{--<video id="home-video" autoplay="autoplay" loop="loop" muted="muted" style="width:100% !important;"--}}
      {{--poster="/images/website/video/poster.jpg">--}}
      {{--<source src="/website/video/galepressVideo.mp4" type="video/mp4">--}}
      {{--</video>--}}
      {{--</div>--}}
      <div class="sl-slider" style="z-index:99;">
        <!-- start slide-->
        {{--<div data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25"--}}
        {{--data-slice1-scale="2" data-slice2-scale="2" class="sl-slide">--}}
        {{--<div style="background-image: url(/images/website/intro-home9.jpg);" class="sl-slide-inner"></div>--}}
        {{--</div>--}}
        <div data-orientation="horizontal" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5"
             data-slice2-scale="1.5" class="sl-slide" style="z-index:99;">

          <div class="sl-slide-inner">

            <div class="slide-container">
              <div class="slide-content text-center" id="videoSlide" style="display:none;">
                <h2 class="main-title" style="margin-bottom:40px;">{{__('website.home_video_title')}}</h2>
                <blockquote class="sep-top-xs">
                  <a href="{{route('website_tryit')}}"
                     class="btn btn-light btn-bordered btn-lg">{{__('website.menu_tryit_small')}}</a>
                  <a href="{{route('website_why_galepress')}}"
                     class="btn btn-primary btn-lg">{{__('website.menu_explore')}}</a>
                </blockquote>
              </div>
            </div>
          </div>
        </div>
        <!-- end slide-->
      </div>
    </div>
    <!-- End slider-wrapper-->
  </section>
  <!-- Start Parallax section-->
  <section class="sep-top-2x sep-bottom-2x">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-title text-center wow bounceInDown">
            <h3 class="small-space"
                style="font-size:3.7em; color:#777; font-weight:lighter;">{{__('website.home_intro_title')}}</h3>

            <p class="lead lighter"
               style="font-size:1.7em; color:black; font-weight:lighter;">{{__('website.home_intro_text')}}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="parallax4" style="background-image: url(/images/website/sectors/background.jpg);" class="parallax">
    <div id="charts-wrapper" class="section-shade sep-top-3x sep-bottom-3x">
      <div class="container">
        <div data-wow-delay="1s" class="section-title sep-bottom-md text-center wow bounceInDown">
          <h1 class="light" style="letter-spacing:5px; font-weight:200;">{{__('website.home_sectors_title')}}</h1>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="row text-center">
              <div data-wow-delay="0.5s" class="sectors col-md-4 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                <a href="{{route('website_sectors_digitalpublishing')}}">
                  <img src="/images/website/sectors/new/dijital.png" data-wow-delay="0.7s" class="wow fadeInUp">
                </a>
                <a href="{{route('website_sectors_digitalpublishing')}}">
                  <p data-wow-delay="0.7s" class="lead x2 wow fadeInLeft"
                     style="max-height:30px;">{{__('website.home_sectors_digitalpublishing')}}</p>
                </a>
              </div>
              <div data-wow-delay="0.5s" class="sectors col-md-4 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                <a href="{{route('website_sectors_education')}}">
                  <img src="/images/website/sectors/new/egitim.png" data-wow-delay="1.1s" class="wow fadeInUp">
                </a>
                <a href="{{route('website_sectors_education')}}">
                  <p data-wow-delay="1.1s" class="lead x2 wow fadeInLeft">{{__('website.home_sectors_education')}}</p>
                </a>
              </div>
              <div data-wow-delay="0.5s" class="sectors col-md-4 col-xs-6 col-sm-4 text-center light wow fadeInUp">
                <a href="{{route('website_sectors_retail')}}">
                  <img src="/images/website/sectors/new/perakende.png" data-wow-delay="1.7s" class="wow fadeInUp">
                </a>
                <a href="{{route('website_sectors_retail')}}">
                  <p data-wow-delay="1.7s" class="lead x2 wow fadeInLeft">{{__('website.home_sectors_retail')}}</p>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Parallax section-->
  <!-- Start About section-->
  <!-- Start Clients section-->
  <section class="sep-top-md sep-bottom-2x">
    <div class="container">
      <div data-auto-play="false" data-items="4" data-auto-height="false" class="home-showcase owl-carousel owl-theme">
          <?php
          $sliderItems = array();
          $sliderItems['karsan'] = array(
              'name'     => 'KARSAN',
              'subtitle' => (string)__('website.home_stars_karsan_subtitle'),
              'em'       => (string)__('website.home_stars_karsan')
          );
          $sliderItems['mothlyfitness'] = array(
              'name'     => 'MONTLY FITNESS',
              'subtitle' => (string)__('website.home_stars_montly_fitness_subtitle'),
              'em'       => (string)__('website.home_stars_montly_fitness')
          );
          $sliderItems['dagitimkanali'] = array(
              'name'     => 'DAĞITIM KANALI',
              'subtitle' => (string)__('website.home_stars_dagitim_kanali_subtitle'),
              'em'       => (string)__('website.home_stars_dagitim_kanali')
          );
          $sliderItems['bthaber'] = array(
              'name'     => 'BT HABER',
              'subtitle' => (string)__('website.home_stars_bt_haber_subtitle'),
              'em'       => (string)__('website.home_stars_bt_haber')
          );
          $sliderItems['carrefoursa'] = array(
              'name'     => 'CarrefourSA',
              'subtitle' => (string)__('website.home_stars_carrefour_subtitle'),
              'em'       => (string)__('website.home_stars_carrefour')
          );
          $sliderItems['prestijyayincilik'] = array(
              'name'     => 'PRESTIJ YAYINCILIK',
              'subtitle' => (string)__('website.home_stars_prestij_yayincilik_subtitle'),
              'em'       => (string)__('website.home_stars_prestij_yayincilik')
          );
          $sliderItems['erphaber'] = array(
              'name'     => 'ERP HABER',
              'subtitle' => (string)__('website.home_stars_erp_haber_subtitle'),
              'em'       => (string)__('website.home_stars_erp_haber')
          );
          $sliderItems['betonsa'] = array(
              'name'     => 'BetonSA',
              'subtitle' => (string)__('website.home_stars_betonsa_subtitle'),
              'em'       => (string)__('website.home_stars_betonsa')
          );

          ?>

          <?php foreach($sliderItems as $comp => $si): ?>
        <div class="item">
          <div class="col-md-12">
            <div class="sep-top-xs sep-bottom-sm item-ipad">
              <div class="team-photo">
                <div class="device-mockup section-showcase" data-device="ipad" data-orientation="portrait"
                     data-color="white">
                  <div class="device">
                    <div class="screen">
                      <img src="/images/website/clients/<?php echo $comp; ?>.jpg" alt="" class="img-responsive">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="team-name">
              <h5 class="upper"><?php echo $si['name'];?></h5>
              <span><?php echo $si['subtitle']; ?></span>
            </div>
            <em><?php echo $si['em']; ?></em>
          </div>
        </div>
          <?php endforeach; ?>
      </div>
    </div>
  </section>
  <!-- End Clients section-->
  <section id="about" class="sep-top-md sep-bottom-md bg-primary">
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-right">
          <div class="sep-top-md sep-bottom-md">
            <div class="bordered-right section-title">
              <h2 class="upper"><span class="light"
                                      style="color:white;">{{__('website.home_interactive_editor_word1')}}</span> {{__('website.home_interactive_editor_word2')}}
              </h2>
            </div>
            <p class="lead">{{__('website.home_interactive_editor_description')}}</p>

            <div class="sep-top-xs">
              <a href="{{route('website_tryit')}}" data-wow-delay=".5s"
                 class="btn btn-light btn-bordered btn-lg wow bounceInLeft animated"
                 style="visibility: visible; -webkit-animation-delay: 0.5s;">{{__('website.menu_tryit')}}</a>
            </div>
          </div>
        </div>
        <div class="col-md-8 col-xs-12 intAnimeFrame">
          <div class="col-md-1 col-lg-offset-1 col-xs-1 compLeftCol" style="margin-right:-50px; z-index:99;">
            <img src="/images/website/icons/light/new/video.png" class="compenents">
            <img src="/images/website/icons/light/new/ses.png" class="compenents">
            <img src="/images/website/icons/light/new/harita.png" class="compenents">
            <img src="/images/website/icons/light/new/link.png" class="compenents">
            <img src="/images/website/icons/light/new/web.png" class="compenents">
          </div>
          <div class="col-md-10 col-xs-10 compMiddleCol">
            <div data-device="macbook" data-orientation="landscape" data-color="black" class="device-mockup">
              <div class="device">
                <div class="screen">
                  <iframe scrolling="no" src="/website/animating/web/animasyon2.html"
                          style="width:100% !important; height:100% !important;max-width:100% !important; max-height:100% !important;"></iframe>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-1 col-xs-1 compRightCol" style="margin-left:-50px;">
            <img src="/images/website/icons/light/new/tooltip.png" class="compenents">
            <img src="/images/website/icons/light/new/scroller.png" class="compenents" style="margin-top:21px;">
            <img src="/images/website/icons/light/new/slide.png" class="compenents" style="margin-top:21px;">
            <img src="/images/website/icons/light/new/360.png" class="compenents" style="margin-top:21px;">
            <img src="/images/website/icons/light/new/bookmark.png" class="compenents" style="margin-top:21px;">
            <img src="/images/website/icons/light/new/animasyon.png" class="compenents" style="margin-top:21px;">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="sep-top-2x sep-bottom-2x">
    <div class="container">
      <!--           <div class="row">
                  <div class="col-md-12">
                    <div class="section-title">
                      <h2 class="upper"><span>NEDEN Gale Press?</span></h2>
                    </div>
                  </div>
                </div> -->
      <div class="row">
        <div class="col-md-3 icon-gradient">
          <div class="icon-box icon-horizontal icon-lg">
            <img src="/images/website/infographic/gray/1.png">

            <div class="icon-box-content">
              <h5 class="upper">{{__('website.home_interactive_editor')}}</h5>

              <p>{{__('website.home_interactive_editor_text')}}</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 icon-gradient">
          <div class="icon-box icon-horizontal icon-lg">
            <img src="/images/website/infographic/gray/2.png">

            <div class="icon-box-content">
              <h5 class="upper" style="color:#0986c2;">{{__('website.home_interactive_compenents')}}</h5>

              <p>{{__('website.home_interactive_compenents_text')}}</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 icon-gradient">
          <div class="icon-box icon-horizontal icon-lg">
            <img src="/images/website/infographic/gray/3.png">

            <div class="icon-box-content">
              <h5 class="upper" style="color:#0986c2;">{{__('website.home_push_notification')}}</h5>

              <p>{{__('website.home_push_notification_text')}}</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 icon-gradient">
          <div class="icon-box icon-horizontal icon-lg">
            <img src="/images/website/infographic/gray/6.png">
            <div class="icon-box-content">
              <h5 class="upper" style="color:#0986c2;">{{__('website.home_reports')}}</h5>

              <p>{{__('website.home_reports_text')}}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3 sep-top-lg icon-gradient">
          <div class="icon-box icon-horizontal icon-lg">
            <img src="/images/website/infographic/gray/4.png">

            <div class="icon-box-content">
              <h5 class="upper" style="color:#0986c2;">{{__('website.home_security')}}</h5>

              <p>{{__('website.home_security_text')}}</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 sep-top-lg icon-gradient">
          <div class="icon-box icon-horizontal icon-lg">
            <img src="/images/website/infographic/gray/7.png">

            <div class="icon-box-content">
              <h5 class="upper" style="color:#0986c2;">{{__('website.home_speed')}}</h5>

              <p>{{__('website.home_speed_text')}}</p>
            </div>
          </div>
        </div>
        <div class="col-md-3 sep-top-lg icon-gradient">
          <div class="icon-box icon-horizontal icon-lg">
            <img src="/images/website/infographic/gray/5.png">

            <div class="icon-box-content">
              <h5 class="upper" style="color:#0986c2;">{{__('website.home_speed_theworldisyours')}}</h5>

              <p>{{__('website.home_speed_theworldisyours_text')}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection