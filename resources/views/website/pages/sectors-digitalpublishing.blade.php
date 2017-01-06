@layout('website.html')

@section('body-content')


      <section id="parallax4" style="background-image: url(/images/website/sectors/background.jpg);" class="header-section parallax">
        <div class="section-shade-half sep-top-5x sep-bottom-3x">
          <div class="container">
            <div class="section-title upper text-center light">
              <h2 class="small-space">{{__('website.dp_title')}}</h2>
              <p class="lead upperNone">{{__('website.dp_subtitle')}}</p>
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
                  <div data-wow-delay=".5s" class="col-md-10 col-md-offset-1 wow bounceInDown animated" style="visibility: visible; -webkit-animation-delay: 0.5s;">
                    <div class="icon-box icon-horizontal icon-md">
                      <div class="icon-content img-circle"><img src="/images/website/sectors/new/dijital.png" data-wow-delay="0.7s" class="wow fadeInUp"></div>
                    </div>
                  </div>
                </div>
                <p class="lead">{{__('website.dp_description')}}</p>
              </div>
            </div>
          </div>
          <div class="row sep-bottom-md">
            <div class="col-md-3 sep-bottom-md">
              <div class="icon-box icon-xs icon-gradient">
                <div class="icon-box-content">
                  <img src="/images/website/cloud.png">
                  <p>
                    {{__('website.dp_clause1')}}
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3 sep-bottom-md">
              <div class="icon-box icon-xs icon-gradient">
                <div class="icon-box-content">
                    <img src="/images/website/cart.png">
                  <p>
                    {{__('website.dp_clause2')}}
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3 sep-bottom-md">
              <div class="icon-box icon-xs icon-gradient">
                <div class="icon-box-content">
                    <img src="/images/website/goingup.png">
                  <p>
                    {{__('website.dp_clause3')}}
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3 sep-bottom-md">
              <div class="icon-box icon-xs icon-gradient">
                <div class="icon-box-content">
                    <img src="/images/website/cart.png">
                  <p>
                    {{__('website.dp_clause4')}}
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
            <div class="col-md-3 text-right"><a href="/{{ Session::get('language') }}/{{__('route.website_tryit')}}" class="btn btn-light btn-bordered btn-lg">{{__('website.menu_tryit')}}</a></div>
          </div>
        </div>
      </section>
@endsection