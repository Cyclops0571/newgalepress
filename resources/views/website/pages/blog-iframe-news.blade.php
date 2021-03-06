@extends('website.html')

@section('body-content')

      <!-- Start Parallax section-->
      <section class="sep-top-2x sep-bottom-2x">
        <div class="container">
          <div class="row">
            <div class="col-md-12" id="blog-frame-news">
              <a href="http://www.galepress.com/{{ app()->getLocale() }}/blog" class="btn btn-link btn-bordered"><i class="fa fa-rss"></i><span style="margin-left:10px;">Blog</span></a>
              <a href="#" class="btn btn-link btn-bordered"><i class="fa fa-newspaper-o"></i><span style="margin-left:10px;"><u>{{__('website.blog_news')}}</u></span></a>
              <a href="{{'/' . app()->getLocale() . '/' . __('route.website_blog_tutorials')}}" class="btn btn-link btn-bordered"><i class="fa fa-video-camera"></i><span style="margin-left:10px;">{{__('website.blog_tutorials')}}</span></a>
              <iframe src="http://www.galepress.com/blog/?page_id=5894" id="blogIframeNews" scrolling="no" frameborder="0" style="width:100% !important; height:100% !important; overflow:hidden; margin-top:19px;"></iframe>
            </div>
          </div>
        </div>
      </section>
      <!-- End Parallax section-->

@endsection