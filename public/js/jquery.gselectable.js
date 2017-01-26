(function($){
	$.fn.gselectable = function(options) {
		
		var defaults = {
			beforeSelected: function(e) {
				//remove other selected elements
				$(".gselectable").removeClass("selected");
			}, 
			selected: function(e) {
				
			}
		};
		
		var opt = $.extend(defaults, options);

		return this.each(function(){
			
			$(this).addClass("gselectable");

			$(this).click(function(){

				if(!$(this).hasClass("selected"))
				{
					//trigger beforeSelected event
					if (opt.beforeSelected !== undefined)
					{
						opt.beforeSelected($(this));
					}
					
					//add selected class
					$(this).addClass("selected");
					
					//trigger selected event
					if (opt.selected !== undefined)
					{
						opt.selected($(this));
					}
				}
			});
		});
	};
})(jQuery);