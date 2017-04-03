(function() {
function Checkbox(element) {
    this.element = element;
}

var klass = Checkbox.prototype;
var self = Checkbox;
SCF.Checkbox = Checkbox;

klass.init = function() {
    this.bindEvents();
};

klass.bindEvents = function() {
    var _this = this;

    $(this.element).click(function() {

        $(this).toggleClass("checked");
		
		if($(this).children("input[type='hidden']").length > 0)
		{
			$(this).children("input[type='hidden']").val("");
			
			if($(this).hasClass("checked"))
			{
				$(this).children("input[type='hidden']").val("1");	
			}
		}
    });
}

}());
