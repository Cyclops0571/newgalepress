Date.prototype.format = function (format) {
    var d = "";
    var currYear = this.getFullYear().toString();
    var currMonth = (this.getMonth() + 1).toString(); //months are zero based 
    var currDay = this.getDate().toString();
    var currHour = this.getHours().toString();
    var currMinute = this.getMinutes().toString();

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