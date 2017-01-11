@extends('website.html')

@section('body-content')
<div role="main" class="main">

	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="breadcrumb">
						<li><a href="/{{ Session::get('language') }}/">{{__('website.page_home')}}</a> <span class="divider">/</span></li>
						<li class="active">Blog</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h2>{{__('website.blog_articles')}}</h2>
				</div>
			</div>
		</div>
	</section>
	<style type="text/css">
	.row{
		margin-left: 0px;
	}
	a:hover{
		text-decoration: none;
	}
	</style>
	<div class="container">

		<div class="row">
			<div class="col-md-9">
				<div class="blog-posts single-post">
					<article class="post post-medium">
						<div class="row">

							<div class="col-md-7">

								<div class="post-content">

									<h2><a href="{{__('route.website_article_workflow')}}">{{__('website.article_workflow_title')}}</a></h2>
									<p style="font-size:18px;">{{__('website.article_workflow_intro')}}</p>

								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="post-meta">
									<span><i class="icon icon-calendar"></i> <?php $m = __('common.month_names')->get(); echo $m[12];?> 23, 2014 </span>
                                    <span>&nbsp;<i class="icon icon-user"></i><a href="#"> Gale Press</a> </span>
									<a href="{{__('route.website_article_workflow')}}" class="btn btn-xs btn-primary pull-right">{{__('website.blog_read_more')}}</a>
								</div>
							</div>
						</div>

					</article>
					<br>
					<article class="post post-medium">
						<div class="row">

							<div class="col-md-7">

								<div class="post-content">

									<h2><a href="{{__('route.website_article_whymobile')}}">{{__('website.article_whymobile_title')}}</a></h2>
									<p style="font-size:18px;">{{__('website.article_whymobile_intro')}}</p>

								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="post-meta">
									<span><i class="icon icon-calendar"></i> <?php $m = __('common.month_names')->get(); echo $m[12];?> 23, 2014 </span>
                                    <span>&nbsp;<i class="icon icon-user"></i><a href="#"> Gale Press</a> </span>
									<a href="{{__('route.website_article_whymobile')}}" class="btn btn-xs btn-primary pull-right">{{__('website.blog_read_more')}}</a>
								</div>
							</div>
						</div>

					</article>
					<br>
					<article class="post post-medium">
						<div class="row">

							<div class="col-md-7">

								<div class="post-content">

									<h2><a href="{{__('route.website_article_brandvalue')}}">{{__('website.article_brandvalue_title')}}</a></h2>
									<p style="font-size:18px;">{{__('website.article_brandvalue_intro')}}</p>

								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="post-meta">
									<span><i class="icon icon-calendar"></i> <?php $m = __('common.month_names')->get(); echo $m[12];?> 23, 2014 </span>
                                    <span>&nbsp;<i class="icon icon-user"></i><a href="#"> Gale Press</a> </span>
									<a href="{{__('route.website_article_brandvalue')}}" class="btn btn-xs btn-primary pull-right">{{__('website.blog_read_more')}}</a>
								</div>
							</div>
						</div>
					</article>
					<br><br>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection