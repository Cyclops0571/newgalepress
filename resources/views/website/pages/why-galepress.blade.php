@extends('website.html')

@section('body-content')

  <section style="background-image: url(/images/website/sectors/background.jpg);"
           class="header-section parallax forceCovering">
    <div class="section-shade sep-top-3x sep-bottom-3x">
      <div class="container">
        <div class="row sep-top-md">
          <div class="col-md-12">
            <div class="row">
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

  <section class="sep-top-md sep-bottom-md">
    <div class="container">
      <div class="row">
        <div data-wow-delay=".5s" class="col-md-12 wow bounceInDown animated"
             style="visibility: visible; -webkit-animation-delay: 0.5s;">
          <div class="section-title text-center">
            <div class="row">
              <h3><span style="font-weight: 800">{{__('website.howitworks_title')}}</span></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row sep-top-xs">
      <div data-wow-delay=".5s" class="col-md-12 wow bounceInDown animated"
           style="visibility: visible; -webkit-animation-delay: 0.5s;">
        <div class="container">
          <div class="row">


            <div class="col-md-2 col-sm-2 col-xs-12 col-md-offset-2 col-sm-offset-2">
              <img src="/images/website/howdoes/1.png" width="100%">
              <div class="col-md-10 col-md-offset-1 col-sm-10">
                <p class="text-center sep-top-xs howDoesFuncTitle">{{__('website.howitworks_upload')}}</p>
              </div>
              <div class="col-md-12 col-sm-12">
                <p class="text-center sep-top-xs howDoesFuncSubTitle">{{__('website.howitworks_upload_text')}}</p>
              </div>
            </div>

            <div class="col-md-1 col-sm-1 text-center">
              <h5><i class="fa fa-plus howDoesPlus"></i></h5>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12">
              <img src="/images/website/howdoes/2.png" width="100%">
              <div class="col-md-10 col-md-offset-1 col-sm-10">
                <p class="text-center sep-top-xs howDoesFuncTitle">{{__('website.howitworks_makeinteractive')}}</p>
              </div>
              <div class="col-md-12 col-sm-12">
                <p class="text-center sep-top-xs howDoesFuncSubTitle">{{__('website.howitworks_makeinteractive_text')}}</p>
              </div>
            </div>

            <div class="col-md-1 col-sm-1 text-center">
              <h5><i class="fa fa-plus howDoesPlus"></i></h5>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12">
              <img src="/images/website/howdoes/3.png" width="100%">
              <div class="col-md-10 col-md-offset-1 col-sm-10">
                <p class="text-center sep-top-xs howDoesFuncTitle">{{__('website.howitworks_publish')}}</p>
              </div>
              <div class="col-md-12 col-sm-12">
                <p class="text-center sep-top-xs howDoesFuncSubTitle">{{__('website.howitworks_publish_text')}}</p>
              </div>
            </div>
          </div>

          <div class="row text-center sep-top-md">
            <div class="col-md-12 col-sm-12" style="padding:0;">
              <h5><i class="fa fa-pause" style="color:#0986c2;"></i></h5>
            </div>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-12 sep-top-sm col-md-offset-5 col-sm-offset-5 text-center">
              <img src="/images/website/howdoes/4.png" width="100%">
              <div class="col-md-10 col-md-offset-1 col-sm-10">
                <p class="text-center sep-top-xs howDoesFuncTitle">{{__('website.howitworks_follow')}}</p>
              </div>
              <div class="col-md-12 col-sm-12">
                <p class="text-center sep-top-xs howDoesFuncSubTitle">{{__('website.howitworks_follow_text')}}</p>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </section>

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



  <section id="services" class="sep-top-md sep-bottom-2x" style="background:#EAEAEA;">
    <div class="container">
      <div class="row" style="text-align:left;">
        <div class="col-md-5 col-md-offset-1 col-sm-6">
          <div data-wow-delay="1s"
               class="icon-box icon-lg sep-top-md sep-top-sm icon-gradient wow bounceInRight animated"
               style="visibility: visible; -webkit-animation-delay: 1s;">
            <div class="icon-content img-circle transparent">
              <img src="/images/website/icons/video.png"/>
            </div>
            <div class="icon-box-content">
              <h5 class="howDoesCompTitle">{{__('website.howitworks_comp_video')}}</h5>
              <p class="howDoesCompSubTitle">{{__('website.howitworks_comp_video_text')}}</p>
            </div>
          </div>
          <div data-wow-delay="1s"
               class="icon-box icon-lg sep-top-md sep-top-sm icon-gradient wow bounceInRight animated"
               style="visibility: visible; -webkit-animation-delay: 1s;">
            <div class="icon-content img-circle transparent">
              <img src="/images/website/icons/ses.png"/>
            </div>
            <div class="icon-box-content">
              <h5 class="howDoesCompTitle">{{__('website.howitworks_comp_audio')}}</h5>
              <p class="howDoesCompSubTitle">{{__('website.howitworks_comp_audio_text')}}</p>
            </div>
          </div>
          <div data-wow-delay="1s"
               class="icon-box icon-lg sep-top-md sep-top-sm icon-gradient wow bounceInRight animated"
               style="visibility: visible; -webkit-animation-delay: 1s;">
            <div class="icon-content img-circle transparent">
              <img src="/images/website/icons/harita.png"/>
            </div>
            <div class="icon-box-content">
              <h5 class="howDoesCompTitle">{{__('website.howitworks_comp_map')}}</h5>
              <p class="howDoesCompSubTitle">{{__('website.howitworks_comp_map_text')}}</p>
            </div>
          </div>
          <div data-wow-delay="1s"
               class="icon-box icon-lg sep-top-md sep-top-sm icon-gradient wow bounceInRight animated"
               style="visibility: visible; -webkit-animation-delay: 1s;">
            <div class="icon-content img-circle transparent">
              <img src="/images/website/icons/link.png"/>
            </div>
            <div class="icon-box-content">
              <h5 class="howDoesCompTitle">{{__('website.howitworks_comp_link')}}</h5>
              <p class="howDoesCompSubTitle">{{__('website.howitworks_comp_link_text')}}</p>
            </div>
          </div>
          <div data-wow-delay="1s"
               class="icon-box icon-lg sep-top-md sep-top-sm icon-gradient wow bounceInRight animated"
               style="visibility: visible; -webkit-animation-delay: 1s;">
            <div class="icon-content img-circle transparent">
              <img src="/images/website/icons/web.png"/>
            </div>
            <div class="icon-box-content">
              <h5 class="howDoesCompTitle">{{__('website.howitworks_comp_web')}}</h5>
              <p class="howDoesCompSubTitle">{{__('website.howitworks_comp_web_text')}}</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div data-wow-delay="1s"
               class="icon-box icon-lg sep-top-md sep-top-sm icon-gradient wow bounceInRight animated"
               style="visibility: visible; -webkit-animation-delay: 1s;">
            <div class="icon-content img-circle transparent">
              <img src="/images/website/icons/tooltip.png"/>
            </div>
            <div class="icon-box-content">
              <h5 class="howDoesCompTitle">{{__('website.howitworks_comp_tooltip')}}</h5>
              <p class="howDoesCompSubTitle">{{__('website.howitworks_comp_tooltip_text')}}</p>
            </div>
          </div>
          <div data-wow-delay="1s"
               class="icon-box icon-lg sep-top-md sep-top-sm icon-gradient wow bounceInRight animated"
               style="visibility: visible; -webkit-animation-delay: 1s;">
            <div class="icon-content img-circle transparent">
              <img src="/images/website/icons/scroller.png"/>
            </div>
            <div class="icon-box-content">
              <h5 class="howDoesCompTitle">{{__('website.howitworks_comp_scroller')}}</h5>
              <p class="howDoesCompSubTitle">{{__('website.howitworks_comp_scroller_text')}}</p>
            </div>
          </div>
          <div data-wow-delay="1s"
               class="icon-box icon-lg sep-top-md sep-top-sm icon-gradient wow bounceInRight animated"
               style="visibility: visible; -webkit-animation-delay: 1s;">
            <div class="icon-content img-circle transparent">
              <img src="/images/website/icons/slider.png"/>
            </div>
            <div class="icon-box-content">
              <h5 class="howDoesCompTitle">{{__('website.howitworks_comp_slider')}}</h5>
              <p class="howDoesCompSubTitle">{{__('website.howitworks_comp_slider_text')}}</p>
            </div>
          </div>
          <div data-wow-delay="1s"
               class="icon-box icon-lg sep-top-md sep-top-sm icon-gradient wow bounceInRight animated"
               style="visibility: visible; -webkit-animation-delay: 1s;">
            <div class="icon-content img-circle transparent">
              <img src="/images/website/icons/360.png"/>
            </div>
            <div class="icon-box-content">
              <h5 class="howDoesCompTitle">{{__('website.howitworks_comp_360°')}}</h5>
              <p class="howDoesCompSubTitle">{{__('website.howitworks_comp_360°_text')}}</p>
            </div>
          </div>
          <div data-wow-delay="1s"
               class="icon-box icon-lg sep-top-md sep-top-sm icon-gradient wow bounceInRight animated"
               style="visibility: visible; -webkit-animation-delay: 1s;">
            <div class="icon-content img-circle transparent">
              <img src="/images/website/icons/bookmark.png"/>
            </div>
            <div class="icon-box-content">
              <h5 class="howDoesCompTitle">{{__('website.howitworks_comp_bookmark')}}</h5>
              <p class="howDoesCompSubTitle">{{__('website.howitworks_comp_bookmark_text')}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection