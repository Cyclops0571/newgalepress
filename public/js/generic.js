/* global notification, route, sNotifications, currentLanguage */

///////////////////////////////////////////////////////////////////////////////////////
// NOTIFICATION
var sNotification = new function () {
    
    var _self = this;


    this.element = null;

    $(function () {
	_self.element = $("#myNotification");
	if (typeof (notification) === 'undefined') {
	    notification = {
		'validation': 'There are areas that need to be filled!',
		'loading': 'Loading...',
		'success': 'The operation was successful.',
		'failure': 'An error occurred while performing the operation. Please try again later.',
		'auth_interactivity': 'WARNING You do not have rights to use the Interactive PDFs!',
		'auth_max_pdf': 'Warning! PDF loading amount has expired'
	    };
	}


	if (!_self.element.length) {
	    var html = '<div class="statusbar hidden" style="background" id="myNotification">'
	    + '<div class="statusbar-icon" style="margin-left:41%"><span></span></div>'
	    + '<div class="statusbar-text">'
	    + '<span class="text"></span>'
	    + '<span class="detail"></span>'
	    + '</div>'
	    + '<div class="statusbar-close icon-remove" onclick="sNotification.hide()"></div>'
	    + '</div>';
	    $('body').append(html);
	    _self.element = $("#myNotification");
	}
    });

    this.validation = function (text, detail) {
	text = text ? text : notification["validation"];
	this.setClass("statusbar-warning");
	this.element.find("div.statusbar-icon span").removeAttr("class").addClass("icon-warning-sign");
	this.hideTexts(text, detail);
	this.show();
    };

    this.info = function (text, detail) {
	this.setClass("statusbar-info");
	this.element.find("div.statusbar-icon span").removeAttr("class").addClass("icon-info");
	this.hideTexts(text, detail);
	this.show();
    };

    this.loader = function (text, detail) {
	text = text ? text : notification["loading"];
	this.setClass("statusbar-loader");
	this.element.find("div.statusbar-icon span").removeAttr("class");
	this.hideTexts(text, detail);
	this.show();

	if (this.element.find('#galeSpinner').length === 0) {
	    var img = 'data:image/png;base64,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';
	    this.element.prepend("<img src='" + img + "' id='galeSpinner' style='position:absolute;left:10px;'>");
	}
	this.element.find('#galeSpinner').removeClass();
	this.element.find('#galeSpinner').hide();
	this.element.find('#galeSpinner').show('scale', {percent: 100}, 600);

	function animateRotate(start, end, duration, easingEffect) {
	    var object = _self.element.find('#galeSpinner');
	    $({deg: start}).animate({deg: end}, {
		duration: duration,
		easing: easingEffect,
		step: function (now) {
		    object.css({
			'-webkit-transform': "rotate(" + now + "deg)"
		    }).css({
			'-moz-transform': "rotate(" + now + "deg)"
		    }).css({
			'-ms-transform': "rotate(" + now + "deg)"
		    }).css({
			'transform': "rotate(" + now + "deg)"
		    });
		},
		complete: function () {
		    if (_self.element.hasClass("statusbar-loader"))
		    {
			animateRotate(0, 1800, 900, 'linear');
		    }
		    else if (!object.hasClass('stopAnimeOne')) {
			animateRotate(0, 720, 1000, 'easeOutQuint');
			object.addClass('stopAnimeOne');
			if (!_self.element.hasClass("statusbar-danger")) {
			    setTimeout(function () {
				_self.hide(500);
			    }, 1500);
			}
		    }
		}
	    });
	}
	animateRotate(0, 1800, 1200, 'easeInCubic');
    };

    this.success = function (text, detail) {
	text = text ? text : notification["success"];
	this.setClass("statusbar-success");
	this.element.find("div.statusbar-icon span").removeAttr("class").addClass("icon-ok");
	this.hideTexts(text, detail);
	this.show();
    };

    this.failure = function (text, detail) {
	text = text ? text : notification["failure"];
	this.setClass("statusbar-danger");
	this.element.find("div.statusbar-icon span").removeAttr("class").addClass("icon-remove");
	this.hideTexts(text, detail);
	this.show();
    };

    this.show = function () {
	if (!(this.element.hasClass("statusbar-loader") || this.element.hasClass("statusbar-success") || this.element.hasClass("statusbar-danger")) && this.element.find('#galeSpinner').length > 0) {
	    this.element.find("#galeSpinner").remove();
	}
	this.hide();
	this.element.show();
    };

    this.hide = function (v) {
	v = v ? v : 0;
	this.element.hide(v);
    };

    this.setClass = function (c) {
	this.element.removeAttr("class").addClass("statusbar").addClass(c);
    };

    this.hideTexts = function (text, detail) {
	text = text ? text : '';
	detail = detail ? detail : '';
	this.element.find("div.statusbar-text span.text").html(text);
	this.element.find("div.statusbar-text span.detail").html(detail);
    };
};

///////////////////////////////////////////////////////////////////////////////////////
// AJAX
var sAjax = new function () {

    /**
     * 
     * @param {type} url
     * @param {type} data
     * @param {type} async
     * @param {type} funcSuccess
     * @param {type} funcError
     * @param {type} requestType
     * @param {type} dataType
     * @param {type} loginCheck
     * @returns {undefined}
     */
    this.request = function(url, data, async, funcSuccess, funcError, requestType, dataType, loginCheck) {
	// show success
	//show warning
	//show error
	//redirect to a new url
	if(typeof requestType === 'undefined') {
	    requestType = 'POST';
	}
	
	//set error function
	if(typeof funcError === "undefined") {
	    funcError = function(response) {
		if(typeof response !== "undefined" && typeof response.errmsg !== "undefined") {
		    sNotification.failure(response.errmsg);
		} else {
		    sNotification.failure();
		}
	    };
	}
	
	if(typeof dataType === "undefined") {
	    dataType = "json";
	}
	
	if(typeof async === "undefined") {
	   async = true; 
	}
	
	if(loginCheck) {
	    isLoggedIn = false;
	    $.ajax({
		url: "571571571",
		async: false,
		dataType: 'json',
		success: function (response) {
		    if(typeof response !== "undefined" && response.success !== "undefined" && response.success === true) {
			isLoggedIn = true;
		    }
		},
		error: function() {
		    alert("Server Error At: " + url);
		}
	    });
	    if(!isLoggedIn) {
		document.location.href = "/";
	    }
	}
	
	$.ajax({
	    url: url,
	    data: data,
	    async: async,
	    type: requestType,
	    dataType: dataType,
	    success: function (response) {
		if(typeof response !== "undefined" && response.success !== "undefined" && response.success === true) {
		    funcSuccess(response);
		} else {
		    funcError(response);
		}
	    },
	    error: function(){
		sNotification.failure("Server Error At: " + url);
	    }
	});
	
    };
};

///////////////////////////////////////////////////////////////////////////////////////
// FORM
var sForm = new function () {
    this.bindEnterKey = function(event, func) {
	var keyCode = null;
	if (event.which) {
	    keyCode = event.which;
	} else if (event.keyCode) {
	    keyCode = event.keyCode;
	}
	if (13 == keyCode) {
	    func();
	    return false;
	}
	return true;
    };
    
    this.validate = function (formObj) {
	var ret = true;
	formObj.each(function () {
	    $("div.error", $(this)).removeClass("error");
	    $(".required", $(this)).each(function () {
		console.log($(this).attr('id'));
		if (!$(this).val()) {
		    ret = false;
		    $(this).prev().addClass("error");
		    $(this).parent().prev().addClass("error");
		}
	    });
	});
	return ret;
    };

    this.serialize = function (formObj) {
	var ret = "";
	formObj.each(function () {
	    if ($(this).is("form")) {
		ret = ret + "&" + $(this).serialize();
	    }
	});
	return ret;
    };
};

///////////////////////////////////////////////////////////////////////////////////////
// MODALFORM
var modalform = new function () {

    var modalForm;
    var contentContainer;

    this.show = function (c) {
	this.modalForm = c;
	this.contentContainer = $(".modalformcontainer", this.modalForm);
	this.contentContainer.html('<div class="loader"></div>');
	this.modalForm.removeClass("hidden");
	this.reposition();

	//show overlay window
	var overlay;
	if ($(".ui-widget-overlay").size() > 0) {
	    overlay = $(".ui-widget-overlay");
	} else {
	    $('<div></div>')
	    .addClass('ui-widget-overlay')
	    .addClass('hidden')
	    .css("z-index", "1001")
	    .appendTo("body");
	    overlay = $(".ui-widget-overlay");
	}

	overlay.css("width", $(document).width())
	.css("height", $(document).height())
	.removeClass("hidden");
    };

    this.reposition = function () {
	var t = $(window).scrollTop() + (($(window).height() - this.modalForm.height()) / 2);
	var l = ($(window).width() - this.modalForm.width()) / 2;
	this.modalForm.css({
	    left: l + "px",
	    top: t + "px"
	});
    };

    this.content = function (c) {
	this.contentContainer.html(c);
	this.reposition();
    };

    this.close = function () {
	this.modalForm.addClass("hidden");
	$(".ui-widget-overlay").addClass("hidden");
    };
};


// COMMON
var sCommon = new function () {

    this.save = function (url, fSuccess, formID) {
	if (typeof fSuccess !== 'function') {
	    fSuccess = function (response) {
            if (typeof response !== 'undefined' && typeof response.successMsg !== 'undefined') {
                sNotification.success(response.successMsg);
		} else {
		    sNotification.success();
		}
	    };
	}

	sNotification.hide();
	var frm = null;
	if (typeof formID !== 'undefined') {
	    frm = $("#" + formID);
	} else {
	    frm = $("form:first");
	}
	var validate = sForm.validate(frm);
	if (validate) {
	    sNotification.loader();

	    var d = sForm.serialize(frm);
	    var async = true;
	    sAjax.request(url, d, async, fSuccess);
	} else {
	    sNotification.validation();
	}
    };

    /**
     * Deletes from detail page then returns to the list.
     * @param {type} param
     * @param {type} deleteRoute
     * @returns {undefined}
     */
    this.erase = function (param, deleteRoute) {
	sNotification.hide();
	sNotification.loader();

	var frm = $("form:first");
	var t = 'POST';
	var u = '/' + currentLanguage + '/' + deleteRoute;
	var d = sForm.serialize(frm);
	sCommon.doAsyncRequest(t, u, d, function (ret) {
	    sNotifications.success();
	    document.location.href = '/' + currentLanguage + '/' + route[param];
	});
    };

    /**
     * Deletes from list page
     * @param {type} url
     * @param {type} id
     * @param {type} rowIDPrefix
     * @returns {undefined}
     */
    this.delete = function (url, id, rowIDPrefix) {
	sNotification.hide();
	sNotification.loader();
	var d = {id: id};
	sCommon.doAsyncRequest('GET', url, d, function (ret) {
	    $("#" + rowIDPrefix + id).remove();
	    sNotification.success();
	});
    };
};