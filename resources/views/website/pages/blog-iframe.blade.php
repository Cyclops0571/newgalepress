@layout('website.html')

@section('body-content')

      <!-- Start Parallax section-->
      <section class="sep-top-2x sep-bottom-2x">
        <div class="container">
          <div class="row">
            <div class="col-md-12" id="blog-frame">
              <a href="http://www.galepress.com/{{ Session::get('language') }}/blog" class="btn btn-link btn-bordered"><i class="fa fa-rss"></i><span style="margin-left:10px;"><u>Blog</u></span></a>
              <a href="#" class="btn btn-link btn-bordered"><i class="fa fa-newspaper-o"></i><span style="margin-left:10px;">{{__('website.blog_news')}}</span></a>
              <a href="/{{ Session::get('language') }}/{{__('route.website_blog_tutorials')}}" class="btn btn-link btn-bordered"><i class="fa fa-video-camera"></i><span style="margin-left:10px;">{{__('website.blog_tutorials')}}</span></a>
              <iframe src="http://www.galepress.com/blog/" id="blogIframe" scrolling="no" frameborder="0" style="width:100% !important; height:100% !important; overflow:hidden; margin-top:19px;"></iframe>
            </div>
          </div>
        </div>
      </section>
      <!-- End Parallax section-->

@endsection