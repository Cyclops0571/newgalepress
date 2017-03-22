@extends('website.html')

@section('body-content')

	<section class="sep-top-2x">
        <div class="container">
          	<div class="row">
            	<div class="col-md-6 sep-top-2x">
					<script>
					(function() {
						var cx = '003558081527571790912:iohyqlcsz2m';
						var gcse = document.createElement('script');
						gcse.type = 'text/javascript';
						gcse.async = true;
						gcse.src = 'https://www.google.com/cse/cse.js?cx=' + cx;
						var s = document.getElementsByTagName('script')[0];
						s.parentNode.insertBefore(gcse, s);
					})();
					</script>
					<gcse:search></gcse:search>
				</div>
			</div>
		</div>
    </section>

	
@endsection