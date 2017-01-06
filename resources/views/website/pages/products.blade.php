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
					<h2>{{__('website.page_products')}}</h2>
				</div>
			</div>
		</div>
	</section>
	<style type="text/css">
    
	 .flexslider .slides img {display: block; margin-left: auto; margin-right: auto;}

	</style>
	<div class="container">
		<div class="row">
			<div class="span8">
				<div class="flexslider flexslider-center-mobile flexslider-simple" data-plugin-options='{"animation":"slide", "animationLoop": true, "maxVisibleItems": 1}'>
					<ul class="slides">
						<li><img alt="" src="/images/website/urunler/uygulama/01.png" width="35%"></li>
						<li><img alt="" src="/images/website/urunler/uygulama/02.png" width="35%"></li>
						<li><img alt="" src="/images/website/urunler/uygulama/03.png" width="35%"></li>
						<li><img alt="" src="/images/website/urunler/uygulama/04.png" width="35%"></li>
						<li><img alt="" src="/images/website/urunler/uygulama/05.png" width="35%"></li>
						<li><img alt="" src="/images/website/urunler/uygulama/06.png" width="35%"></li>
						<li><img alt="" src="/images/website/urunler/uygulama/07.png" width="50%"></li>
						<li><img alt="" src="/images/website/urunler/uygulama/08.png" width="50%"></li>
					</ul>
				</div>
			</div>
			<div class="span4">
				<h4>{{__('website.products_mobileapp')}}</h4>
				<p>{{__('website.products_mobileapp_desc')}}</p>
				<ul>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.products_mobileapp_desc1')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.products_mobileapp_desc2')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.products_mobileapp_desc3')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.products_mobileapp_desc4')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.products_mobileapp_desc5')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.products_mobileapp_desc6')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.products_mobileapp_desc7')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.products_mobileapp_desc8')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.products_mobileapp_desc9')}}</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container"><br /><br />
		<div class="row">
			<div class="span8">
				<div class="flexslider flexslider-center-mobile flexslider-simple" data-plugin-options='{"animation":"slide", "animationLoop": true, "maxVisibleItems": 1}'>
					<ul class="slides">
						<li><img alt="" src="/images/website/urunler/dys/01.png" width="91%"></li>
						<li><img alt="" src="/images/website/urunler/dys/02.png" width="91%"></li>
						<li><img alt="" src="/images/website/urunler/dys/03.png" width="91%"></li>
						<li><img alt="" src="/images/website/urunler/dys/04.png" width="91%"></li>
						<li><img alt="" src="/images/website/urunler/dys/05.png" width="91%"></li>
					</ul>
				</div>
			</div>
			<div class="span4">
				<h4>{{__('website.cms')}}</h4>
				<p>{{__('website.cms_desc')}}</p>
				<ul>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.cms_desc1')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.cms_desc2')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.cms_desc3')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.cms_desc4')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.cms_desc5')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.cms_desc6')}}</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container"><br /><br />
		<div class="row">
			<div class="span8">
				<div class="flexslider flexslider-center-mobile flexslider-simple" data-plugin-options='{"animation":"slide", "animationLoop": true, "maxVisibleItems": 1}'>
					<ul class="slides">
						<li><img alt="" src="/images/website/urunler/rapor/01.png" width="91%"></li>
						<li><img alt="" src="/images/website/urunler/rapor/02.png" width="91%"></li>
						<li><img alt="" src="/images/website/urunler/rapor/03.png" width="91%"></li>
						<li><img alt="" src="/images/website/urunler/rapor/04.png" width="91%"></li>
					</ul>
				</div>
			</div>
			<div class="span4">
				<h4>{{__('website.reports')}}</h4>
				<p>{{__('website.reports_desc')}}</p>
				<ul>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.reports_desc1')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.reports_desc2')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.reports_desc3')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.reports_desc4')}}</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		<br />
		<br />
		<div class="row">
			<div class="span8">
				<div class="flexslider flexslider-center-mobile flexslider-simple" data-plugin-options='{"animation":"slide", "animationLoop": true, "maxVisibleItems": 1}'>
					<ul class="slides">
						<li><img alt="" src="/images/website/urunler/interaktif/01.png" width="91%"></li>
						<li><img alt="" src="/images/website/urunler/interaktif/02.png" width="91%"></li>
						<li><img alt="" src="/images/website/urunler/interaktif/03.png" width="91%"></li>
						<li><img alt="" src="/images/website/urunler/interaktif/04.png" width="91%"></li>
					</ul>
				</div>
			</div>
			<div class="span4">
				<h4>{{__('website.add_interactive_content')}}</h4>
				<p>{{__('website.add_interactive_content_desc')}}</p>
				<ul>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.interactive_content_desc1')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.interactive_content_desc2')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.interactive_content_desc3')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.interactive_content_desc4')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.interactive_content_desc5')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.interactive_content_desc6')}}</li>
					<li style="list-style-image:url('/images/website/aa.png');">{{__('website.interactive_content_desc7')}}</li>
				</ul>
			</div>
		</div>
	</div>
</div>	
@endsection