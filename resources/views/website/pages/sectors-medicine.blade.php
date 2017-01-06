@layout('website.html')

@section('body-content')


    <section id="parallax4" style="background-image: url(/images/website/headers/ilac.jpg);"
             class="header-section parallax">
        <div class="sep-top-5x sep-bottom-3x">
            <div class="container">
                <div class="section-title upper text-center light">
                    <h2 class="small-space">{{__('website.pharmaceutical_title')}}</h2>

                    <p class="lead upperNone">{{__('website.pharmaceutical_subtitle')}}</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Start Icons Section-->
    <section class="sep-top-2x sep-bottom-2x">
        <div class="container">
            <div class="row sep-bottom-2x">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-title text-center">
                        <div class="row">
                            <div data-wow-delay=".5s" class="col-md-10 col-md-offset-1 wow bounceInDown animated"
                                 style="visibility: visible; -webkit-animation-delay: 0.5s;">
                                <div class="icon-box icon-horizontal icon-md">
                                    <div class="icon-content img-circle">
                                        <img src="<?php echo __('filelang.medikal-or-b2b'); ?>"
                                             data-wow-delay="1.5s"
                                             class="wow fadeInUp">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="lead">{{__('website.pharmaceutical_description')}}</p>
                    </div>
                </div>
            </div>
            <div class="row sep-bottom-md">
                <div class="col-md-3 sep-bottom-md">
                    <div class="icon-box icon-xs icon-gradient">
                        <div class="icon-box-content">
                            <h6 style="font-size:5px;"><i class="fa fa-circle"></i></h6>

                            <p>
                                {{__('website.pharmaceutical_clause1')}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 sep-bottom-md">
                    <div class="icon-box icon-xs icon-gradient">
                        <div class="icon-box-content">
                            <h6 style="font-size:5px;"><i class="fa fa-circle"></i></h6>

                            <p>
                                {{__('website.pharmaceutical_clause2')}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 sep-bottom-md">
                    <div class="icon-box icon-xs icon-gradient">
                        <div class="icon-box-content">
                            <h6 style="font-size:5px;"><i class="fa fa-circle"></i></h6>

                            <p>
                                {{__('website.pharmaceutical_clause3')}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 sep-bottom-md">
                    <div class="icon-box icon-xs icon-gradient">
                        <div class="icon-box-content">
                            <h6 style="font-size:5px;"><i class="fa fa-circle"></i></h6>

                            <p>
                                {{__('website.pharmaceutical_clause4')}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Icons section-->

    <section class="call-to-action bg-primary sep-top-md sep-bottom-md">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <h5 class="action-title upper light"></h5>
                </div>
                <div class="col-md-3 text-right"><a href="/{{ Session::get('language') }}/{{__('route.website_tryit')}}"
                                                    class="btn btn-light btn-bordered btn-lg">{{__('website.menu_tryit')}}</a>
                </div>
            </div>
        </div>
    </section>
@endsection