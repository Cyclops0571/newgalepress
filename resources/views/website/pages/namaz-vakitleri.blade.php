<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <title>Namaz Vakitleri</title>
  <meta name="keywords" content="Namaz, Vakit, Kıble, Pusula" />
  <meta name="description" content="Namaz Vakitleri">
    <meta name="author" content="Gale Press">

  <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <link href='http://fonts.googleapis.com/css?family=Titillium+Web:200, 400,600' rel='stylesheet' type='text/css'>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
  <script src="/website/namaz/jquery.simpleWeather.min.js"></script>
  <style type="text/css">
    body{
      background-color:#5E82A0;
      background-image:url('/website/namaz/background.jpg');
      background-repeat:no-repeat;
      /*background-attachment:fixed;*/
      background-size:cover;
      background-position:center center;
    }
    *{
      font-family: 'Titillium Web', sans-serif !important;
      font-weight: 400 !important;
      font-size: 1.02em !important;
    }
    .fontBold{
      font-weight: 600 !important;
    }
    .fontLight{
      color:#fff !important;
      text-shadow: 1px 1px #838383;
    }
    .prayerTimes{
      font-size: 1.1em !important;
    }
    .col-xs-2{
      padding: 0;
      text-align: center;
      margin: 5px;
    }
    .topShadow{
      -webkit-box-shadow: 0px -5px 15px 0px rgba(0,0,0,0.65);
      -moz-box-shadow: 0px -5px 15px 0px rgba(0,0,0,0.65);
      box-shadow: 0px -5px 15px 0px rgba(0,0,0,0.65);
    }
    .prayerTime p{
      font-size: 3em !important;
      font-weight: 200 !important;
      margin: 0;
    }
    #map-canvas {
      height: 100%;
      margin: 0px;
      padding: 0px
    }
  </style>
</head>
<body>
<div class="container">

    <div class="row">

        <div class="col-xs-12">

          <div class="row text-center prayerTime">
            <h1 class="fontLight" style="opacity:0;"><span class="futurePrayer">...</span> namazına kalan süre:</h1>
            <p class="fontBold fontLight" style="opacity:0;text-shadow: 2px 2px #838383;">...</p>
          </div>
          <div class="row namaz">
            <div class="col-xs-offset-1 col-xs-2">
              <h2>Sabah</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Öğle</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>İkindi</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Akşam</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Yatsı</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
          </div>
        </div>

    </div>

    <div class="row topShadow">

        <div class="col-xs-12">

          <div class="row text-center prayerLocation">
            <h1><span>...</span> / <span>...</span></h1>
            <p style="font-size:2.5em !important;">...</p>
          </div>
          <div class="row weathers">
            <div class="col-xs-offset-1 col-xs-2">
              <h2>Cmt</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Paz</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Pzt</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Sal</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
            <div class="col-xs-2">
              <h2>Çar</h2>
              <p class="fontBold prayerTimes">...</p>
            </div>
          </div>
        </div>

    </div>

</div>

<script type="text/javascript">
// Docs at http://simpleweatherjs.com
$(document).ready(function() {
  // Note: This example requires that you consent to location sharing when
  // prompted by your browser. If you see a blank space instead of the map, this
  // is probably because you have denied permission for location sharing.
  function initialize() {

      // Try HTML5 geolocation
      if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
        var pos = new google.maps.LatLng(position.coords.latitude,
                                           position.coords.longitude);

        var geocoder = new google.maps.Geocoder();
          geocoder.geocode({'latLng': new google.maps.LatLng(position.coords.latitude, position.coords.longitude)}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK && results.length) {
                  results = results[0].address_components;
                  var loopBreak=true;
                  for (i = 0; i < results.length; i++) {
                    if(loopBreak){
                      for (j = 0; j < results[i].types.length; j++) {
                        if(results[i].types[j].indexOf("sublocality_level_1")!=-1){
                          $('.prayerLocation h1 span:first-child').text(results[i].long_name);
                          $('.prayerLocation h1 span:first-child').trigger('change');
                          loopBreak=false;
                          break;
                        }
                        else{
                        	if(results[i].types[j].indexOf("administrative_area_level_1")!=-1){
	                          $('.prayerLocation h1 span:first-child').text(results[i].long_name);
                            $('.prayerLocation h1 span:first-child').trigger('change');
	                        }
                        }
                      }
                    }
                    else {
                      break;
                    }
                  }
              }
          });
      }); 
    }
  }
  google.maps.event.addDomListener(window, 'load', initialize);
   

  var settings = {
      template: "{saat}:{dakika}:{saniye}",
      zamanGoster: '.prayerTime p'
  };


  function calculatePrayerTime(settings){

    var zaman = new Date(),
            saat = zaman.getHours(),
            dakika = zaman.getMinutes(),
            saniye = zaman.getSeconds(),
            ezanVakti = false;
        
        $('.namaz div').each(function(){
            var dZaman = $('p', this).text().split(':'),
                dToplam = ( dZaman[0] * (60 * 60) ) + ( dZaman[1] * 60 ),
                nToplam = (saat * (60 * 60)) + ( dakika * 60 );
            if ( dToplam <= nToplam ){
                $(this).removeClass('suan gecmedi').addClass('gecti');
            } else {
                $(this).removeClass('suan gecti').addClass('gecmedi');
            }
            /* eğer namaz okunuyorsa */
            if ( dZaman[0] == saat && dZaman[1] == dakika ) {
                ezanVakti = true;
                $(this).addClass('suan');
                if(saniye == 0)
                {
                  $('body').fadeOut(200);
                  location.reload();
                }
            }
        });
        
        if ( !$('.namaz div').hasClass('gecmedi') ){
            $('.namaz div:first').removeClass('gecti').addClass('gecmedi');
        }
        
        var YNZ = $('.namaz div.gecmedi:first p').text().split(':'),
            saatFark = YNZ[0] - saat,
            dakikaFark = (YNZ[1] - dakika) - 1,
            saniyeFark = 59 - saniye;
        
        if ( dakikaFark < 0 ){
            saatFark = saatFark - 1;
            dakikaFark = 60 + dakikaFark;
        }

        if ( saatFark < 0 ){
            saatFark = 24 + saatFark;
        }
        
        saatFark = saatFark < 10 ? '0' + saatFark : saatFark;
        dakikaFark = dakikaFark < 10 ? '0' + dakikaFark : dakikaFark;
        saniyeFark = saniyeFark < 10 ? '0' + saniyeFark : saniyeFark;
        
        $(settings.zamanGoster).html( settings.template.replace('{saat}', saatFark).replace('{dakika}', dakikaFark).replace('{saniye}', saniyeFark) );
        
        $('.namaz div.gecti').removeClass('songecen').filter(':last').addClass('songecen');
        
        if ( !$('.namaz div').hasClass('gecti') ){
            $('.namaz div:last').addClass('songecen');
        }

        $('span.futurePrayer').text($('.namaz .gecmedi:first h2').text());       
  }

  calculatePrayerTime(settings);
  setInterval(function() {
      calculatePrayerTime(settings);
  }, 1000);

  var daysInWeek = ['Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt'];

  function getToday(){
    var d = new Date();
    var n = d.getDay();
    var nLong="";
    switch(n) {
      case 0:
          nLong = "Pazar";
          break;
      case 1:
          nLong = "Pazartesi";
          break;
      case 2:
          nLong = "Salı";
          break;
      case 3:
          nLong = "Çarşamba";
          break;
      case 4:
          nLong = "Perşembe";
          break;
      case 5:
          nLong = "Cuma";
          break;
      case 6:
          nLong = "Cumartesi";
          break;     
    }
    $('.prayerLocation h1 span:eq(1)').text(nLong);
    for(var i=0;i<5;i++) {
      $('.weathers h2:eq('+i+')').text(daysInWeek[n]);
      n++;
      if(n>6){
        n=0;
      }
    }
  }
  getToday();

  function detectTomorrow(){
      if(window.newdaytimer) clearTimeout(newdaytimer);
      var now= new Date,
      tomorrow= new Date(now.getFullYear(), now.getMonth(), now.getDate()+1); 
      window.newdaytimer= setTimeout(newdayalarm, tomorrow-now);
      
  }
  function newdayalarm(){
      $('body').fadeOut(200);
      location.reload();
  }

  detectTomorrow();

  $.simpleWeather({
    location: 'Üsküdar',
    unit: 'c',
    success: function(weather) {
      $('.prayerLocation p').text(weather.forecast[0].high+'°');
      for(var i=0;i<weather.forecast.length;i++) {
        $('.weathers p:eq('+i+')').text(weather.forecast[i].high+'°');
      }
    },
    error: function(error) {
      
    }
  });

  $('.prayerLocation h1 span:first-child').change(function(){
    var myLocation = $('.prayerLocation h1 span:first-child').text();
    $('.prayerTime h1').delay(750).fadeTo(1200,1);
    $('.prayerTime p').delay(750).fadeTo(1200,1);
    // var myLocation = 'Şebinkarahisar';
    $.ajax({
        async: false,
        type: 'POST',
        url: 'namaz-vakitleri',
        data: {location:myLocation},
        success: function (response) {
          var imsak = jQuery.parseJSON(response)['imsak'];
          var ogle = jQuery.parseJSON(response)['ogle'];
          var ikindi = jQuery.parseJSON(response)['ikindi'];
          var aksam = jQuery.parseJSON(response)['aksam'];
          var yatsi = jQuery.parseJSON(response)['yatsi'];
          $('.namaz p:eq(0)').text(imsak.substr(0,5));
          $('.namaz p:eq(1)').text(ogle.substr(0,5));
          $('.namaz p:eq(2)').text(ikindi.substr(0,5));
          $('.namaz p:eq(3)').text(aksam.substr(0,5));
          $('.namaz p:eq(4)').text(yatsi.substr(0,5));
            
        }
    });
  });
});
</script>
</body>
</html>