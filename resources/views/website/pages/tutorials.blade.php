@extends('website.html')

@section('body-content')

<div role="main" class="main">
	<section class="page-top">
		<div class="container">
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<li><a href="/{{ app()->getLocale() }}/">{{__('website.page_home')}}</a> <span class="divider">/</span></li>
						<li class="active">{{__('website.page_tutorials')}}</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="span12">
					<h2 style="text-transform:uppercase;">{{__('website.page_tutorials')}}</h2>
				</div>
			</div>
		</div>
	</section>
	<div class="container">
		<div class="row">
			<ul class="portfolio-list sort-destination" data-sort-id="portfolio">
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/nyKTpgnHJNI" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.login')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/3clZBhkPH9c" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_settings')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/m1-JB_UPNZo" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.reports')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/zcpQh-POwPc" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_upload_pdf')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe src="https://www.youtube.com/embed/yzzREdT-FuI" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_general')}}</span>
						</span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/Heo3jMGtHac" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_video')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/hglDIO1sC3Q" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_audio')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/IssimeTzvjA" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_map')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/5g8J09l9b0I" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_map_google')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/k9Kk1YLw3jM" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_link')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/bXlI1CMQGAs" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_web')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/UVWspqkWuXE" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_youtube')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/yw7YOWmZKF0" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_tooltip')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/18r5zeADBEY" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_scroller')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/6__3hMo8gLs" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_image_mac')}}</span>
						</span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/u33JHsqH0QM" frameborder="0" allowfullscreen style="width: 100%; height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_slider')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
				<li class="span6 isotope-item websites">
					<div class="portfolio-item thumbnail">
						<iframe  src="https://www.youtube.com/embed/gNvKbTSqonY" frameborder="0" allowfullscreen style="width: 100%;  height:370px;"></iframe>
						<span class="thumb-info-title">
							<span class="thumb-info-inner">{{__('website.interactive_animation')}}</span>
						</span>
						<span class="thumb-info-action"></span>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
	
@endsection