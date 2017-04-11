$(function()
{
    initPdfPage();
    initTabs();
    initTree();
    initPageClickEvent();
    initPageTooltip();
    initComponentInfo();
    initSidebarTooltip();
    initDroppable();
    initDraggable();
    initPreview();
    initFullscreen();
});

function initPdfPage()
{
	cInteractivity.showPage(1);
	$("#pdf-page")
		.blur(function()
		{
			var pageCount = $("div.thumblist ul.slideshow-slides li.each-slide").length;
			var val = $(this).val();
			if(val.indexOf("/") > -1) {
				var arr = val.split('/');
				val = parseInt(arr[0]);
			}
			else {
				val = parseInt(val);
			}
			if(val > pageCount) {
				val = pageCount;
			}
            cInteractivity.saveCurrentPage();
			cInteractivity.showPage(val);
		})
		.keydown(function (e)
		{
			if(e.keyCode == 13) {
				var pageCount = $("div.thumblist ul.slideshow-slides li.each-slide").length;
				var val = $(this).val();
				if(val.indexOf("/") > -1) {
					var arr = val.split('/');
					val = parseInt(arr[0]);
				}
				else {
					val = parseInt(val);
				}
				if(val > pageCount) {
					val = pageCount;
				}
                cInteractivity.saveCurrentPage();
				cInteractivity.showPage(val);
			}
		});
}

function initTabs()
{
	$('#tab-container').easytabs({
		animate: false
	});
}

function initTree()
{
	$('div.tree').collapse(false, true);
	$('div.tree a.selectcomponent').click(function(){ cInteractivity.selectComponent($(this)); });
}

function initPageClickEvent()
{
	$("div.thumblist ul.slideshow-slides li.each-slide a").click(function(){
		if(parseInt($(this).attr("pageno")) !== parseInt($("#pageno").val())) {
            cInteractivity.saveCurrentPage();
			cInteractivity.showPage($(this).attr("pageno"));
		}
	});
}

function initPageTooltip()
{
	$(".img-tooltip").tooltip({ 
		content: function() {
			return $(this).clone(); 
		},
		tooltipClass: "image-tooltip",
		position: {
			my: "center bottom",
			at: "center top"
		}
	});
}

function initComponentInfo()
{
	$("ul.components li a").hover(
		function(){
			//$("#component-container div.component").addClass("hide");
			$("div.component-info div#info-" + $(this).parent().attr("componentname")).removeClass("invisible");
		},
		function(){
			$("div.component-info div#info-" + $(this).parent().attr("componentname")).addClass("invisible");
		}
	);
}

function initSidebarTooltip()
{
	$("div.sidebar .tooltip").tooltip({
		position: {
			my: "center bottom-20",
			at: "center top",
			using: function(position, feedback) {
				$(this).css(position);
				$("<div>")
					.addClass("arrow")
					.addClass(feedback.vertical)
					.addClass(feedback.horizontal)
					.appendTo(this);
			}
		}
	});
}

function initDroppable()
{
	$("#page").droppable({
		tolerance: "touch",
		accept: "ul.components li",
		drop: function(event, ui)
		{
			//var contLeft = $("#pdf-container").offset().left;
			//var contTop = $("#pdf-container").offset().top;
			var contPage = $("#page");
			var scale = getScale();
			//var left = ((ui.offset.left - contLeft) * scale) - getTransformTranslateX(contPage);
			//var top = ((ui.offset.top - contTop) * scale) - getTransformTranslateY(contPage);
			var left = (ui.offset.left - contPage.offset().left) / scale;
			var top = (ui.offset.top - contPage.offset().top) / scale;
			
			//Collapse destroy
			$('div.tree a').unbind('click');

			ui.helper.component({
				left: parseInt(left),
				top: parseInt(top)
			});
			
			//Collapse init
			initTree();
			//$('div.tree').collapse(false, true);
			//$('div.tree a.selectcomponent').click(function(){ cInteractivity.selectComponent($(this)); });
		}
	});
}

function initDraggable()
{
	$("ul.components li").draggable({
		helper: "clone",
		start: function(event, ui)
		{
			ui.helper.css("z-index", "1000");
			$(this).addClass("active");
		},
		stop: function(event, ui)
		{
			$(this).removeClass("active");
		}
	});
}

function initPreview()
{
	updatePageRequestTime();
	
	$("#preview div.commutator").mousedown(function()
	{
		if ($(this).hasClass("off"))
		{
			//console.log('off');
			$("#page").removeClass("preview").droppable("enable");

			$("ul.components li").draggable("enable");
			
			$("#page div.modal-component, #page div.tooltip-trigger").each(function(){
				
				if($(this).hasClass("tooltip-trigger")) {
					$(this)
						.css('width', '30px')
						.css('height', '30px');
				}

				if($(this).hasClass("ui-draggable"))
					$(this).draggable("enable");
				
				if($(this).hasClass("ui-resizable"))
					$(this).resizable("enable");
				
				$("p, span, i, img", $(this)).removeClass("hide");
				
				$("iframe", $(this))
					.removeAttr("src")
					.addClass("hide");
			});
        }
		else
		{
			//console.log('on');
			$("#page").addClass("preview").droppable("disable");
			$("ul.components li").draggable("disable");
			$("#page div.modal-component, #page div.tooltip-trigger").each(function(){
				
				var componentID = $(this).attr("componentid");
				var componentName = $(this).attr("componentname");
				
				if($(this).hasClass("tooltip-trigger")) {
					$(this)
						.css('width', '52px')
						.css('height', '52px');
				}

				if($(this).hasClass("ui-draggable"))
					$(this).draggable("disable");
				
				if($(this).hasClass("ui-resizable"))
					$(this).resizable("disable");
				
				var q = "&componentid=" + componentID + "&componentname=" + componentName + "&" + $("#pagecomponents").serialize();
				
				$("p, span, i, img", $(this)).addClass("hide");
				
				$("iframe", $(this))
					.attr("src", "http://" + window.location.host + "/" + currentLanguage + "/" + route["interactivity_preview"] + '?dummy=1' + q)
					.removeClass("hide");
			});
        }
	});
}

function initFullscreen() 
{
	var target = $('#wrapper')[0]; // Get DOM element from jQuery collection
	$('.fullTrigger').click(function() {
		if (screenfull.enabled) {
			screenfull.request(target);
		}
	});
}

function toogleFullscreen()
{
	if(!getFullscreenStatus())
	{
		$('.fullTrigger').click();	
	}
	else
	{
		exitFullscreen();
	}
}

function getFullscreenStatus()
{
	return screenfull.isFullscreen;
}

function exitFullscreen()
{
	screenfull.exit();
}

function closeInteractiveIDE()
{
	if(getFullscreenStatus())
	{
		exitFullscreen();
	}
	document.location.href = "/" + currentLanguage + "/" + route["contents"] + "/" + $("#content-id").val();
}