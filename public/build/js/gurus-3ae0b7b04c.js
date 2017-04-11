String.prototype.replaceAll = function (target, replaced) {
	var s = this;
    /*
    var indexOfMatch = s.indexOf(target);
    while (indexOfMatch != -1){
		s = s.replace(target, replaced)
		indexOfMatch = s.indexOf(target);
    }
    */
    //s = s.replace(/target/g, replaced)
	s = s.replace(new RegExp(target, 'g'), replaced);
    return(s);
}

String.prototype.startsWith = function(str) {
	return (this.match("^"+str)==str);
}

String.prototype.endsWith = function(str) {
	return (this.match(str+"$")==str);
}

String.prototype.trim = function(){
	return (this.replace(/^[\s\xA0]+/, "").replace(/[\s\xA0]+$/, ""));
}

String.prototype.getDate = function (inputFormat, outputFormat) {
    ret = "";
    var yr = "";
    var mn = "";
    var dy = "";

    if (inputFormat == "dd.mm.yyyy") {
        
        var arr = this.split(".");
        yr = arr[2];
        mn = arr[1];
        dy = arr[0];

        if (outputFormat == "yyyy-mm-dd") {
            ret = yr + "-" + mn + "-" + dy;
        }
    }
    return ret;
}

String.prototype.getValue = function (key, base64) {
    ret = "";
    base64 = (typeof base64 == "undefined") ? false : base64
    var a = this.split("&");
    for (var i = 0; i < a.length; i++) {
        var pair = a[i].split("=");
        if (pair[0] == key) {
            var val = a[i].replaceAll(pair[0] + "=", "");
            if (base64) {
                //console.log("val = " + val);
                ret = $.base64Decode(val);
                //ret = Base64.decode(val);
                //console.log("ret = " + ret);
                //ret = val;
            }
            else {
                ret = val;
                //ret = pair[1];
            }
            break;
        }
    }
    return ret;
}

String.prototype.toQS = function(){
	if(this.trim().length > 0) {
		return "&" + this;
	}
	return this;
}









///////////////////////////////////////////////////////////////////////////////////////
// COMMON FUNCTIONS
function roundIt(number) {
    var ret = number;
    ret = Math.round(ret * 100) / 100;
    ret = Math.round(ret * 10) / 10;
    ret = Math.round(ret);
    return ret;
}

function getQS(ji) {
    hu = window.location.search.substring(1);
    gy = hu.split("&");
    for (i = 0; i < gy.length; i++) {
        ft = gy[i].split("=");
        if (ft[0] == ji) {
            return ft[1];
        }
    }
    return "";
}

function validateAlphaNumeric(s) {

    for (var i = 0; i < s.length; i++) {
        var cc = s.charAt(i).charCodeAt(0);

        if ((cc > 47 && cc < 58) || (cc > 64 && cc < 91) || (cc > 96 && cc < 123)) {
            //return true;
        }
        else {
            //alert('Input is not alphanumeric');
            return false;
        }
    }
    return true;
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.search);
    if (results == null)
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function checkURL(value) {
    /*
     var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
     if (urlregex.test(value)) {
     return (true);
     }
     return (false);
     */
    return true;
}

function isUrlReachable(url) {
    if (checkURL(url)) {
        var d = "url=" + encodeURIComponent(url);
        //this request is send to galepress to check if the url is reacheable
        var ret = $.ajax({
            async: false,
            type: "POST",
            url: '/' + currentLanguage + '/' + route["interactivity_check"],
            data: d,
            error: function (ret) {
                alert(ret);
            }
        }).responseText;
        if (ret) {
            return true;
        }
    }
    return false;
}

function getTransform(e) {
    var t = e.css("transform");
    return t.substr(7, t.length - 8).split(', ');
}

function getScale() {
    var e = $("#page");
    var arr = getTransform(e);
    return parseFloat(arr[0]);
}

function getTransformTranslateX(e) {
    var arr = getTransform(e);
    return parseFloat(arr[4]);
}

function getTransformTranslateY(e) {
    var arr = getTransform(e);
    return parseFloat(arr[5]);
}

function getWidth(e) {
    var r = e.css("width").replace("px", "");
    return parseFloat(r);
}

function getHeight(e) {
    var r = e.css("height").replace("px", "");
    return parseFloat(r);
}


function fixWidth(e, w) {
    var arr = getTransform(e);
    if (false) {

    }


    return parseFloat(arr[5]);
}

function fixHeight(e, h) {

    var arr = getTransform(e);
    return parseFloat(arr[5]);
}

function fixLeft(e, x) {
    var eX = getTransformTranslateX(e);

    return parseFloat(arr[5]);
}

function fixTop(e, y) {
    var eY = getTransformTranslateY(e);

    return parseFloat(arr[5]);
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};



















Date.prototype.format = function (format) {
    var d = "";
    var that = new Date();
    var currYear = that.getFullYear().toString();
    var currMonth = (that.getMonth() + 1).toString(); //months are zero based
    var currDay = that.getDate().toString();
    var currHour = that.getHours().toString();
    var currMinute = that.getMinutes().toString();

    if (currMonth.length == 1) currMonth = "0" + currMonth;
    if (currDay.length == 1) currDay = "0" + currDay;
    if (currHour.length == 1) currHour = "0" + currHour;
    if (currMinute.length == 1) currMinute = "0" + currMinute;

    if (format == "dd.mm.yyyy hh:mm") {
        d = currDay + "." + currMonth + "." + currYear + " " + currHour + ":" + currMinute;
    }
    else if (format == "dd.mm.yyyy") {
        d = currDay + "." + currMonth + "." + currYear;
    }
    else if (format == "mm.yyyy") {
        d = currMonth + "." + currYear;
    }
    else if (format == "yyyy-mm-dd hh:mm") {
        d = currYear + "-" + currMonth + "-" + currDay + " " + currHour + ":" + currMinute;
    }
    else if (format == "yyyy-mm-dd") {
        d = currYear + "-" + currMonth + "-" + currDay;
    }
    else if (format == "hh:mm") {
        d = currHour + ":" + currMinute;
    }
    return d;
}
/* global route, currentLanguage */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})


///////////////////////////////////////////////////////////////////////////////////////
// USER
var cUser = new function () {
    this.objectName = "users";
    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    };

    this.go2Login = function () {
        window.location.href = "/";
    };

    this.loginEvent = function (evt, func) {
        var keyCode = null;
        if (evt.which) {
            keyCode = evt.which;
        } else if (evt.keyCode) {
            keyCode = evt.keyCode;
        }
        if (13 == keyCode) {
            func();
            return false;
        }
        return true;
    };

    this.login = function () {
        cNotification.hide();

        var frm = $("form:first");
        var validate = cForm.validate(frm);
        if (validate) {

            cNotification.loader();
            var d = new Date();
            var localTime = "&LocalTime=" + d.getTime() / 1000;
            var t = 'POST';
            var u = '/' + currentLanguage + '/' + route["login"];
            var data = cForm.serialize(frm) + localTime;

            cUser.doAsyncRequest(t, u, data, function (ret) {
                cNotification.success(null, ret.getValue("msg"));
                var redirectUrl = '/' + currentLanguage + '/' + route["home"];
                if ($.cookie('gobacktoshop') == 'gobacktoshop') {
                    redirectUrl = '/' + currentLanguage + '/' + route["shop"];
                }

                if (window.top != window) {
                    window.top.location.href = redirectUrl;
                } else {
                    window.location.href = redirectUrl;
                }
            });

        } else {
            cNotification.validation();
        }
    };

    this.forgotMyPassword = function () {

        cNotification.hide();

        var frm = $("form:first");
        var validate = cForm.validate(frm);
        if (validate) {

            cNotification.loader();

            var t = 'POST';
            var u = '/' + currentLanguage + '/' + route["forgotmypassword"];
            var d = cForm.serialize(frm);
            cUser.doAsyncRequest(t, u, d, function (ret) {
                cNotification.success(null, ret.getValue("msg"));
                setTimeout(function () {
                    window.location = '/' + currentLanguage + '/' + route["login"];
                }, 1000);
            });
        } else {
            cNotification.validation();
        }
    };

    this.resetMyPassword = function () {

        cNotification.hide();

        var frm = $("form:first");
        var validate = cForm.validate(frm);
        if (validate) {

            cNotification.loader();

            var t = 'POST';
            var u = '/' + currentLanguage + '/' + route["resetmypassword"];
            var d = cForm.serialize(frm);
            cUser.doAsyncRequest(t, u, d, function (ret) {
                cNotification.success(null, ret.getValue("msg"));
            });
        } else {
            cNotification.validation();
        }
    };

    this.saveMyDetail = function () {

        cNotification.hide();

        var frm = $("form:first");
        var validate = cForm.validate(frm);
        if ($("#Password").val() != $("#Password2").val()) {
            validate = false;
        }
        if (validate) {

            cNotification.loader();

            var t = 'POST';
            var u = '/' + currentLanguage + '/' + route["mydetail"];
            var d = cForm.serialize(frm);
            cUser.doAsyncRequest(t, u, d, function (ret) {
                cNotification.success();
            });
        } else {
            cNotification.validation();
        }
    };

    this.save = function () {
        cCommon.save(
            this.objectName,
            function () {
                cNotification.success();
                window.location = '/' + currentLanguage + '/' + route["users"];
            }
        );
    };

    this.erase = function () {
        cCommon.erase(this.objectName);
    };

    this.sendNewPassword = function () {

        cNotification.hide();

        var frm = $("form:first");
        var validate = cForm.validate(frm);
        if (validate) {

            cNotification.loader();

            var t = 'POST';
            var u = '/' + currentLanguage + '/' + route["users_send"];
            var d = cForm.serialize(frm);
            cUser.doAsyncRequest(t, u, d, function (ret) {
                cNotification.success();
            });
        } else {
            cNotification.validation();
        }
    };
};

///////////////////////////////////////////////////////////////////////////////////////
// CUSTOMER
var cCustomer = new function () {
    this.objectName = "customers";

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    };

    this.loadCustomerOptionList = function () {

        var t = 'GET';
        var u = '/' + currentLanguage + '/' + route["customers"];
        var d = "option=1";
        cCustomer.doAsyncRequest(t, u, d, function (ret) {
            $("#ddlCustomer").html(ret).trigger('chosen:updated');
        });
    };

    this.CustomerOnChange = function (obj) {
        cReport.OnChange(obj);
        cApplication.loadApplicationOptionList();
    };

    this.save = function () {
        cCommon.save(this.objectName,
            function () {
                cNotification.success();
                window.location = '/' + currentLanguage + '/' + route["customers"];
            }
        );
    };

    this.erase = function () {
        cCommon.erase(this.objectName);
    };
};

///////////////////////////////////////////////////////////////////////////////////////
// APPLICATION
var cApplication = new function () {
    this.objectName = "applications";

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    };

    this.loadApplicationOptionList = function () {

        var t = 'GET';
        var u = '/' + currentLanguage + '/' + route["applications"];
        var d = "customerID=" + $("#ddlCustomer").val() + "&option=1";
        cApplication.doAsyncRequest(t, u, d, function (ret) {
            $("#ddlApplication").html(ret);
            $('#ddlApplication').trigger('chosen:updated');
        });
    };

    this.ApplicationOnChange = function (obj) {
        cReport.OnChange(obj);
        cContent.loadContentOptionList();
    };

    this.save = function () {
        cCommon.save(
            this.objectName,
            function () {
                cNotification.success();
                window.location = '/' + currentLanguage + '/' + route["applications"];
            }
        );
    };

    this.erase = function () {
        cCommon.erase(this.objectName);
    };

    this.pushNotification = function () {
        cNotification.hide();
        var frm = $("#formPushNotification");
        var applicationID = parseInt($("[name='ApplicationID']", frm).val());
        var url = '/' + currentLanguage + '/' + route["applications_pushnotification"];
        url = url.replace('(:num)', applicationID);
        var validate = cForm.validate(frm);
        if (validate) {
            cNotification.loader();
            var t = 'POST';
            var d = cForm.serialize(frm);
            cApplication.doAsyncRequest(t, url, d, function (ret) {
                $('#modalPushNotification').modal('hide');
                cNotification.success();
            });
        }
        else {
            cNotification.validation();
        }
    };

    this.saveUserSettings = function () {
        var warningText = "";
        $(".tabActiveCheck").each(function (index) {
            if ($(".inhouseUrl:eq(" + index + ")")[0].selectedIndex == 0 && $(".tabActiveCheck:eq(" + index + ")").attr('checked') == 'checked' && $(".targetUrlCount:eq(" + index + ")").val().length == 0) {
                warningText += 'Tab ' + (index + 1) + ' ';
            }
        });

        if (warningText != "") {
            $('#dialog-tab-active-warning .modal-body').text(warningText + ': [[innerText]]');
            $('#dialog-tab-active-warning').modal('show');
            return;
        }
        else {
            $(".targetUrlCount").each(function (index) {
                if (!$(this).parent().next().hasClass('hide') && $(".tabActiveCheck:eq(" + index + ")").attr('checked') == 'checked' && $(".inhouseUrl:eq(" + index + ")")[0].selectedIndex == 0) {
                    $('#dialog-tab-active-warning .modal-body').text('Tab ' + (index + 1) + ': [[innerText]]');
                    $('#dialog-tab-active-warning').modal('show');
                    warningText = "not";

                }
                else if (!$(this).val().match(/^[a-zA-Z]+:\/\//)) {
                    $(this).val('http://' + $(this).val());
                }
            });
        }

        if (warningText == "") {
            cCommon.save('application_usersettings',
                function () {
                    cNotification.success();
                    window.location = '/' + currentLanguage + '/' + route["application_setting"].replace('{application}', $('input[name=ApplicationID]').val());
                }
            );
        }
    };

    this.selectedIcon = function (tabNo) {
        $('#selectedIcon_' + tabNo).popover({
            container: 'body',
            html: true,
            content: function () {
                var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
                return clone;
            }
        }).click(function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
        $('.myIconClass_' + tabNo + ' li button').click(function (e) {
            var src = $(this).find('img').attr('src');
            $('input[name=hiddenSelectedIcon_' + tabNo + ']').val(src);
            $('#imgSelectedIcon_' + tabNo).attr('src', src);
            e.preventDefault();
            e.stopPropagation();
        });
        $(document).click(function (e) {
            $('#selectedIcon_' + tabNo).popover('hide');
            $('.popover').remove();
        });
    };

    this.InhouseUrlChange = function (e) {
        if (e.selectedIndex != 0) {
            $(e).parent().closest('.form-row').next().addClass('hide').addClass('noTouchOpacity');
            $(e).parent().closest('.form-row').next().find('input').val('');

        }
        else {
            $(e).parent().closest('.form-row').next().removeClass('hide').removeClass('noTouchOpacity');
        }
    };
    this.checkUrl = function (e) {
        var url = $(e).parent().prev().val();
        if (url.length === 0) {
            $(e).parent().parent().next().addClass("hide");
            $(e).css('background-color', '#2e2e2e');
            // $(e).closest('.form-row').next().find('.col-md-8').removeClass('noTouchOpacity');
        } else {
            if (!isUrlReachable(url)) {
                $(e).css('background', '#9d0000');
                $(e).parent().parent().next().removeClass("hide");
                // $(e).closest('.form-row').next().find('.col-md-8').addClass('noTouchOpacity');
            } else {
                $(e).parent().parent().next().addClass("hide");
                $(e).css('background', '#59AD2F');
                $(e).css('color', '#fff');
                // $(e).closest('.form-row').next().find('.col-md-8').addClass('noTouchOpacity');
            }
        }
    };

    this.setSelectInputActive = function () {
        $(".inhouseUrl").each(function (index) {
            if ($(this).val() != 0) {
                $(".targetUrlCount:eq(" + index + ")").closest('.form-row').addClass('hide').addClass('noTouchOpacity');
            }
            else {
                $(".targetUrlCount:eq(" + index + ")").closest('.form-row').removeClass('hide').removeClass('noTouchOpacity');
            }
        });
    };

    this.checkTabStatus = function () {
        var obj = $("#TabActive");
        if (obj.is(':checked')) {
            obj.closest('.form-row').nextAll().removeClass('noTouchOpacity');
        } else {
            obj.closest('.form-row').nextAll().addClass('noTouchOpacity');
        }
    };

    this.checkShowDashboard = function () {
        var obj = $("#ShowDashboard");
        if (obj.is(':checked')) {
            obj.closest('.form-row').nextAll().removeClass('noTouchOpacity');
        } else {
            obj.closest('.form-row').nextAll().addClass('noTouchOpacity');
        }
    }

    this.BannerActive = function () {
        var obj = $("#BannerActive");
        if ($('#BannerActive').prop('checked')) {
            obj.closest('.form-row').nextAll().removeClass('noTouchOpacity');
        } else {
            obj.closest('.form-row').nextAll().addClass('noTouchOpacity');
        }
        $('#BannerActive').change(function () {
            var obj = $("#BannerActive");
            if ($('#BannerActive').prop('checked')) {
                obj.closest('.form-row').nextAll().removeClass('noTouchOpacity');
            } else {
                obj.closest('.form-row').nextAll().addClass('noTouchOpacity');
            }
        });
    };

    this.BannerCustomerActive = function () {
        var obj = $("#BannerCustomerActive");
        if (obj.is(":checked")) {
            obj.closest('.form-row').nextAll().addClass('noTouchOpacity');
            $("input[name='BannerCustomerUrl']").removeClass('noTouchOpacity');
        } else {
            $("input[name='BannerCustomerUrl']").addClass('noTouchOpacity');
            obj.closest('.form-row').nextAll().removeClass('noTouchOpacity');
        }
    };

    this.refreshSubscriptionIdentifier = function (AppID, SubscriptionType) {
        cNotification.loader();
        cAjax.doAsyncRequest("POST", '/applications/refresh_identifier',
            {"ApplicationID": AppID, "SubscrioptionType": SubscriptionType},
            function (ret) {
                $("#SubscriptionIdenfier_" + SubscriptionType).val(ret.getValue("SubscriptionIdentifier"));
                cNotification.success();
            },
            undefined,
            false);
    };

    // this.checkHoverBlock = function () {
    //    	$('.block:eq(1)').hover(
    // 	  function() {
    // 	  	$('.screen *').css('opacity',0.80);
    // 	  	$('.screen .templateScreen, .screen .templateScreen .container, .screen .templateScreen .container .form-row:first').css('opacity',1);
    // 	    $('.screen .templateScreen .ms-gallery-template,.screen .templateScreen .ms-gallery-template *').css('opacity',1);
    // 	  }, function() {
    // 	    $('.screen *').css('opacity',1);
    // 	  }
    // 	);
    // };

};

///////////////////////////////////////////////////////////////////////////////////////
// CONTENT
var cContent;
cContent = new function () {
    var _self = this;
    this.objectName = "contents";
    this.doRequest = function (t, u, d, funcError) {
        return cAjax.doSyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcError);
    };

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    };

    this.loadContentOptionList = function () {
        var t = 'GET';
        var u = '/' + currentLanguage + '/' + route["contents"];
        var d = "applicationID=" + $("#ddlApplication").val() + "&option=1";
        cContent.doAsyncRequest(t, u, d, function (ret) {
            var ddlContent = $("#ddlContent");
            ddlContent.html(ret);
            ddlContent.trigger('chosen:updated');
        });
    };

    this.ContentOnChange = function (obj) {
        cReport.OnChange(obj);
    };

    this.checkInteractivityStatus = function (contentFileID, element, text) {
        var t = 'POST';
        var u = '/' + currentLanguage + '/' + route['contents_interactivity_status'];
        var d = "contentFileID=" + contentFileID;
        var loopAgain = true;
        var ajaxReq = function() {
            $.ajax({
                type: t,
                url: u,
                data: d,
                dataType: 'json',
                /**
                 *
                 * @param {{errmsg: string, success:boolean, successMsg:string }} ret
                 */
                success: function (ret) {
                    if(ret.success) {

                        $(element).removeClass("progress-striped active")
                        $(element).find(".progress-bar").text(text);
                    } else {
                        setTimeout(ajaxReq, 1000);
                    }
                },
                error: function (ret) {
                    cNotification.failure(ret.errmsg);
                }
            });
        }
        ajaxReq();
    }

    this.save = function () {
        if (!$("#IsMaster").is(':checked') && $("#IsProtected").is(':checked')) {
            var t = 'GET';
            var u = '/' + currentLanguage + '/' + route["contents_passwords"];
            var d = "contentID=" + $("#ContentID").val() + '&type=qty';
            var ret = cContent.doRequest(t, u, d);
            if (parseInt(ret) > 0) {
                $("#Password").removeClass("required");
            } else {
                $("#Password").addClass("required");
            }
        }

        if (!$('#CategoryID_chosen').find('ul.chosen-choices li').hasClass('search-choice')) {
            $('#dialog-category-warning').modal('show');
            return;
        }

        cCommon.save(
            this.objectName,
            function (ret) {
                var contentID = ret.getValue("contentID");
                cNotification.success();
                window.location.href = '/' + currentLanguage + '/' + route[_self.objectName] + '/' + contentID;
            }
        );
    };

    this.erase = function () {
        cCommon.erase(this.objectName);
    };

    this.removeFromMobile = function (id) {
        console.log(route[_self.objectName]);
        cNotification.hide();
        cNotification.loader();
        var url = '/' + currentLanguage + '/contents/remove_from_mobile/' + id;
        var d = [];
        cCommon.doAsyncRequest('GET', url, d, function () {
            cNotification.success();
            var qs = cCommon.getQS(); //get query string
            window.location = '/' + currentLanguage + '/' + route[_self.objectName] + qs;
        });
    };

    this.openInteractiveIDE = function () {
        cNotification.loader();
        $('#btn_interactive').addClass('on');
    };

// Bu fonks. explorer 10 da iframe kapattığı için interactivity->html.blade body tagından kaldırıldı.
    this.closeInteractiveIDE = function () {
        var iframe = $("iframe#interactivity");
        if (iframe.css("display") == "block") {
            $(".loader").addClass("hidden");
            $("html").css("overflow", "scroll");
            iframe
                .attr("src", "")
                .css("display", "none");

            if (getFullscreenStatus()) {
                exitFullscreen();
            }

            setTimeout(function () {
                $('#btn_interactive').removeClass('on');
            }, 2000);
        }
    };

    this.showCategoryList = function () {
        $("div.list_container").removeClass("hidden");
        $("div.cta_container").removeClass("hidden");
        $("div.form_container").addClass("hidden");
        cContent.loadCategoryList();
        $("#dialog-category-form").removeClass("hidden").modal('show');
    };

    this.loadCategoryList = function () {
        var t = 'GET';
        var u = '/' + currentLanguage + '/' + route["categories"];
        var d = "appID=" + $("#ApplicationID").val();
        cContent.doAsyncRequest(t, u, d, function (ret) {
            $("#dialog-category-form").find('table tbody').html(ret);
        });
    };

    this.loadCategoryOptionList = function () {
        var t = 'GET';
        var u = '/' + currentLanguage + '/' + route["categories"];
        var d = "appID=" + $("#ApplicationID").val() + '&contentID=' + $("#ContentID").val() + '&type=options';
        cContent.doAsyncRequest(t, u, d, function (ret) {
            $("#CategoryID").html(ret).trigger("chosen:updated");
        });
    };

    this.addNewCategory = function () {
        var appID = $("#ApplicationID").val();
        $("#CategoryCategoryID").val("0");
        $("#CategoryApplicationID").val(appID);
        $("#CategoryName").val("");
        $("div.list_container").addClass("hidden");
        $("div.cta_container").addClass("hidden");
        $("div.form_container").removeClass("hidden");
    };

    this.modifyCategory = function (id) {
        var appID = $("#ApplicationID").val();
        var name = $("#category" + id + " td:eq(0)").html();
        $("#CategoryCategoryID").val(id);
        $("#CategoryApplicationID").val(appID);
        $("#CategoryName").val(name);
        $("div.list_container").addClass("hidden");
        $("div.cta_container").addClass("hidden");
        $("div.form_container").removeClass("hidden");
    };

    this.deleteCategory = function (id) {
        var t = 'POST';
        var u = '/' + currentLanguage + '/' + route["categories_delete"];
        var d = "CategoryID=" + id;
        cContent.doAsyncRequest(t, u, d, function () {
            cContent.loadCategoryList();
            cContent.loadCategoryOptionList();
        });
    };

    this.saveCategory = function () {
        cNotification.hide();
        var frm = $("#dialog-category-form").find('form:first');
        var validate = cForm.validate(frm);
        if (validate) {
            cNotification.loader();
            var t = 'POST';
            var u = '/' + currentLanguage + '/' + route["categories_save"];
            var d = cForm.serialize(frm);
            cContent.doAsyncRequest(t, u, d, function () {
                $("div.list_container").removeClass("hidden");
                $("div.cta_container").removeClass("hidden");
                $("div.form_container").addClass("hidden");
                cContent.loadCategoryList();
                cContent.loadCategoryOptionList();
                cNotification.hide();
            });
        } else {
            cNotification.validation();
        }
    };

    //Content password
    this.showPasswordList = function () {
        $("div.list_container").removeClass("hidden");
        $("div.cta_container").removeClass("hidden");
        $("div.form_container").addClass("hidden");
        cContent.loadPasswordList();
        $("#dialog-password-form").removeClass("hidden").modal('show');
    };

    this.loadPasswordList = function () {
        var t = 'GET';
        var u = '/' + currentLanguage + '/' + route["contents_passwords"];
        var d = "contentID=" + $("#ContentID").val();
        cContent.doAsyncRequest(t, u, d, function (ret) {
            $("#dialog-password-form").find('table tbody').html(ret);
        });
    };

    this.addNewPassword = function () {
        var contentID = $("#ContentID").val();
        $("#ContentPasswordID").val("0");
        $("#ContentPasswordContentID").val(contentID);
        $("#ContentPasswordName").val("");
        $("#ContentPasswordPassword").val("");
        $("#ContentPasswordQty").val("1");
        $("div.list_container").addClass("hidden");
        $("div.cta_container").addClass("hidden");
        $("div.form_container").removeClass("hidden");
    };

    this.modifyPassword = function (id) {
        var contentID = $("#ContentID").val();
        var name = $("#contentpassword" + id + " td:eq(0)").html();
        var qty = $("#contentpassword" + id + " td:eq(1)").html();
        $("#ContentPasswordID").val(id);
        $("#ContentPasswordContentID").val(contentID);
        $("#ContentPasswordName").val(name);
        $("#ContentPasswordPassword").val("");
        $("#ContentPasswordQty").val(qty);
        $("div.list_container").addClass("hidden");
        $("div.cta_container").addClass("hidden");
        $("div.form_container").removeClass("hidden");
    };

    this.deletePassword = function (id) {
        var t = 'POST';
        var u = '/' + currentLanguage + '/' + route["contents_passwords_delete"];
        var d = "ContentPasswordID=" + id;
        cContent.doAsyncRequest(t, u, d, function () {
            cContent.loadPasswordList();
        });
    };

    this.savePassword = function () {
        cNotification.hide();
        var frm = $("#dialog-password-form").find('form:first');
        var validate = cForm.validate(frm);
        if (validate) {
            cNotification.loader();
            var t = 'POST';
            var u = '/' + currentLanguage + '/' + route["contents_passwords_save"];
            var d = cForm.serialize(frm);
            cContent.doAsyncRequest(t, u, d, function () {
                $("div.list_container").removeClass("hidden");
                $("div.cta_container").removeClass("hidden");
                $("div.form_container").addClass("hidden");
                cContent.loadPasswordList();
                cNotification.hide();
            });
        } else {
            cNotification.validation();
        }
    };

    this.giveup = function () {
        $("div.list_container").removeClass("hidden");
        $("div.cta_container").removeClass("hidden");
        $("div.form_container").addClass("hidden");
    };

    this.addFileUpload = function () {
        $("#File").fileupload({
            url: '/' + currentLanguage + '/' + route["contents_uploadfile"],
            dataType: 'json',
            sequentialUploads: true,
            formData: {
                'element': 'File'
            },
            add: function (e, data) {
                if (/\.(pdf)$/i.test(data.files[0].name)) {
                    $("input[name='save']").attr('disabled', 'disabled');
                    $('#hdnFileSelected').val("1");
                    var $forFile = $("#FileProgress");
                    $forFile.removeClass("hide");
                    data.context = $forFile;
                    data.context.find('a').click(function (e) {
                        e.preventDefault();
                        data = $forFile.data('data') || {};
                        if (data.jqXHR) {
                            data.jqXHR.abort();
                        }
                    });
                    var xhr = data.submit();
                    data.context.data('data', {jqXHR: xhr});
                }
            },
            progressall: function (e, data) {
                var progress = data.loaded / data.total * 100;
                var $forFile = $("#FileProgress");
                $forFile.find('label').html(progress.toFixed(0) + '%');
                $forFile.find('div.scale').css('width', progress.toFixed(0) + '%');
            },
            done: function (e, data) {
                if (data.textStatus == 'success') {
                    var fileName = data.result.fileName;
                    var imageFile = data.result.imageFile;

                    $('#hdnFileName').val(fileName);
                    $("#FileProgress").addClass("hide");

                    $('#hdnCoverImageFileSelected').val("1");
                    $('#hdnCoverImageFileName').val(imageFile);
                    $('#imgPreview').attr("src", "/files/temp/" + imageFile);

                    $("div.rightbar").removeClass("hidden");

                    //auto save
                    if (parseInt($("#ContentID").val()) > 0) {
                        cContent.save();
                    } else {
                        $("input[name='save']").removeAttr('disabled');
                    }
                }
            },
            fail: function () {
                $("#FileProgress").addClass("hide");
            }
        });

        //select file
        $("#FileButton").removeClass("hide").click(function () {
            $("#File").click();
        });
    };

    this.addImageUpload = function () {
        var $CoverImageFile = $("#CoverImageFile");
        $CoverImageFile.fileupload({
            url: '/' + currentLanguage + '/' + route["contents_uploadcoverimage"],
            dataType: 'json',
            sequentialUploads: true,
            formData: {
                'element': 'CoverImageFile'
            },
            add: function (e, data) {
                if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name)) {
                    $('#hdnCoverImageFileSelected').val("1");
                    var $forCoverImageFile = $("#CoverImageFileProgress");
                    $forCoverImageFile.removeClass("hide");

                    data.context = $forCoverImageFile;
                    data.context.find('a').click(function (e) {
                        e.preventDefault();
                        data = $forCoverImageFile.data('data') || {};
                        if (data.jqXHR) {
                            data.jqXHR.abort();
                        }
                    });
                    var xhr = data.submit();
                    data.context.data('data', {jqXHR: xhr});
                }
            },
            progressall: function (e, data) {
                var progress = data.loaded / data.total * 100;
                var $forCoverImageFile = $("#CoverImageFileProgress");
                $forCoverImageFile.find("label").html(progress.toFixed(0) + '%');
                $forCoverImageFile.find('div.scale').css('width', progress.toFixed(0) + '%');
            },
            done: function (e, data) {
                if (data.textStatus == 'success') {
                    //var fileName = data.result['CoverImageFile'][0].name;
                    var fileName = data.result.fileName;

                    $('#hdnCoverImageFileName').val(fileName);
                    $('#imgPreview').attr("src", "/files/temp/" + fileName);
                    $("#CoverImageFileProgress").addClass("hide");

                    //auto save
                    if (parseInt($("#ContentID").val()) > 0) {
                        cContent.save();
                    }
                }
            },
            fail: function () {
                $("#CoverImageFileProgress").addClass("hide");
            }
        });

        //select file
        $("#CoverImageFileButton").removeClass("hide").click(function () {
            $("#CoverImageFile").click();
        });
    };

    this.copy = function () {
        cNotification.loader();
        setTimeout(function () {
            var appID = $("#ApplicationID").val();
            var contentID = $("#ContentID").val();
            $.ajax({
                async: true,
                type: 'GET',
                url: '/copy/' + contentID + '/' + 'new',
                success: function (response) {
                    // console.log(response);
                    cNotification.success();
                    window.location = '/' + currentLanguage + '/' + route["contents"] + '?applicationID=' + appID;
                }
            });
        }, 1000);
    };

    this.copyInteractivity = function () {
        cNotification.loader();
        setTimeout(function () {
            var appID = $("#ApplicationID").val();
            var contentID = $("#ContentID").val();
            var targetContentID = $("#AppContents").find('option:selected').val();
            if (targetContentID != "") {
                $.ajax({
                    async: true,
                    type: 'GET',
                    url: '/copy/' + contentID + '/' + targetContentID,
                    success: function (response) {
                        // console.log(response);
                        cNotification.success();
                        window.location = '/' + currentLanguage + '/' + route["contents"] + '?applicationID=' + appID;
                    }
                });
            }
            else {
                $('#dialog-target-content-warning').modal('show');
                cNotification.hide();
            }
        }, 1000);
    };

    this.refreshIdentifier = function (contentID) {
        cNotification.loader();
        cAjax.doAsyncRequest("POST", '/contents/refresh_identifier',
            {"ContentID": contentID},
            function (ret) {
                $("#ContentIdenfier").val(ret.getValue("SubscriptionIdentifier"));
                cNotification.success();
            },
            undefined,
            false);
    };
};

///////////////////////////////////////////////////////////////////////////////////////
// ORDER
var cOrder = new function () {
    this.objectName = "orders";
    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    };

    this.save = function () {

        cCommon.save(this.objectName);
    };

    this.erase = function () {
        cCommon.erase(this.objectName);
    };
};

///////////////////////////////////////////////////////////////////////////////////////
// REPORT
var cReport = new function () {
    this.objectName = "reports";

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    };

    this.getParameters = function () {
        var param = "";
        param = param + "&sd=" + $("#start-date").val();
        param = param + "&ed=" + $("#end-date").val();
        param = param + "&customerID=" + $("#ddlCustomer").val();
        param = param + "&applicationID=" + $("#ddlApplication").val();
        param = param + "&contentID=" + $("#ddlContent").val();
        param = param + "&country=" + $("#ddlCountry").val();
        param = param + "&city=" + $("#ddlCity").val();
        param = param + "&district=" + $("#ddlDistrict").val();
        return param;
    };

    this.CountryOnChange = function (obj) {
        cReport.loadCityOptionList();
    };

    this.CityOnChange = function (obj) {
        cReport.loadDistrictOptionList();
    };

    this.loadCountryOptionList = function () {
        var t = 'GET';
        var u = '/' + currentLanguage + '/' + route["reports_location_country"];
        var d = "customerID=" + $("#ddlCustomer").val() + "&applicationID=" + $("#ddlApplication").val() + "&contentID=" + $("#ddlContent").val();
        cReport.doAsyncRequest(t, u, d, function (ret) {
            $("#ddlCountry").html(ret);
            $('#ddlCountry').change();
            $('#ddlCountry').trigger('chosen:updated');
        });
    };

    this.loadCityOptionList = function () {
        var t = 'GET';
        var u = '/' + currentLanguage + '/' + route["reports_location_city"];
        var d = "customerID=" + $("#ddlCustomer").val() + "&applicationID=" + $("#ddlApplication").val() + "&contentID=" + $("#ddlContent").val() + "&country=" + $("#ddlCountry").val();
        cReport.doAsyncRequest(t, u, d, function (ret) {
            $("#ddlCity").html(ret);
            $('#ddlCity').change();
            $('#ddlCity').trigger('chosen:updated');
        });
    };

    this.loadDistrictOptionList = function () {
        var t = 'GET';
        var u = '/' + currentLanguage + '/' + route["reports_location_district"];
        var d = "customerID=" + $("#ddlCustomer").val() + "&applicationID=" + $("#ddlApplication").val() + "&contentID=" + $("#ddlContent").val() + "&country=" + $("#ddlCountry").val() + "&city=" + $("#ddlCity").val();
        cReport.doAsyncRequest(t, u, d, function (ret) {
            $("#ddlDistrict").html(ret);
            $('#ddlDistrict').trigger('chosen:updated');
        });
    };

    this.OnChange = function (obj) {
        var param = this.getParameters();

        $("a.report-button").each(function () {

            var baseAddress = $(this).attr("baseAddress");

            $(this).attr("href", baseAddress + param);
        });
    };

    this.refreshReport = function () {
        var param = this.getParameters();
        var url = "/" + currentLanguage + "/" + route["reports"] + "/" + $("#report").val() + "?dummy=1" + param;
        this.setIframeUrl(url);
        cNotification.loader();
    };

    this.downloadAsExcel = function () {
        var param = this.getParameters();
        window.open("/" + currentLanguage + "/" + route["reports"] + "/" + $("#report").val() + "?xls=1" + param);
    };

    this.viewOnMap = function () {
        var param = this.getParameters();
        var url = "/" + currentLanguage + "/" + route["reports"] + "/" + $("#report").val() + "?map=1" + param;
        this.setIframeUrl(url);
    };

    this.setIframeUrl = function (src) {
        $("iframe").load(function () {
            var h = $(this).contents().find('body').height() + 30;
            $(this).height(h);
            cNotification.element.removeClass('statusbar-loader');
        }).attr("src", src);
    };
};

///////////////////////////////////////////////////////////////////////////////////////
// COMMON
var cCommon = new function () {

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, d, funcSuccess, funcError, true);
    };

    this.save = function (param, fSuccess, formID, additionalData, onlyUseAdditionalData) {
        if (typeof fSuccess !== 'function') {
            fSuccess = function (ret) {
                cNotification.success();
                var qs = cCommon.getQS(); //get query string
            };
        }

        cNotification.hide();
        var frm = null;
        if (typeof formID !== 'undefined') {
            frm = $("#" + formID);
        } else {
            frm = $("form:first");
        }
        var validate = cForm.validate(frm);
        if (validate) {
            cNotification.loader();

            var t = 'POST';
            var u = '/' + currentLanguage + '/' + route[param + "_save"];
            var d = cForm.serialize(frm);

            if (typeof onlyUseAdditionalData !== 'undefined') {
                d = additionalData;
            } else if (typeof additionalData !== 'undefined') {
                d = d + additionalData;
            }
            cCommon.doAsyncRequest(t, u, d, fSuccess);
        } else {
            cNotification.validation();
        }
    };

    this.erase = function (param) {
        cNotification.hide();
        cNotification.loader();

        var frm = $("form:first");
        var t = 'POST';
        var u = '/' + currentLanguage + '/' + route[param + "_delete"];
        var d = cForm.serialize(frm);
        cCommon.doAsyncRequest(t, u, d, function (ret) {
            cNotification.success();
            var qs = cCommon.getQS(); //get query string
            window.location = '/' + currentLanguage + '/' + route[param] + qs;
        });
    };

    this.delete = function (url, id, rowIDPrefix) {
        cNotification.hide();
        cNotification.loader();
        var d = {id: id};
        cCommon.doAsyncRequest('GET', url, d, function (ret) {
            $("#" + rowIDPrefix + id).remove();
            cNotification.success();
        });
    };

    this.getQS = function () {
        var qs = "";
        var customerID = "";
        var applicationID = "";
        var url = window.location.toString();

        //kullanici ve uygulama listesinde customerID olabilir
        if (url.indexOf(route["users"]) > -1 || url.indexOf(route["applications"]) > -1) {
            customerID = getParameterByName("customerID");
            if (customerID.length > 0) {
                qs = qs + (qs.length > 0 ? "&" : "?") + "customerID=" + customerID;
            } else {
                customerID = $("#CustomerID").val();
                if (customerID !== undefined && customerID.length > 0) {
                    qs = qs + (qs.length > 0 ? "&" : "?") + "customerID=" + customerID;
                }
            }
        }

        //icerik listesinde applicationID olabilir
        if (url.indexOf(route["contents"]) > -1) {
            applicationID = getParameterByName("applicationID");
            if (applicationID.length > 0) {
                qs = qs + (qs.length > 0 ? "&" : "?") + "applicationID=" + applicationID;
            } else {
                applicationID = $("#ApplicationID").val();
                if (applicationID !== undefined && applicationID.length > 0) {
                    qs = qs + (qs.length > 0 ? "&" : "?") + "applicationID=" + applicationID;
                }
            }
        }
        return qs;
    };

    this.fileUploadInit = function (uploadUrl, fsuccess) {
        $("#File").fileupload({
            url: uploadUrl,
            dataType: 'json',
            sequentialUploads: true,
            multipart: true,
            formData: {
                'element': 'File'
            },
            done: function (e, data) {
                console.log(data);
                if (data.textStatus.valueOf() === 'success'.valueOf()) {
                    var result = data.result;
                    if (data.result !== null) {
                        if (result.status.valueOf() === 'success'.valueOf()) {
                            fsuccess(result);
                        } else {
                            cNotification.validation(result.responseMsg);
                        }
                    } else {
                        cNotification.failure(notification['failure']);
                    }
                }
            },
            fail: function (e, data) {
                cNotification.failure(notification['failure']);
            }
        });

        //select file
        $("#FileButton").click(function () {
            $("#File").click();
        });
    }
};

///////////////////////////////////////////////////////////////////////////////////////
// NOTIFICATION
var cNotification = new function () {
    var _self = this;

    this.element = null;

    $(function () {
        _self.element = $("#myNotification");
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

        if (this.element.find('#galeSpinner').length == 0) {
            this.element.prepend("<img src='data:image/png;base64,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' id='galeSpinner' style='position:absolute;left:10px;'>");
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
                    if (_self.element.hasClass("statusbar-loader")) {
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
var cAjax = new function () {
    this.doSyncRequest = function (t, u, d, funcError) {
        updatePageRequestTime();
        if (typeof funcError === "undefined") {
            funcError = function (ret) {
                cNotification.failure(ret.getValue("errmsg"));
            };
        }

        return $.ajax({
            async: false,
            type: t,
            url: u,
            data: d,
            error: funcError
        }).responseText;
    };

    this.doAsyncRequestNew = function (u, t, d, funcSuccess, funcError) {
        cNotification.hide();
        cNotification.loader();
        if (t === undefined) {
            t = 'POST';
        }

        if (d === undefined) {
            d = {};
        }

        if (funcSuccess === undefined) {
            funcSuccess = function (ret) {
                if (typeof ret.successMsg !== "undefined") {
                    cNotification.success(ret.successMsg);
                } else {
                    cNotification.success();
                }
                setTimeout(function () {
                    cNotification.hide()
                }, 3000);
            }
        }
        if (funcError === undefined) {
            funcError = function (ret) {
                if (ret.errorMsg !== undefined) {
                    cNotification.failure(ret.errorMsg);
                } else {
                    cNotification.failure();
                }
            };
        }
        $.ajax({
            type: t,
            url: u,
            data: d,
            success: function (ret) {
                var retJson = JSON.parse(ret);
                if (t === 'GET') {
                    funcSuccess(retJson);
                    return;
                }

                if (retJson.success) {
                    funcSuccess(retJson);
                } else {
                    funcError(retJson);
                }
            },
            error: funcError
        });
    };

    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError, checkIfUserLoggedIn) {
        updatePageRequestTime();

        if (typeof funcSuccess === "undefined") {
            funcSuccess = cNotification.success();
        }

        if (typeof funcError === "undefined") {
            funcError = function (ret) {
                cNotification.failure(ret.getValue("errmsg"));
            };
        }
        checkIfUserLoggedIn = typeof checkIfUserLoggedIn === "undefined";
        $.ajax({
            type: t,
            url: u,
            data: d,
            success: function (ret) {
                if (t === 'GET') {
                    funcSuccess(ret);
                    return;
                }

                if (checkIfUserLoggedIn) {
                    if (ret.getValue("userLoggedIn") == "true") {
                        if (ret.getValue("success") == "true") {
                            funcSuccess(ret);
                        } else {
                            funcError(ret);
                        }
                        return;
                    }
                    cUser.go2Login();
                } else {
                    if (ret.getValue("success") == "true") {
                        funcSuccess(ret);
                    } else {
                        funcError(ret);
                    }
                }
            },
            error: funcError
        });
    };

};

///////////////////////////////////////////////////////////////////////////////////////
// FORM
var cForm = new function () {
    this.validate = function (formObj) {
        var ret = true;
        formObj.each(function () {
            $("div.error", $(this)).removeClass("error");
            $(".required", $(this)).each(function () {
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

var cGoogleMap = new function () {
    this.objectName = "maps";
    this.save = function () {
        cCommon.save(this.objectName);
    };

    this.delete = function (id) {
        var url = "/maps/delete";
        var rowIDPrefix = "googleMapIDSet_";
        cCommon.delete(url, id, rowIDPrefix);
    }
};

var cTemplate = new function () {
    var background = 1;
    var foreground = 1;
    this.objectName = "contents_template";

    this.save = function () {
        var fsuccess = function (ret) {
            cNotification.success();
        };
        cCommon.save(this.objectName, fsuccess, "templateForm");
    };

    this.loadCss = function (background, foreground) {
        $('.app-background-templates').remove();
        var $head = $('head');
        switch (background) {
            case 1:
                $head.append('<link rel="stylesheet" class="app-background-templates" href="/css/template-chooser/background-template-dark.css" type="text/css" />');
                break;
            case 2:
                $head.append('<link rel="stylesheet" class="app-background-templates" href="/css/template-chooser/background-template-light.css" type="text/css" />');
                break;
        }
        $head.append('<link rel="stylesheet" class="app-foreground-templates" href="/csstemplates/' + foreground + '.css" type="text/css" />');
    };

    this.initialize = function () {
        function openHomePage() {
            $('#templateChooserBox .site-settings').addClass('active');
            $('.templateScreen .footer').css('left', '0');
            $('.templateSplashScreen').removeClass('hide').fadeTo("slow", 1, function () {
                setTimeout(function () {
                    $('.templateSplashScreen').fadeTo("slow", 0, function () {
                        $('.templateSplashScreen').addClass("hide");
                        $('.templateScreen').removeClass('hide').fadeTo("slow", 1);
                    });
                }, 1000);
            });


            $(".footerBtnHome").click(function () {
                $('.templateScreen').fadeTo("slow", 0, function () {
                    $('.templateScreen').addClass('hide');
                    $('.templateScreen').removeClass('hide').fadeTo("slow", 1);
                });
            });
        }

        if ($('#modalTemplateChooser').length < 1) {
            openHomePage();
        }

        $('#modalTemplateChooser').on('shown.bs.modal', function () {
            $('.container.content-list').addClass('blurred');
            $('#templateChooserBox').show(500);
            openHomePage();
        });

        $('#modalTemplateChooser').on('hidden.bs.modal', function (e) {
            $('.templateSplashScreen, .templateScreen').addClass('hide');
            $('.container.content-list').removeClass('blurred');
            $('#templateChooserBox').hide(500);
            $('#templateChooserBox .site-settings').removeClass('active');
            $('.templateExtrasScreen').addClass('hide').fadeTo("fast", 0);
            $('.templateScreen').css('margin-left', '0');
            $('.templateScreen .footer').css('right', '0');
        });

        $('.templateExtrasScreen .title-drop').click(function () {
            $(this).parent().parent().next().toggleClass('panelClose');
        });

        $('#templateChooserClose').click(function () {
            $('#modalTemplateChooser').modal('hide');
        });

        $('.header-categories').click(function () {
            if ($('.templateExtrasScreen').hasClass('hide')) {
                $('.templateExtrasScreen').removeClass('hide').fadeTo("fast", 1);
                $('.templateScreen').css('margin-left', '75%');
                $('.templateScreen .footer').css('left', '75%');
            }
            else {
                $('.templateExtrasScreen').addClass('hide').fadeTo("fast", 0);
                $('.templateScreen').css('margin-left', '0');
                $('.templateScreen .footer').css('left', '0');
            }
        });

    };

    this.show = function (ApplicationID, ThemeBackground, ThemeForegroundColor, Autoplay, Speed) {
        $.ajax({
            async: false,
            type: 'GET',
            url: '/template/' + ApplicationID,
            success: function (response) {
                $('#ipadView').html(response);
                if ($('#imgPreview').attr('src') == "/img/bannerSlider/defaultPreview.jpg" || $('#imgPreview').attr('src') == "") {
                    $('.my-btn-success').addClass('noTouch').css('background', 'rgba(52, 52, 52, 0)');
                }
                cTemplate.loadCss(parseInt(ThemeBackground), ThemeForegroundColor.replace('#', ''));
                cTemplate.initMySlider(parseInt(+Autoplay), parseInt(Speed));
            }
        });
    };

    this.initMySlider = function (Autoplay, Speed) {
        var slider = new MasterSlider();
        slider.setup('masterslider', {
            // width: 380,
            height: 164,
            space: 0,
            view: 'fadeBasic',
            layout: 'fillwidth',
            fillMode: 'stretch',
            speed: Speed,
            autoplay: Autoplay,
            loop: true
        });
        var gallery = new MSGallery('ms-gallery-1', slider);
        gallery.setup();
        slider.api.addEventListener(MSSliderEvent.CHANGE_START, function () {
            $("#ms-gallery-1 .ms-gallery-botcont").stop(true);
//	    $("#ms-gallery-1 .ms-gallery-botcont").animate({opacity: 0.7}, 750);
        });
        slider.api.addEventListener(MSSliderEvent.CHANGE_END, function () {
            $("#ms-gallery-1 .ms-gallery-botcont").delay(2500).animate({opacity: 0}, 2500);
        });
        $('#ms-gallery-1').click(function () {
            $("#ms-gallery-1 .ms-gallery-botcont").stop(true);
            if ($("#ms-gallery-1 .ms-gallery-botcont").css('opacity') > 0) {
                $("#ms-gallery-1 .ms-gallery-botcont").animate({opacity: 0}, 250);
            }
            else {
//		$("#ms-gallery-1 .ms-gallery-botcont").animate({opacity: 0.7}, 250);
            }
        });
        var slider2 = new MasterSlider();
        slider2.setup('masterslider2', {
            width: 277,
            height: 120,
            space: 0,
            view: 'fadeBasic',
            layout: 'partialview',
            fillMode: 'stretch',
            speed: Speed,
            autoplay: Autoplay
        });
        var gallery2 = new MSGallery('ms-gallery-2', slider2);
        gallery2.setup();
        slider2.api.addEventListener(MSSliderEvent.CHANGE_START, function () {
            $("#ms-gallery-2 .ms-gallery-botcont").stop(true);
//	    $("#ms-gallery-2 .ms-gallery-botcont").animate({opacity: 0.7}, 750);
        });
        slider2.api.addEventListener(MSSliderEvent.CHANGE_END, function () {
            $("#ms-gallery-2 .ms-gallery-botcont").delay(2500).animate({opacity: 0}, 2500);
        });
        $('#ms-gallery-2').click(function () {
            $("#ms-gallery-2 .ms-gallery-botcont").stop(true);
            if ($("#ms-gallery-2 .ms-gallery-botcont").css('opacity') > 0) {
                $("#ms-gallery-2 .ms-gallery-botcont").animate({opacity: 0}, 250);
            }
            else {
//		$("#ms-gallery-2 .ms-gallery-botcont").animate({opacity: 0.7}, 250);
            }
        });
        $(".ms-info").each(function () {
            if ($(this).text().length > 50) {
                var infoText = $(this).text();
                infoText = infoText.substring(0, 50);
                $(this).text(infoText + "...");
            }
        });
    };

};


var cBanner = new function () {
    var _self = this;
    this.objectName = "banners";

    this.addImageUpload = function () {

        $("#ImageFile").fileupload({
            url: '/' + currentLanguage + '/common/imageupload',
            dataType: 'json',
            sequentialUploads: true,
            formData: {
                'element': 'ImageFile'
            },
            add: function (e, data) {
                if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name)) {
                    $('#hdnImageFileSelected').val("1");
                    $("[for='ImageFile']").removeClass("hide");

                    data.context = $("[for='ImageFile']");
                    data.context.find('a').click(function (e) {
                        e.preventDefault();
                        var template = $("[for='ImageFile']");
                        data = template.data('data') || {};
                        if (data.jqXHR) {
                            data.jqXHR.abort();
                        }
                    });
                    var xhr = data.submit();
                    data.context.data('data', {jqXHR: xhr});
                }
            },
            progressall: function (e, data) {
                var progress = data.loaded / data.total * 100;

                $("[for='ImageFile'] label").html(progress.toFixed(0) + '%');
                $("[for='ImageFile'] div.scale").css('width', progress.toFixed(0) + '%');
            },
            done: function (e, data) {
                if (data.textStatus == 'success') {
                    var fileName = data.result.fileName;
                    var $myButtonSuccess = $('.my-btn-success');
                    $('#hdnImageFileName').val(fileName);
                    $('#imgPreview').attr("src", "/files/temp/" + fileName);
                    $("[for='ImageFile']").addClass("hide");

                    //auto save
                    if (parseInt($("#ContentID").val()) > 0) {
                        cContent.save();
                    }

                    $myButtonSuccess.removeClass("noTouch").css('background', '');

                    var url = $('#TargetUrl').val();
                    if (url.length > 0 && !isUrlReachable(url)) {
                        $(".input-group + span.urlError").removeClass("hide");
                        $myButtonSuccess.addClass('noTouch').css('background', 'rgba(52, 52, 52, 0)');
                    }
                }
            },
            fail: function () {
                $("[for='ImageFile']").addClass("hide");
            }
        });

        //select file
        $("#ImageFileButton").removeClass("hide").click(function () {
            $("#ImageFile").click();
        });
    };

    this.checkUrl = function () {
        var url = $('#TargetUrl').val();
        var $checkUrl = $('#checkUrl');
        $checkUrl.css('background-color', '#2e2e2e');
        $(".input-group + span.urlError").addClass("hide");
        if (url.length > 0 && !isUrlReachable(url)) {
            $(".input-group + span.urlError").removeClass("hide");
            $('.my-btn-success').addClass('noTouch').css('background', 'rgba(52, 52, 52, 0)');
        }
        else if (isUrlReachable(url)) {
            $('.my-btn-success').removeClass("noTouch").css('background', '');
            $checkUrl.css('background-color', '#59AD2F !important;');
            $checkUrl.css('color', '#fff');
        }
        else if (url.length == 0) {
            $('.my-btn-success').removeClass("noTouch").css('background', '');
        }

        if ($('#imgPreview').attr('src') == '/img/bannerSlider/defaultPreview.jpg') {
            $('.my-btn-success').addClass('noTouch').css('background', 'rgba(52, 52, 52, 0)');
        }
    };

    this.settingSave = function () {
        cCommon.save('banners_setting', undefined, 'bannerForm');
    };

    this.createNewBanner = function (applicationID) {
        /* global appID */
        cCommon.save(
            this.objectName,
            function (ret) {
                cNotification.success();
                var BannerID = ret.getValue('BannerID');
                var BannerImagePath = ret.getValue('BannerImagePath');
                var ActiveText = ret.getValue('ActiveText');
                var PassiveText = ret.getValue('PassiveText');
                var htmlRow =
                    '<tr id="bannerIDSet_' + BannerID + '" class="odd" style="background-color: #7f8c8d">'
                    + '<td style="cursor:pointer;"><span class="icon-resize-vertical list-draggable-icon"></span></td><td>'
                    + '<img id="bannerImage_' + BannerID + '" src="' + BannerImagePath + '" width="60px" height="30px" style="cursor: pointer" onclick="fileUpload(this)">'
                    + '<div id="uploadProgress_' + BannerID + '" class="myProgress hide">'
                    + '<a href="#" class="editable editable-click">İptal <i class="icon-remove"></i></a>'
                    + '<label for="scale"></label>'
                    + '<div class="scrollbox dot">'
                    + '<div class="scale" style="width: 0"></div>'
                    + '</div></div></td>' +
                    '<td>'
                    + '<a href="#" id="' + BannerID + '" data-name="TargetUrl" data-type="text" data-pk="' + BannerID + '" data-title="Target Url:"></a>'
                    + '</td>' +
                    '<td>' +
                    '<a href="#" id="description_' + BannerID + '"data-name="Description" data-type="text" data-pk="' + BannerID + '"data-title="Text"></a>' +
                    '</td>' +
                    '<td><div class="toggle_div">'
                    + '<input type="checkbox" title="BannerStatus" class="toggleCheckbox" style="color: white" id="BannerStatus_' + BannerID + '" />'
                    + '</div></td><td>' + BannerID + '</td>'
                    + '<td style="alignment-adjust: middle"><div style="padding-top: 8px;">'
                    + '<span style=" cursor: pointer; font-size: 30px;" class="icon-remove-sign" onclick="cBanner.delete(' + BannerID + ');"></span></div></td></tr>'
                var DataTable = $('#DataTables_Table_1');
                DataTable.find('tbody').prepend(htmlRow);
                DataTable.find('tbody a').editable({
                    emptytext: '. . . . .',
                    url: route['banners_save'],
                    params: {'applicationID': appID},
                    ajaxOptions: {
                        beforeSend: function () {
                            cNotification.loader();
                        }
                    },
                    success: function () {
                        cNotification.success();
                        setTimeout(function () {
                            cNotification.hide();
                        }, 1000);
                    }
                });

                $('#BannerStatus_' + BannerID).bootstrapToggle({
                    size: 'mini',
                    on: ActiveText,
                    off: PassiveText,
                    offstyle: 'danger',
                    onstyle: 'info',
                    style: 'ios'
                });
            },
            undefined,
            "&newBanner=1"
        );
    };

    this.delete = function (id) {
        var url = "/banners/delete";
        var rowIDPrefix = "bannerIDSet_";
        cCommon.delete(url, id, rowIDPrefix);
    };

    //this.saveFromList = function (id) {
    //
    //};

    // this.targetContent = function () {
    //  var selectedIndex = $('#TargetContent option:selected').index();
    //  console.log(selectedIndex);
    //  if(selectedIndex==0){
    //  	$('#TargetUrl, #TargetUrl + *').removeClass('noTouch').css('opacity',1);
    //  }
    //  else {
    //  	$('#TargetUrl, #TargetUrl + *').addClass('noTouch').css('opacity',0.5);
    //  }
    // };
};


//# sourceMappingURL=gurus.js.map
