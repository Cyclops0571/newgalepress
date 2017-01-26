/**
 * Created by Serdar Saygili on 15.12.2015.
 */

var cManagement = new function () {
    this.objectName = "cManagement";

    this.delete = function (id) {
        var url = "/banners/delete";
        var rowIDPrefix = "bannerIDSet_";
        cCommon.delete(url, id, rowIDPrefix);
    };

    this.exportLanguagesFromDB = function () {
        cAjax.doAsyncRequestNew('/' + currentLanguage + '/managements/export');
    };

    this.importLanguagesToDb = function () {
        cAjax.doAsyncRequestNew('/' + currentLanguage + '/managements/import');
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
jQuery('#adfasdf').css('backgroun-color', 'yellow');