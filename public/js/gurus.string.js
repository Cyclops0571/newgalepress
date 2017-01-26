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
    base64 = (typeof base64 == "undefined") ? true : base64
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








