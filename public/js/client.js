/* global sCommon, sNotification, sForm, currentLanguage */

var sClient = new function () {
    this.validatePassword = function () {
	if ($("#password").val() !== $("#confirmPassword").val()) {
	    /*alert("Passwords Don't Match");*/
	    $("#confirmMessage").css("display", "block");
	} else {
	    $("#confirmMessage").css("display", "none");

	}
    };

    this.save = function () {
	if(!myValidation()) {
	    return false;
	}
	if ($("#password").val() !== $("#confirmPassword").val()) {
	    $("#confirmMessage").css("display", "block");
	    return false;
	} else {
	    $("#confirmMessage").css("display", "none");
	}

	var fsuccess = function (response) {
        if (typeof response !== "undefined" && response.successMsg !== "undefined") {
		sNotification.success();
            document.location.href = response.successMsg;
	    }

	};
	sCommon.save('/' + currentLanguage + "/clients/clientregister", fsuccess);
    };

    this.forgotMyPassword = function () {
	if(!myValidation()) {
	    return false;
	}
	sCommon.save('/' + currentLanguage + '/clients/forgotpassword');
    };


    this.resetMyPassword = function () {
	if(!myValidation()) {
	    return false;
	}
	var fsuccess = function (response) {
        if (typeof response !== "undefined" && response.successMsg !== "undefined") {
		sNotification.success();
		//if opereation success go to login
            document.location.href = response.successMsg;
	    }

	};
	sCommon.save('/' + currentLanguage + "/clients/resetpw", fsuccess);
    };

    var myValidation = function () {
	var returnValue = true;
	$("input").each(function () {
	    if (typeof $(this).attr('name') !== "undefined") {
		var validator = "#" + $(this).attr('name') + "Validator";
		if($(validator).length) {
		    if($(this).val().length === 0) {
			$(validator).css("display", "block");
			returnValue = false;
		    } else {
			$(validator).hide();
		    }
		}
	    }
	});
	return returnValue;
    };
};