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


















