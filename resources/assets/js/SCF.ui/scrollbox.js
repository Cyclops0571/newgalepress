(function() {
function Scrollbox() {
}

var klass = Scrollbox.prototype;
var self = Scrollbox;
SCF.Scrollbox = Scrollbox;

self.init = function() {
    self.bindEvents();
};

self.bindEvents = function() {
    $(self.element).each(function() {
        // Get a default value for all bars
        var scaleInitialWidth = $(this).find(self.scale).width();
        var scrollboxWidth = $(this).find(self.hitbox).width();
		var maxPercentage = 200;
		
        // Slider mechanics
        $(this).find(self.hitbox).slider({
            slide: function(event, ui){
				
                var scaleWidth = ui.value;
				var percentage = scaleWidth / scrollboxWidth * maxPercentage;
				
                $(this).next(self.scale).css({
                    'width': scaleWidth
                });
				
				$(this).nextAll(self.value).html(percentage.toFixed(0) + '%');
            },
            max: scrollboxWidth,
            value: scaleInitialWidth
        });
    });
};

// vars
self.element = ".js-scrollbox";
self.scale = ".scale";
self.hitbox = ".hitbox";
self.value = ".value";

}());
