/* global currentLanguage, javascriptLang */

$(function () {
    $.datepicker.regional['tr'] = {
        closeText: 'kapat',
        prevText: '&#x3c;geri',
        nextText: 'ileri&#x3e',
        currentText: 'bug\u00fcn',
        monthNames: ['Ocak', '\u015eubat', 'Mart', 'Nisan', 'May\u0131s', 'Haziran', 'Temmuz', 'A\u011fustos', 'Eylül', 'Ekim', 'Kas\u0131m', 'Aral\u0131k'],
        monthNamesShort: ['Oca', '\u015eub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'A\u011fu', 'Eyl', 'Eki', 'Kas', 'Ara'],
        dayNames: ['Pazar', 'Pazartesi', 'Sal\u0131', '\u00c7arşamba', 'Per\u015fembe', 'Cuma', 'Cumartesi'],
        dayNamesShort: ['Pz', 'Pt', 'Sa', '\u00c7a', 'Pe', 'Cu', 'Ct'],
        dayNamesMin: ['Pz', 'Pt', 'Sa', '\u00c7a', 'Pe', 'Cu', 'Ct'],
        weekHeader: 'Hf',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
    };
    $.datepicker.regional['en'] = {
        dateFormat: 'dd.mm.yy',
    };
    $.datepicker.regional['de'] = {
        prevText: '&#x3c;zurück', prevStatus: '',
        prevJumpText: '&#x3c;&#x3c;', prevJumpStatus: '',
        nextText: 'Vor&#x3e;', nextStatus: '',
        nextJumpText: '&#x3e;&#x3e;', nextJumpStatus: '',
        currentText: 'heute', currentStatus: '',
        todayText: 'heute', todayStatus: '',
        clearText: '-', clearStatus: '',
        closeText: 'schließen', closeStatus: '',
        monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni',
            'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
        monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun',
            'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
        dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
        dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
        dateFormat: 'dd.mm.yy',
    };

    if (typeof ($.datepicker.regional[currentLanguage]) !== 'undefined') {
        $.datepicker.setDefaults($.datepicker.regional[currentLanguage]);
    }

    $(".date, .datepicker").datepicker();

    jQuery('#start-date').datepicker({
        dateFormat: 'dd.mm.yy',
        onSelect: function (selectedDate) {
            jQuery('#end-date').datepicker("option", "minDate", selectedDate);
            cReport.OnChange();
        }
    });

    jQuery('#end-date').datepicker({
        dateFormat: 'dd.mm.yy',
        onSelect: function (selectedDate) {
            jQuery('#start-date').datepicker("option", "maxDate", selectedDate);
            cReport.OnChange();
        }
    });

    $("#UserTypeID").change(function () {

        if ($(this).val() == "111") {
            $("#CustomerID").addClass("required");
            $("label[for='CustomerID']").html('Müşteri: <span class="error">*</span>');
        }
        else {
            $("#CustomerID").removeClass("required");
            $("label[for='CustomerID']").html('Müşteri:');
        }
    });

    $("#IsProtected").click(function () {
        if ($(this).is(':checked')) {
            $("#Password").addClass("required");
            $("label[for='Password']").html('Parola: <span class="error">*</span>');
        }
        else {
            $("#Password").removeClass("required");
            $("label[for='Password']").html('Parola:');
        }
    });

    $("#IsMaster").click(function () {
        var e = $(this).parents('div.block:first').next();
        if ($(this).is(':checked')) {
            e.addClass("disabledFields");
            var IsProtected = $("#IsProtected");
            if (IsProtected.is(':checked')) {
                IsProtected.click();
            }
            $('#Password').val('');
            $('input', e).attr('disabled', 'disabled');
        }
        else {
            e.removeClass("disabledFields");
            $('input', e).removeAttr('disabled');
        }
    });

    $("#IsUnpublishActive").click(function () {
        if ($(this).is(':checked')) {
            $('#UnpublishDate').removeAttr('disabled', 'disabled').removeClass('disabledFields');
        } else {
            $('#UnpublishDate').attr('disabled', 'disabled').addClass('disabledFields');
        }
    });

    /*
     $("#IsBuyable").click(function () {
     if ($(this).is(':checked')) {
     $("#Price").addClass("required");
     $("label[for='Price']").html('Fiyat: <span class="error">*</span>');
     $("label[for='CurrencyID']").html('Para Birimi: <span class="error">*</span>');
     }
     else {
     $("#Price").removeClass("required");
     $("#CurrencyID").removeClass("required");
     $("label[for='Price']").html('Fiyat:');
     $("label[for='CurrencyID']").html('Para Birimi:');
     }
     });


     $("#dialog-category-form").dialog({
     autoOpen: false,
     height: 350,
     width: 350,
     modal: true,
     buttons: {
     "Kapat": function() {
     $(this).dialog("close");
     }
     },
     close: function() {
     $("#dialog-category-form").addClass("hidden");
     //cContent.loadCategoryOptionList();
     }
     });
     $('#dialog-category-form').on('hidden.bs.modal', function (e) {
     //console.log('asd');
     });
     */

    $(".tooltip").qtip({style: {classes: 'ui-tooltip-rounded'}});
});

function toogleFullscreen() {
    console.log('toogleFullscreen');
    /*
     if(!getFullscreenStatus())
     {
     $('.fullTrigger').click();	
     }
     else
     {
     exitFullscreen();
     }
     */
}

function getFullscreenStatus() {
    console.log('getFullscreenStatus');
    //return screenfull.isFullscreen;
}

function exitFullscreen() {
    console.log('exitFullscreen');
    //screenfull.exit();
}

function closeInteractiveIDE() {
    console.log('closeInteractiveIDE');
    //cContent.closeInteractiveIDE();
}

//***************************************************
// NEW DESIGN
//***************************************************
$(document).ready(function () {

    if ($("input[type=checkbox]").length > 0 || $("input[type=radio]").length > 0) {
        if (!$("input[type=checkbox]").hasClass("toggleCheckbox")) {
            $("input[type=checkbox], input[type=radio]").uniform();
        } else {
            $.each($("input[type=checkbox], input[type=radio]"), function () {
                if (!$(this).hasClass("toggleCheckbox")) {
                    $(this).uniform();
                }
            });
        }
    }

    $(".select2").chosen({
        placeholder_text_single: javascriptLang['select'],
        placeholder_text_multiple: javascriptLang['select'],
        no_results_text: javascriptLang['no_results']
    });

    $(".tip").tooltip({placement: 'top'});
    $(".tipb").tooltip({placement: 'bottom'});
    $(".tipl").tooltip({placement: 'left'});
    $(".tipr").tooltip({placement: 'auto'});

    $(".site-settings-button").click(function () {
        if ($(this).parent('.site-settings').hasClass('active'))
            $(this).parent('.site-settings').removeClass('active');
        else {
            $(this).parent('.site-settings').addClass('active');

            $(this).parent('.site-settings').find('input:checkbox, input:radio').uniform();

            if ($(".container").hasClass("container-fixed"))
                $(".ss_layout[value=fixed]").attr("checked", true).parent("span").addClass("checked");
            else
                $(".ss_layout[value=liquid]").attr("checked", true).parent("span").addClass("checked");
        }
    });

    if ($("table.sortable_simple").length > 0)
        $("table.sortable_simple").dataTable({
            "iDisplayLength": 5,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bPaginate": true
        });

    if ($("table.sortable_default").length > 0)
        $("table.sortable_default").dataTable({
            "iDisplayLength": 5,
            "sPaginationType": "full_numbers",
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bPaginate": true,
            "aoColumns": [{"bSortable": false}, null, null, null, null]
        });

    if ($("table.sortable").length > 0)
        $("table.sortable").dataTable({
            "iDisplayLength": 5,
            "aLengthMenu": [5, 10, 25, 50, 100],
            "sPaginationType": "full_numbers",
            "aoColumns": [{"bSortable": false}, null, null, null, null]
        });

    if ($(".knob").length > 0)
        $(".knob input").knob();

    if ($(".sparkline").length > 0)
        $('.sparkline span').sparkline('html', {enableTagOptions: true});


    $("#monthHideBtn").click(function () {

        if (!$('.list-item').hasClass('closed')) {
            $(".list-item").fadeOut();
            $(".list-item").addClass('closed');
            $("#monthHideIcon").removeClass('icon-chevron-up');
            $("#monthHideIcon").addClass('icon-chevron-down');
        }
        else {
            $(".list-item").fadeIn();
            $(".list-item").removeClass('closed');
            $("#monthHideIcon").removeClass('icon-chevron-down');
            $("#monthHideIcon").addClass('icon-chevron-up');
        }
    });

    $(".psn-control").click(function () {
        if ($('.page-container').hasClass('page-sidebar-narrow')) {
            $('.page-container').removeClass('page-sidebar-narrow');
            $(this).parent('.control').removeClass('active');
            //$("#my-info-block").fadeIn();
        } else {
            $('.page-container').addClass('page-sidebar-narrow');
            $(this).parent('.control').addClass('active');
            //$("#my-info-block").hide();
        }
        return false;
    });

    $(".page-navigation li a").click(function () {
        var ul = $(this).parent('li').children('ul');

        if (ul.length == 1) {
            if (ul.is(':visible'))
                ul.slideUp('fast');
            else
                ul.slideDown('fast');
            return false;
        }
    });

    $(".file .btn,.file input:text").click(function () {
        var block = $(this).parents('.file');
        block.find('input:file').click();
        block.find('input:file').change(function () {
            block.find('input:text').val(block.find('input:file').val());
        });
    });

    $('#logout').hover(
        function () {
            $('#header-background').css("background", "url(/img/headerRed.png) repeat-x");
        },
        function () {
            $('#header-background').css("background", "url(/img/headerBlue.png) repeat-x");
        }
    );

    $(window).bind("load", function () {
        //gallery(); HAKANHAKANHAKAN
        //thumbs(); HAKANHAKANHAKAN
        //lists();  HAKANHAKANHAKAN
        page();
    });

    $(window).resize(function () {

        /* vertical tabs */
        $(".nav-tabs-vertical").each(function () {
            var h = $(this).find('.nav-tabs').height();
            $(this).find('.tabs').css('min-height', h);
        });
        /* eof vertical tabs */

        //gallery();   HAKANHAKANHAKAN
        //thumbs(); HAKANHAKANHAKAN
        //lists(); HAKANHAKANHAKAN
        page();
    });

    function page() {
        if ($("body").width() < 768) {
            $(".page-container").addClass("page-sidebar-narrow");
            $(".page-navigation li ul").removeAttr('style');
            //$("#my-info-block").hide();
        }
    }

});

//dashboard
$(document).ready(function () {
    //İndirilme Sayısı
    function labelFormatter(label, series) {
        return "<div style='text-shadow: 1px 2px 1px rgba(0,0,0,0.2); font-size: 11px; text-align:center; padding:2px; color: #FFF; line-height: 13px;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
    }

    function showTooltip(x, y, contents) {
        $('<div class="ftooltip">' + contents + '</div>').css({
            position: 'absolute',
            'z-index': '10',
            display: 'none',
            top: y - 20,
            left: x,
            padding: '3px',
            'background-color': 'rgba(0,0,0,0.5)',
            'font-size': '11px',
            'border-radius': '3px',
            color: '#FFF'
        }).appendTo("body").fadeIn(200);
    }

    if ($("#dashboard").length > 0) {

        var previousPoint = null;

        $("#dash_chart_1").bind("plothover", function (event, pos, item) {

            $("#x").text(pos.x.toFixed(0));
            $("#y").text(pos.y.toFixed(0));

            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $(".ftooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(0);

                    showTooltip(item.pageX, item.pageY,
                        item.series.label + ": " + y);
                }
            } else {
                $(".ftooltip").remove();
                previousPoint = null;
            }

        });

        $("#dash_chart_2").bind("plothover", function (event, pos, item) {

            $("#x").text(pos.x.toFixed(0));
            $("#y").text(pos.y.toFixed(0));

            if (item) {
                if (previousPoint != item.dataIndex) {
                    previousPoint = item.dataIndex;

                    $(".ftooltip").remove();
                    var x = item.datapoint[0].toFixed(0),
                        y = item.datapoint[1].toFixed(0);

                    showTooltip(item.pageX, item.pageY,
                        item.series.label + ": " + y);
                }
            } else {
                $(".ftooltip").remove();
                previousPoint = null;
            }

        });

        $({numberValue: $('#myKnob').val()}).animate({numberValue: parseInt($('#myKnob').attr("data-value"))}, {
            duration: 4000,
            easing: 'swing',
            step: function () {
                $('#myKnob').val(Math.ceil(this.numberValue)).trigger('change');
            }
        });

        var attrData = $("#dash_chart_1").attr("data").split('-');
        var attrColumns = $("#dash_chart_1").attr("columns").split('-');
        var attrMaxData = parseInt($("#dash_chart_1").attr("maxdata"));
        var labelTitle = $("#dash_chart_1").attr("labelTitle");
        //var data  = [ [1, 25], [2, 28], [3, 22], [4, 18], [5, 30], [6, 18], [7,14] ];
        var data = [[1, parseInt(attrData[0])], [2, parseInt(attrData[1])], [3, parseInt(attrData[2])], [4, parseInt(attrData[3])], [5, parseInt(attrData[4])], [6, parseInt(attrData[5])], [7, parseInt(attrData[6])]];
        var plot1 = $.plotAnimator($("#dash_chart_1"), [{
            data: data,
            animator: {steps: 50},
            lines: {show: true, fill: false},
            label: labelTitle
        }], {
            series: {lines: {show: true}, points: {show: false}},
            grid: {hoverable: true, clickable: true, margin: {left: 110}},
            xaxis: {ticks: [[1, attrColumns[6]], [2, attrColumns[5]], [3, attrColumns[4]], [4, attrColumns[3]], [5, attrColumns[2]], [6, attrColumns[1]], [7, attrColumns[0]]]},
            yaxis: {min: 0, max: (attrMaxData > 0 ? attrMaxData : 100), tickDecimals: 0},
            legend: {show: false}
        });

        //İndirilme Sayısı istatistiğindeki animasyonun sonunda çalışacak olan kod bloğu. Çizgideki noktaları getirir.
        $("#dash_chart_1").on("animatorComplete", function () {
            plot2 = $.plot($("#dash_chart_1"), [{data: data, label: labelTitle}], {
                series: {lines: {show: true}, points: {show: true}},
                grid: {hoverable: true, clickable: true, margin: {left: 110}},
                xaxis: {ticks: [[1, attrColumns[6]], [2, attrColumns[5]], [3, attrColumns[4]], [4, attrColumns[3]], [5, attrColumns[2]], [6, attrColumns[1]], [7, attrColumns[0]]]},
                yaxis: {min: 0, max: (attrMaxData > 0 ? attrMaxData : 100), tickDecimals: 0},
                legend: {show: false}
            });
        });

        // var data99  = [ [1, 23], [2, 11], [3, 14], [4, 23], [5, 27] ];
        // $.plot($("#dash_chart_2"), [{ 	data: data99, label: "Cihaz" }],{
        // 							series: {bars: { show: true }},
        // 					grid: { hoverable: true, clickable: true},
        // 					xaxis: {ticks: [[1,'Ocak'], [2,'Şubat'], [3,'Mart'], [4,'Nisan'], [5,'Mayıs']]},
        // 					yaxis: {tickDecimals:0 },
        // 					legend: {show: false}});


        var attrDataIos = $("#dash_chart_2").attr("ios").split('-');
        var attrDataAndroid = $("#dash_chart_2").attr("android").split('-');
        var attrColumnsDevice = $("#dash_chart_2").attr("columns").split('-');
        var data98 = [[0, attrDataIos[4]], [1, attrDataIos[3]], [2, attrDataIos[2]], [3, attrDataIos[1]], [4, attrDataIos[0]]]; //IOS
        var data99 = [[0.2, attrDataAndroid[4]], [1.2, attrDataAndroid[3]], [2.2, attrDataAndroid[2]], [3.2, attrDataAndroid[1]], [4.2, attrDataAndroid[0]]]; //ANDROID
        var dataset = [{label: "iOS", data: data98, color: "#cecece"}, {
            label: "Android",
            data: data99,
            color: "#a4c739"
        }];
        var ticks = [[0, attrColumnsDevice[4]], [1, attrColumnsDevice[3]], [2, attrColumnsDevice[2]], [3, attrColumnsDevice[1]], [4, attrColumnsDevice[0]]];

        var options = {
            series: {
                bars: {
                    show: true,
                    barWidth: 0.3,
                    align: 'center'
                },
                grow: {
                    active: true,
                    steps: 40,
                    growings: [
                        {
                            stepMode: "linear"
                        }
                    ]
                }
            },
            xaxis: {
                axisLabel: "Cihaz",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 10,
                ticks: ticks
            },
            yaxis: {
                axisLabel: "İndirilme Adeti",
                axisLabelUseCanvas: true,
                axisLabelFontSizePixels: 12,
                axisLabelFontFamily: 'Verdana, Arial',
                axisLabelPadding: 3,
                min: 0,
                tickDecimals: 0
            },
            grid: {
                hoverable: true,
                borderWidth: 2
            }
        };

        $.plot($("#dash_chart_2"), dataset, options);

        //UYGULAMA DETAYI
        var arrStart = $("#startDate").text().split('.');
        var arrEnd = $("#endDate").text().split('.');
        var start = new Date(parseInt(arrStart[2]), parseInt(arrStart[1]) - 1, parseInt(arrStart[0]));
        var end = new Date(parseInt(arrEnd[2]), parseInt(arrEnd[1]) - 1, parseInt(arrEnd[0]));
        var today = new Date();
        var status = Math.round(100 - (end - today) / (end - start) * 100) + '%';
        var statusControl = Math.round(100 - (end - today) / (end - start) * 100);
        if (statusControl >= 100)
            status = 100 + '%';
        else if (statusControl < 0)
            status = 100 + '%';
        if ($("#startDate").text() == $("#endDate").text())
            status = 100 + '%';
        $("#appProgress").width(status);
        $("#datePerValue").text(status);

        //Onceki aylar
        var timeoutStart = 500;
        $(".previous-month").each(function () {
            var e = $(this);
            setTimeout(function () {
                e.width(e.attr("aria-value") + '%');
            }, timeoutStart);
            timeoutStart = timeoutStart + 500;
        })

    }
});

/* DİL DEĞİŞTİRME KODLARI - BAŞLANGIÇ */

function modalOpen() {
    $("#modalChangeLanguage").css("display", "block");

    if ($(location).attr('pathname').substring(0, 3) == "/tr") {

        $("#radio_tr").attr("class", "checked");
        $("#radio_en").attr("class", "none");
        $("#radio_de").attr("class", "none");
    }
    else if ($(location).attr('pathname').substring(0, 3) == "/en") {

        $("#radio_tr").attr("class", "none");
        $("#radio_en").attr("class", "checked");
        $("#radio_de").attr("class", "none");
    }
    else if ($(location).attr('pathname').substring(0, 3) == "/de") {

        $("#radio_tr").attr("class", "none");
        $("#radio_en").attr("class", "none");
        $("#radio_de").attr("class", "checked");
    }
}
function modalClose() {
    $("#modalChangeLanguage").css("display", "none");
}
function LanguageActive(lang) {
    document.location.href = '/' + lang + '/giris';
    $("#radio_" + lang).attr("class", "checked");
    $("#radio_" + lang).attr("class", "none");
    $("#radio_" + lang).attr("class", "none");
}
/* DİL DEĞİŞTİRME KODLARI - SON */