@extends('website.html')

@section('body-content')

<div role="main" class="main">
	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li><a href="/{{ Session::get('language') }}/">{{__('website.page_home')}}</a> <span class="divider">/</span></li>
                        <li class="active">Gale Press</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<h2>{{__('website.sitemap')}}</h2>
				</div>
			</div>
		</div>
	</section>
	<div class="container">
		<div class="row">
			<div class="span6">
				<ul class="sitemap list icons" style="list-style-type: none;">
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="/{{ Session::get('language') }}/">{{__('website.page_home')}}</a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="/{{ Session::get('language') }}/{{__('route.website_products')}}">{{__('website.page_products')}}</a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="/{{ Session::get('language') }}/{{__('route.website_advantages')}}">{{__('website.page_advantages')}}</a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="/{{ Session::get('language') }}/{{__('route.website_tutorials')}}">{{__('website.page_tutorials')}}</a>
					</li>
					<li>
						<i class="icon-caret-right">&nbsp</i><a href="/{{ Session::get('language') }}/{{__('route.website_contact')}}">{{__('website.page_contact')}}</a>
					</li>
					<?php if(app()->isLocale('tr')): ?>
					    <li>
						    <i class="icon-caret-right">&nbsp</i><a href="/blog">Blog</a>
					    </li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="span6 hidden-phone" >
				<h2>{{__('website.sitemap_whous')}}</h2>
				<p class="lead">{{__('website.sitemap_whous_detail')}}</p>
				<ul class="list icons">
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.sitemap_whous_detail1')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.sitemap_whous_detail2')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.sitemap_whous_detail3')}}</li>
				</ul>
				<p>&nbsp;</p>
			</div>
		</div>
	</div>
</div>
@endsection