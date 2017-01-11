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
					<h2>{{__('website.blog_article')}}</h2>
				</div>
			</div>
		</div>
	</section>
	<style type="text/css">
	.row{
		margin-left: 0px;
	}
	p{
		font-size: 18px;
	}
	</style>
	<div class="container">

		<div class="row">
			<div class="col-md-9">
				<div class="blog-posts single-post">

					<article class="post post-large blog-single-post">
						<div class="post-date">
							<span><i class="icon icon-calendar"></i> <?php $m = __('common.month_names')->get(); echo $m[12];?> 23, 2014 </span>
                            <span>&nbsp;<i class="icon icon-user"></i>&nbsp;<a href="#">Gale Press</a> </span>
						</div>

						<div class="post-content">
							{{__('website.article_workflow_content')}}
						</div>
					</article>
					<br><br>
				</div>
			</div>

		</div>

	</div>

</div>
@endsection