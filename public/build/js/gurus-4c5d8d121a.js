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
//# sourceMappingURL=gurus.js.map
