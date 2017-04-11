<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gale Press Flipbook BETA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" type="text/css" href="/flipbook/css/bootstrap.css?v=<?php use App\Models\Content;echo APP_VER; ?>">
    <link rel="stylesheet" type="text/css" href="/flipbook/css/stylesheet.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" type="text/css" href="/flipbook/css/myWebsiteStyles.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" type="text/css" href="/flipbook/css/stylesheets.css?v=<?php echo APP_VER; ?>">
    <link rel="stylesheet" type="text/css" href="/flipbook/css/flipbook.style.css?v=<?php echo APP_VER; ?>">
    <!--<link rel="stylesheet" type="text/css" href="/flipbook/css/flipbook.skin.black.css?v=<?php echo APP_VER; ?>">-->
    <link rel="stylesheet" type="text/css" href="/flipbook/css/font-awesome.min.css?v=<?php echo APP_VER; ?>">
	<link rel="stylesheet" type="text/css" href="/flipbook/css/jquery.switchButton.css?v=<?php echo APP_VER; ?>">
	<link rel="stylesheet" type="text/css" href='http://fonts.googleapis.com/css?family=Lato:300,400'>
	<link rel="shortcut icon" href="/website/img/favicon2.ico">
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top myNavbar" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="/flipbook/images/flipbookLogoBeta.png" id="headerLogo">
            </div>
            <div class="navbar-collapse collapse">
                <form class="navbar-form navbar-right">
	                <div class="navbar-form">
	                    <div class="btn-group">
	                        <button type="button" class="btnCircleLess" data-toggle="modal">
	                            <span class="fa fa-th" style="vertical-align: middle !important;"></span>
	                            <span class="caret"></span>
	                        </button>
	                        <div class="popover fade bottom in hidden" id="categories">
	                            <div class="arrow"></div>
	                            <h3 class="popover-title">
	                                <div style="word-wrap: break-word; width: 120px; float:left" id="category-title">Kategoriler</div>
	                                <a style="cursor:pointer;" id="categoryCheckControl" showText="Tümünü Göster" hideText="Tümünü Gizle">Tümünü Gizle</a>
	                            </h3>
	                            <div class="popover-content">
	                            	<?php
	                            	function isChecked($filterCat, $catID){
	                            		if(is_array($filterCat)) {
		                            		foreach($filterCat as $fc) {
		                            			if((int)$catID == (int)$fc) {
		                            				return true;
		                            			}
		                            		}
		                            	}
		                            	else {
		                            		return true;
		                            	}
		                            	return false;
	                            	}
	                            	?>
									<div class="switch-wrapper-text">Genel</div>
									<div class="switch-wrapper">
										<input type="checkbox" name="cat[]" value="0"{{ (isChecked($filterCat, 0) ? ' checked="checked"' : '') }}>
									</div>
	                            	@foreach($cat as $c)
	                            	<hr>
	                            	<div class="switch-wrapper-text">{{ $c->Name }}</div>
									<div class="switch-wrapper">
										<input type="checkbox" name="cat[]" value="{{ $c->CategoryID }}"{{ (isChecked($filterCat, $c->CategoryID) ? ' checked="checked"' : '') }}>
									</div>
	                            	@endforeach
	                            </div>
	                            <input type="submit" value="Filtrele" class="btn btn-lg btn-primary btn-block">
	                        </div>
	                        <input type="text" class="form-control" name="search" placeholder="Arama..." value="{{ $filterSearch }}">
	                    </div>
	                </div>
                </form>
            </div>
        </div>
    </div>
   	<div class="container" id="libraryBackground">
       <div class="rowLib">
       		@foreach($contents as $content)
       		<div id="content{{ $content->ContentID }}" contentID="{{ $content->ContentID }}" class="covers" style=" color:#fff; cursor:pointer;">  
                <div class="content-container">
                    <img src="/{{ $content->CoverImageFile }}" class="libraryThumbHover"/>
                    <p><h4 class="contentTitle">{{ $content->Name }}</h4></p>
                    <p>{{ $content->Detail }}</p>
                    <h2 class="libraryThumbText">OKU</h2>
                </div>
            </div>
	    	@endforeach
        </div>
    </div>
	<!--scripts-->
	<script src="/flipbook/js/jquery-2.1.0.min.js"></script>
	<script src="/flipbook/js/bootstrap.js"></script>
	<script src="/flipbook/js/jquery-ui.min.js"></script>
	<script src="/flipbook/js/jquery.switchButton.js"></script>
	<script src="/flipbook/js/three66.min.js"></script>
	<script src="/flipbook/js/flipbook.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function () {

			var contentPages = {};

			<?php
			foreach($contents as $content) {
				$c = Content::find($content->ContentID);

				$pages = array();

				foreach($c->ActiveFile()->ActivePages() as $page) {

					array_push($pages, array(
						'title' => $page->No,
						'src' => '/'.$page->FilePath.'/'.$page->FileName,
						'thumb' => '/'.$page->FilePath.'/'.$page->FileName
					));
				}

				echo "contentPages['content".$c->ContentID."'] = ".json_encode($pages).";\r\n";
			}
			?>

			$('.btnCircleLess').click(function(){
				$('#categories').toggleClass('hidden');
			});

			$("#categories input[type=checkbox]").each(function(){
				var checked = $(this).attr('checked') == "checked";
				$(this).switchButton({
					checked: checked,
					show_labels: false
				});
			});

			var category_status = false;

			$('#categoryCheckControl').click(function(){
				if(!category_status){
				
					$("#categories input[type=checkbox]").each(function(){
						$(this).switchButton({
							show_labels: false,
							checked: false
						});
					});
					$(this).text($(this).attr("showText"));
					$('#category-title').css("width","109");
					category_status = true;
				}
				else {
					$("#categories input[type=checkbox]").each(function(){
						$(this).switchButton({
							show_labels: false,
							checked: true
						});
					});
					$(this).text($(this).attr("hideText"));
					$('#category-title').css("width", "120");
					category_status = false;
				}
			});




			var isMobile = {
		        Android: function() {
		            return navigator.userAgent.match(/Android/i);
		        },
		        BlackBerry: function() {
		            return navigator.userAgent.match(/BlackBerry/i);
		        },
		        iOS: function() {
		            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		        },
		        Opera: function() {
		            return navigator.userAgent.match(/Opera Mini/i);
		        },
		        Windows: function() {
		            return navigator.userAgent.match(/IEMobile/i);
		        },
		        any: function() {
		            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		        }
		    };
		    //TODO:Performans nedeniyle her zaman mobil ayarlari ile calismali!
			if(isMobile.any() || 1 == 1){

				$.extend($.fn.flipBook.options, {
					webgl:false,
					flipType:"2d",
					cameraDistance:3000
				});
			}

			$("#libraryBackground .covers").on("click", function() {
				$(this).unbind("click");
				//destroy
				$(this).flipBook({
					pages:contentPages['content' + $(this).attr("contentID")],
					lightBox:true,
					skin:"dark",
					btnShare:false,
					btnDownloadPages:false,
					downloadPdfUrl:false,
					btnDownloadPdf:false
				});
			});


			if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
	        var msViewportStyle = document.createElement("style");
	        msViewportStyle.appendChild(
	            document.createTextNode(
	                "@-ms-viewport{width:100% !important}"
	            )
	        );
	        document.getElementsByTagName("head")[0].
	            appendChild(msViewportStyle);
	    }


		})
	</script>
	<!--/scripts-->
	<div class="modal fade" id="modalFlipbook" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-book" style="font-size:20px;"></i>&nbsp;&nbsp;&nbsp;{{ __('common.site_system_message') }}</h4>
	      </div>
	      <div class="modal-body">
	        İçeriklerinizin flipbook sayfanızda yayınlanabilmesi için içeriğinizin interaktif tasarlayıcısı açılmış, durumu aktif edilmiş ve parola korumasının kaldırılmış olması gerekmektedir.
	      </div>
	    </div>
	  </div>
	</div>
	<script type="text/javascript">
	var firstURL = document.URL;
	var n = firstURL.indexOf("?");
	if(n==-1)
	$('#modalFlipbook').modal('show');
	</script>
</body>
</html>