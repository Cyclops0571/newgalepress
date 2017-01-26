//event to check session time variable declaration
var checkSessionTimeEvent;

$(document).ready(function () {
    //event to check session time left (times 1000 to convert seconds to milliseconds)
    checkSessionTimeEvent = setInterval("checkSessionTime()", 5 * 1000);
});

//Your timing variables in number of seconds

//total length of session in seconds
var sessionLength = 7200;

//time warning shown (10 = warning box shown 10 seconds before session starts)
var warning = 300;

var pageRequestTime = new Date();

//session timeout length
var timeoutLength = sessionLength * 1000;

//set time for first warning, ten seconds before session expires
var warningTime = timeoutLength - (warning * 1000);

//force redirect to log in page length (session timeout plus 10 seconds)
var forceRedirectLength = timeoutLength + 10000;

//set number of seconds to count down from for countdown ticker
var countdownTime = warning;

//warning dialog open; countdown underway
var warningStarted = false;

//event create countdown ticker variable declaration
var countdownTickerEvent;

function checkSessionTime()
{
    //var logginInStatus = $.cookie('loggedin', { domain: 'localhost', path: '/' });
    var logginInStatus = $.cookie('loggedin');
    if (!logginInStatus) {
	return;
    }

    //get time now
    var timeNow = new Date();

    //difference between time now and time session started variable declartion
    var timeDifference = 0;

    timeDifference = timeNow - pageRequestTime;

    if (timeDifference > warningTime && warningStarted === false) {
	//call now for initial dialog box text (time left until session timeout)
	countdownTicker();

	//set as interval event to countdown seconds to session timeout
	countdownTickerEvent = setInterval("countdownTicker()", 1000);

	$('#modalWarning').modal('show');

	warningStarted = true;
    } else if (timeDifference > timeoutLength && countdownTime == 0) {
	//close warning dialog box
//    	$('#modalWarning').modal('hide');
//        
//        $('#modalExpired').modal('show');

	//clear (stop) countdown ticker
	clearInterval(countdownTickerEvent);

	//clear (stop) checksession event
	clearInterval(checkSessionTimeEvent);

	//force relocation
	goLogin();
    }

//    if (timeDifference > forceRedirectLength) {  
//       //clear (stop) checksession event
//        clearInterval(checkSessionTimeEvent);
//
//        //force relocation
//        goLogin();
//    }
}

function countdownTicker()
{
    //put countdown time left in dialog box
    $("span#dialogText-warning").html(countdownTime);

    //decrement countdownTime
    countdownTime--;

    if (countdownTime < 1)
    {
	countdownTime = 0;
	$('#modalWarning').modal('hide');
    }
}

function restartSession()
{
    var d = "url=" + encodeURIComponent('http://www.galepress.com');
    $.ajax({
	type: "POST",
	url: '/' + currentLanguage + '/' + route["interactivity_check"],
	data: d,
	success: function (resp) {
	    //resp
	},
	error: function (ret) {
	    //alert(ret);
	}
    });
    clearInterval(countdownTickerEvent);
    warningStarted = false;
    countdownTime = warning;
    updatePageRequestTime();
    $('#modalWarning').modal('hide');
    //location.reload();
}

function updatePageRequestTime()
{
    pageRequestTime = new Date();
}

function goLogin()
{
    window.location = "/" + currentLanguage + "/" + route["logout"];
}