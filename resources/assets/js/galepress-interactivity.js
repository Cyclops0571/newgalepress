///////////////////////////////////////////////////////////////////////////////////////
// INTERACTIVITY
var cInteractivity = new function () {
    this.objectName = "interactivity";
    var smoothZoomInitialized = false;
    this.doAsyncRequest = function (t, u, d, funcSuccess, funcError) {
        cAjax.doAsyncRequest(t, u, "obj=" + this.objectName + "&" + d, funcSuccess, funcError, true);
    };

    this.clickOk = function () {
        var modalEditor = $("#modal-editor");
        var id = modalEditor.attr("opener");
        var content = CKEDITOR.instances.editor.getData();
        $("#comp-" + id + "-content").val(content);
        $("#modal-mask").addClass("hide");
        modalEditor.addClass("hide").append($('.action'));
        CKEDITOR.instances.editor.destroy();
        $('#wrapper').css('position', 'static');
        $('body').css('overflow', 'auto');
    };

    this.clickCancel = function () {
        var modalEditor = $("#modal-editor");
        $("#modal-mask").addClass("hide");
        modalEditor.addClass("hide").append($('.action'));
        CKEDITOR.instances.editor.destroy();
        $('#wrapper').css('position', 'static');
        $('body').css('overflow', 'auto');
    };

    this.openTransferModal = function (e) {

        var componentID = e.parents("li:first").attr("componentid");
        var pageNo = e.parents("li.page:first").attr("pageno");
        var transferModal = $('.transfer-modal');

        if (typeof componentID === "undefined") {
            transferModal.find('.one').addClass("hide");
            transferModal.find('.all').removeClass("hide");
        } else {
            transferModal.find('.all').addClass("hide");
            transferModal.find('.one').removeClass("hide");
            var componentName = $("a[componentid='" + componentID + "']").html();
            var o = transferModal.find('.one span');
            var t = o.attr("text");
            t = t.replace("{component}", componentName);
            o.html(t);
        }

        $("#transferComponentID").val(componentID);
        $("#transferFrom").val(pageNo);
        transferModal.find('div p strong em').html(pageNo);
        transferModal.find('select option')
            .removeAttr("disabled")
            .eq(parseInt(pageNo) - 1)
            .attr("disabled", "disabled")
            .next()
            .prop('selected', true);

        var transferTo = $("#transferTo");
        if (transferTo.hasClass('chzn-done')) {
            transferTo.removeClass('chzn-done').next().remove();
        }
        transferTo.chosen();
        transferModal.removeClass("hide");
        $("#modal-mask").removeClass("hide");
    };

    this.closeTransferModal = function () {

        $(".transfer-modal").addClass("hide");
        $("#modal-mask").addClass("hide");
    };

    this.transfer = function () {
        var contentFileID = $("#contentfileid").val();
        var componentID = $("#transferComponentID").val();
        var from = $("#transferFrom").val();
        var to = $("#transferTo").val();
        this.saveCurrentPage();
        cInteractivity.showPage($("#pageno").val());

        var t = 'POST';
        var u = '/' + currentLanguage + '/' + route["interactivity_transfer"];
        var d = "contentfileid=" + contentFileID + "&componentid=" + componentID + "&from=" + from + "&to=" + to;
        var ret = cInteractivity.doAsyncRequest(t, u, d);
        if (ret.getValue("success") == "true") {
            this.refreshTree();
            this.clearPage();
            this.closeTransferModal();
        }
        else {
            cNotification.failure(ret.getValue("errmsg"));
        }
    };

    this.openSettings = function () {

        $(".compression-settings").removeClass("hide");
        $("#modal-mask").removeClass("hide");
    };

    this.closeSettings = function (dontUpdate) {

        dontUpdate = (typeof dontUpdate == "undefined") ? false : dontUpdate;

        if (!dontUpdate) {
            var compressionSettingsCheckbox = $(".compression-settings div.checkbox");
            compressionSettingsCheckbox.removeClass("checked");

            if ($("#included").val() == "1") {
                compressionSettingsCheckbox.addClass("checked");
            }
        }

        $(".compression-settings").addClass("hide");
        $("#modal-mask").addClass("hide");
    };

    this.saveSettings = function () {
        var included = $("#included");
        included.val(0);

        if ($(".compression-settings div.checkbox").hasClass("checked")) {
            included.val(1);
        }

        this.closeSettings(true);
    };
    this.refreshTree = function () {
        var contentFileID = $("#contentfileid").val();
        var t = 'POST';
        var u = '/' + currentLanguage + '/' + route["interactivity_refreshtree"];
        var d = "contentfileid=" + contentFileID;
        cInteractivity.doAsyncRequest(t, u, d, function (ret) {
            //Collapse destroy
            $('div.tree a').unbind('click');
            $('#tabs-2').html(ret.getValue("html"));
            //Collapse init
            //initTree();
            $('div.tree').collapse(false, true);
            $('div.tree a.selectcomponent').click(function () {
                cInteractivity.selectComponent($(this));
            });
        });
    };

    this.selectComponent = function (obj) {
        var currentPageNo = $("#pageno").val();
        var pageNo = obj.parents("li.page:first").attr("pageno");

        if (pageNo !== currentPageNo) {
            this.saveCurrentPage();
            this.showPage(pageNo, cInteractivity.selectComponentOnCurrentPage, obj);
        } else {
            this.selectComponentOnCurrentPage(obj);
        }
    };

    this.selectComponentOnCurrentPage = function (obj) {

        var id = obj.attr("componentid");
        var tool = $("#tool-" + id);
        if (!tool.hasClass("selected")) {
            //hide all other components
            $('#component-container').find('.component').addClass("hide");

            //show only selected components
            $('component-container').find('#prop-' + id).removeClass("hide");

            $(".gselectable").removeClass("selected");
            tool.addClass("selected");
        }
    };

    this.deleteComponentOnCurrentPage = function () {
        $("#page div.modal-component, #page div.tooltip-trigger").each(function () {
            var id = $(this).attr("componentid");
            $("#prop-" + id + " div.component-header a.delete").click();
        });
    };

    this.showPage = function (pageno, func, obj) {
        var pageElm = $("#page");
        var sliderElm = $("div.thumblist ul.slideshow-slides li.each-slide");
        var pdfContainer = $("#pdf-container");
        pdfContainer.addClass("loading");
        pageElm.css("display", "none");

        //remove active class
        sliderElm.each(function () {
            $(this).removeClass('active');
        });
        //add active class to current page
        $("div.thumblist ul.slideshow-slides li.each-slide a[pageno='" + pageno + "']").parents("li:first").addClass('active');

        var pageCount = sliderElm.length;

        $("#pageno").val(pageno);
        $("#pdf-page").val(pageno + '/' + pageCount);

        var src = $("div.thumblist ul.slideshow-slides li.each-slide a[pageno='" + pageno + "'] img").attr("src");


        var img = new Image();
        img.onload = function () {

            pageElm.css("background", "url('" + src + "') no-repeat top left")
                .css("width", img.width + "px")
                .css("height", img.height + "px");
            cInteractivity.clearPage();
            cInteractivity.loadPage(pageno, func, obj);

            var h = $(window).innerHeight() - pdfContainer.offset().top - $("footer").outerHeight();


            if (smoothZoomInitialized) {
                pageElm.smoothZoom('Reset');
            } else {
                smoothZoomInitialized = true;
                $('#page').smoothZoom({
                    width: '100%',
                    height: h + 'px',
                    responsive: true,
                    pan_BUTTONS_SHOW: "NO",
                    pan_LIMIT_BOUNDARY: "NO",
                    button_SIZE: 24,
                    button_ALIGN: "top right",
                    zoom_MAX: 500,
                    border_TRANSPARENCY: 0,
                    container: 'pdf-container',
                    max_WIDTH: '',
                    max_HEIGHT: '',
                    animation_SPEED_ZOOM: 0,
                });
            }
        };
        img.src = src;
    };

    this.clearPage = function () {
        var pdfContainer = $("#pdf-container");
        pdfContainer.find(".tooltip-trigger").remove();
        pdfContainer.find(".modal-component").remove();

        $("#component-container").html("");
    };

    this.loadPage = function (pageno, func, obj) {
        return;
        var frm = $("#pagecomponents");
        var t = 'POST';
        var u = '/' + currentLanguage + '/' + route["interactivity_loadpage"];
        var d = cForm.serialize(frm);
        cInteractivity.doAsyncRequest(t, u, d, function (ret) {
            //Sayfa henuz yuklenmeden degistirilirse eski icerikleri gosterme!
            if (parseInt($("#pageno").val()) !== parseInt(pageno)) {
                return;
            }

            $("#page").append(ret.getValue("tool"));
            $("#component-container").html(ret.getValue("prop"));
            //Collapse destroy
            $('div.tree a').unbind('click');

            $("#page div.modal-component, #page div.tooltip-trigger").each(function () {

                var componentName = $(this).attr("componentname");
                var id = $(this).attr("componentid");
                var arr = $(this).attr("data-position").split(',');
                var left = parseInt(arr[0]);
                var top = parseInt(arr[1]);
                var width = parseInt($("#prop-" + id + " input.w").val());
                var height = parseInt($("#prop-" + id + " input.h").val());

                if (componentName == "video" || componentName == "webcontent" || componentName == "slideshow" || componentName == "gal360") {
                    if ($(this).attr("id") == "tool-" + id) {
                        $(this).component({
                            left: left,
                            top: top,
                            width: width,
                            height: height
                        });
                    }
                } else {
                    $(this).component({
                        left: left,
                        top: top,
                        width: width,
                        height: height
                    });
                }
            });

            $('div.tree').collapse(false, true);
            $('div.tree a.selectcomponent').click(function () {
                cInteractivity.selectComponent($(this));
            });

            $("#pdf-container").removeClass("loading");
            $("#page").css("display", "block");

            if (func && (typeof func == "function")) {
                func(obj);
            }
            //$('#saveAndExitBtn').removeAttr("disabled");
            $('#saveAndExitBtn').show();
            $('#saveProgressBar').hide();
            var d = new Date();
            var h = (d.getHours() > 9 ? "" + d.getHours() : "0" + d.getHours());
            var m = (d.getMinutes() > 9 ? "" + d.getMinutes() : "0" + d.getMinutes());
            var second = (d.getSeconds() > 9 ? "" + d.getSeconds() : "0" + d.getSeconds());
            var s = interactivity["autosave"]
                .replace("{hour}", h)
                .replace("{minute}", m)
                .replace("{second}", second);
            $("#pdf-save span.save-info").html(s);
        });
    };

    this.saveCurrentPage = function (successFunction) {
        //$('#saveAndExitBtn').attr("disabled", true);
        $("#pdf-save span.save-info").html('');
        $('#saveAndExitBtn').hide();
        $('#saveProgressBar').show();
        var t = 'POST';
        var u = '/' + currentLanguage + '/' + route["interactivity_save"];
        var d = $("#pagecomponents").serialize();
        var onSuccess = successFunction ? successFunction : function () {
        };
        cInteractivity.doAsyncRequest(t, u, d, onSuccess);
    };

    this.saveAndClose = function () {
        $('#closing').val('true');
        this.saveCurrentPage(function () {
            cInteractivity.close();
        });
    };

    this.close = function () {
        closeInteractiveIDE();
    };

    this.exitWithoutSave = function () {
        this.close();
    };

    this.hideAllInformation = function () {
        $("div.component-info div").addClass("hide");
    };

    this.selectItem = function () {
        $("div.component-info div").addClass("hide");
    };
};