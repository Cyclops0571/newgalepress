@layout('website.html')

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
					<h2 style="text-transform:uppercase;">{{__('website.advantages')}}</h2>
				</div>
			</div>
		</div>
	</section>
	<div class="container">
		<div class="row">
			<div class="span6">
				<div class="flexslider flexslider-center-mobile flexslider-simple" data-plugin-options='{"animation":"slide", "animationLoop": true, "maxVisibleItems": 1}'>
					<ul class="slides">
						<li>
							<img alt="" src="/images/website/galepress/avantajlar/foto1.jpg">
						</li>
						<li>
							<img alt="" src="/images/website/galepress/avantajlar/foto2.jpg">
						</li>
						<li>
							<img alt="" src="/images/website/galepress/avantajlar/foto3.jpg">
						</li>
						<li>
							<img alt="" src="/images/website/galepress/avantajlar/foto4.jpg">
						</li>
					</ul>
				</div>
			</div>
			<div class="span6">
				<h4 style="text-transform:uppercase;">{{__('website.advantages')}}</h4>
				<ul>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc1')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc2')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc3')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc4')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc5')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc6')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc7')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc8')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc9')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc10')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc11')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc12')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc13')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.advantages_slider_desc14')}}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection