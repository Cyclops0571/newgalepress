<style type="text/css">
.iconList{
  padding: 0;
}
.iconList li{
  display: inline;
  list-style-type: none;
}
</style>
<div class="col-md-8">
	<a href="#" rel="popover" id="selectedIcon" class="btn" data-popover-content="#myPopover"><img src="/img/app-icons/1.png" /></a>
	<div id="myPopover" class="hide">
	  <ul class="iconList">
	    <li><button type="button" class="btn"><img src="/img/app-icons/1.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/2.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/3.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/4.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/5.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/6.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/7.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/8.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/9.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/10.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/11.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/12.png" width="50" /></button></li>
	    <li><button type="button" class="btn"><img src="/img/app-icons/13.png" width="50" /></button></li>
	  </ul>
	</div>
	<script type="text/javascript">
	  $(function(){
	    $('[rel="popover"]').popover({
	        container: 'body',
	        html: true,
	        content: function () {
	            var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
	            return clone;
	        }
	    }).click(function(e) {
	        e.preventDefault();
	    });
	    $('.iconList li button').click(function(){
	      $('#selectedIcon img').attr('src',$(this).find('img').attr('src'));
	    })
	  });
	</script>
</div>