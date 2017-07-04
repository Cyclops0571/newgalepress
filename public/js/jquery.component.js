/* global route, currentLanguage */

(function ($) {
    $.fn.component = function (options) {

        var defaults = {
            compID: '',
            left: 0,
            top: 0,
            width: 100,
            height: 100,
            toolContainer: '#page',
            propContainer: '#component-container',
            triggerPositionChanged: function (tool, prop, from, x, y) {
                $("div.coordinates input.trigger-x", prop).val(x.toFixed(0));
                $("div.coordinates input.trigger-y", prop).val(y.toFixed(0));

                //if changed via property window
                if (from == 'prop') {
                    tool.css("transform", 'translate(' + x.toFixed(14) + 'px, ' + y.toFixed(14) + 'px) scale(1)');
                    //if($("html").hasClass("lt-ie9"))
                    //{
                    //	tool.css("left", x.toFixed(14) + "px");
                    //	tool.css("top", y.toFixed(14) + "px");
                    //}
                    //else
                    //{
                    //	if(jQuery.browser.msie)
                    //	{
                    //		tool.css("-ms-transform", 'translate(' + x.toFixed(14) + 'px, ' + y.toFixed(14) + 'px) scale(1)');
                    //	}
                    //	else if(jQuery.browser.mozilla)
                    //	{
                    //		tool.css("transform", 'translate(' + x.toFixed(14) + 'px, ' + y.toFixed(14) + 'px) scale(1)');
                    //	}
                    //	else if(jQuery.browser.webkit)
                    //	{
                    //		tool.css("-webkit-transform", 'translate(' + x.toFixed(14) + 'px, ' + y.toFixed(14) + 'px) scale(1)');
                    //	}
                    //	else if(jQuery.browser.opera)
                    //	{
                    //		tool.css("-o-transform", 'translate(' + x.toFixed(14) + 'px, ' + y.toFixed(14) + 'px) scale(1)');
                    //	}
                    //}
                }
            },
            positionChanged: function (tool, prop, from, x, y) {
                $("span.xy", tool).html(interactivity["x"] + x.toFixed(0) + '<br>' + interactivity["y"] + y.toFixed(0));
                $("div.coordinates input.x", prop).val(x.toFixed(0));
                $("div.coordinates input.y", prop).val(y.toFixed(0));

                //if changed via property window
                if (from == 'prop') {
                    tool.css("transform", 'translate(' + x.toFixed(14) + 'px, ' + y.toFixed(14) + 'px) scale(1)');
                    //if($("html").hasClass("lt-ie9"))
                    //{
                    //	tool.css("left", x.toFixed(14) + "px");
                    //	tool.css("top", y.toFixed(14) + "px");
                    //}
                    //else
                    //{
                    //	if(jQuery.browser.msie)
                    //	{
                    //		tool.css("-ms-transform", 'translate(' + x.toFixed(14) + 'px, ' + y.toFixed(14) + 'px) scale(1)');
                    //	}
                    //	else if(jQuery.browser.mozilla)
                    //	{
                    //		tool.css("transform", 'translate(' + x.toFixed(14) + 'px, ' + y.toFixed(14) + 'px) scale(1)');
                    //	}
                    //	else if(jQuery.browser.webkit)
                    //	{
                    //		tool.css("-webkit-transform", 'translate(' + x.toFixed(14) + 'px, ' + y.toFixed(14) + 'px) scale(1)');
                    //	}
                    //}
                }
            },
            sizeChanged: function (tool, prop, from, w, h) {
                //fix if neccesary
                //fixWidthHeight(tool, w, h);

                $("span.wh", tool).html(interactivity["w"] + w.toFixed(0) + '<br>' + interactivity["h"] + h.toFixed(0));
                $("div.coordinates input.w", prop).val(w.toFixed(0));
                $("div.coordinates input.h", prop).val(h.toFixed(0));

                //if changed via property window
                if (from == 'prop') {
                    tool.css('width', w.toFixed(0) + 'px');
                    tool.css('height', h.toFixed(0) + 'px');
                }
            },
            selected: function (tool, prop) {
                var componentID = tool.attr("componentid");

                /*
                 console.log('----------------------------------------------------');
                 console.log(tool);
                 console.log('componentID', componentID);
                 */

                //hide all other components
                $(opt.propContainer + " .component").addClass("hide");

                //show only selected components
                $(opt.propContainer + " #prop-" + componentID).removeClass("hide");

                if (!tool.hasClass("selected")) {
                    $(".gselectable").removeClass("selected");
                    tool.addClass("selected");
                }
            },
            remove: function (toolt, tool, prop) {
                var pageNo = $("#pageno").val();
                var componentID = prop.attr("componentid");

                toolt.addClass("hide");
                tool.addClass("hide");
                prop.addClass("hide");

                prop.children("input[name='comp-" + componentID + "-process']").val("removed");

                var pageContainer = $("div#components div.tree");
                var liPage = $("li[pageno='" + pageNo + "']", pageContainer);
                var liPageComponent = $("a[componentid='" + componentID + "']", liPage).parents("li:first");
                var liComponent = liPageComponent.parents("li:first");

                liPageComponent.remove();

                if (liComponent.children("ul").children("li").length == 0) {
                    liComponent.remove();
                }

                if (liPage.children("ul").children("li").length == 0) {
                    liPage.remove();
                }
            }
        };

        var opt = $.extend(defaults, options);

        var createEditor = function (languageCode) {
            if (languageCode = 'usa') {
                languageCode = 'en';
            }
            CKEDITOR.replace('editor', {
                language: languageCode,
                on: {
                    'instanceReady': function (evt) {
                        evt.editor.execCommand('maximize');
                        $('html,body').css('width', '100%').css('height', '100%');
                        // $('#wrapper').css('position','fixed').css('display','none');
                        $('.cke_button__maximize').css('display', 'none');

                        $('.cke_top.cke_reset_all').append($(".action"));
                        $(".action").addClass('ckeditorConfirm');
                        $('.cke_maximized').css('top', '0').css('position', 'fixed');
                        $("#modal-editor").removeClass("hide");
                        $("#modal-mask").removeClass("hide");
                    }
                }
            });
            // CKEDITOR.instances.editor.setData(content);
            // CKEDITOR.instances.editor.addContentsCss("/css/ckeditor/fonts/fonts.css");
        }

        return this.each(function () {
            ///////////////////////////////////////////////////////////////////////////////////////////////
            var isNew = false;
            var id = parseInt($(this).attr("componentid"));
            var componentName = $(this).attr("componentname");
            var pageNo = $("#pageno").val();
            if (id == 0) {
                isNew = true;

                $(opt.propContainer + " .component").each(function () {
                    var tempID = parseInt($(this).children("input[name='compid[]']").val());
                    if (tempID > id) {
                        id = tempID;
                    }
                });
                id = id + 1;
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////
            /*
             var parentRightEdge = getTransformTranslateX($(this));
             var parentBottomEdge = getTransformTranslateY($(this));

             if(opt.left + opt.width > parentRightEdge)
             {
             opt.left = parentRightEdge - opt.width;
             }

             if(opt.top + opt.height > parentBottomEdge)
             {
             opt.top = parentBottomEdge - opt.height;
             }
             */

            if (isNew) {
                var tool = $("script#tool-" + componentName).html()
                    .replaceAll("{id}", id)
                    .replaceAll("{name}", componentName)
                    .replaceAll("{x}", opt.left.toFixed(0))
                    .replaceAll("{y}", opt.top.toFixed(0))
                    .replaceAll("{trigger-x}", opt.left.toFixed(0))
                    .replaceAll("{trigger-y}", opt.top.toFixed(0));

                $(tool).appendTo(opt.toolContainer);

                var prop = $("script#prop-" + componentName).html().replaceAll("{id}", id);
                $(prop).appendTo(opt.propContainer);
                $("#prop-" + id)
                    .attr("componentID", id)
                    .removeClass("hide");

                //$("#prop-" + id + " input[name='compid[]']").val(id);
            }

            var scale = getScale();
            /*
             console.log('*************');
             console.log(id);
             console.log($("#tool-" + id));
             console.log($("#tool-" + id).length);

             console.log($("#tool-" + id + "-trigger"));
             console.log($("#tool-" + id + "-trigger").length);
             */


            $("#tool-" + id)
                .css('width', opt.width + 'px')
                .css('height', opt.height + 'px')
                .attr("componentid", id)
                .draggable({
                    containment: opt.toolContainer,
                    scroll: false,
                    drag: function (event, ui) {
                        var componentID = ui.helper.attr("componentid");
                        var tool = $("#tool-" + componentID);
                        var prop = $("#prop-" + componentID);
                        var container = $(opt.toolContainer);
                        var left = getTransformTranslateX(ui.helper); //ui.offset.left - container.offset().left;
                        var top = getTransformTranslateY(ui.helper); //ui.offset.top - container.offset().top;

                        opt.selected(tool, prop);
                        opt.positionChanged(tool, prop, 'tool', left, top);
                    }
                })
                .resizable({
                    containment: opt.toolContainer,
                    handles: "se",
                    resize: function (event, ui) {
                        var componentID = ui.helper.attr("componentid");
                        var tool = $("#tool-" + componentID);
                        var prop = $("#prop-" + componentID);

                        opt.selected(tool, prop);
                        opt.sizeChanged(tool, prop, 'tool', ui.size.width, ui.size.height);
                    }
                })
                .gselectable({
                    selected: function (e) {
                        var componentID = e.attr("componentid");
                        var tool = $("#tool-" + componentID);
                        var prop = $("#prop-" + componentID);

                        opt.selected(tool, prop);
                    }
                });

            $("#tool-" + id + "-trigger")
                .css('width', '30px')
                .css('height', '30px')
                .attr("componentid", id)
                .draggable({
                    containment: opt.toolContainer,
                    scroll: false,
                    drag: function (event, ui) {
                        var componentID = ui.helper.attr("componentid");
                        var tool = $("#tool-" + componentID + "-trigger");
                        var prop = $("#prop-" + componentID);
                        var container = $(opt.toolContainer);
                        var left = getTransformTranslateX(ui.helper); //ui.offset.left - container.offset().left;
                        var top = getTransformTranslateY(ui.helper); //ui.offset.top - container.offset().top;

                        opt.selected(tool, prop);
                        opt.triggerPositionChanged(tool, prop, 'tool', left, top);
                    }
                })
                .gselectable({
                    selected: function (e) {
                        var componentID = e.attr("componentid");
                        var tool = $("#tool-" + componentID + "-trigger");
                        var prop = $("#prop-" + componentID);

                        opt.selected(tool, prop);
                    }
                });

            if (isNew) {
                //Collapse destroy
                $('div.tree a').unbind('click');

                //Add to tree
                var pageContainer = $("div#components div.tree");
                var liPage = $("li[pageno='" + pageNo + "']", pageContainer);
                if (liPage.length == 0) {
                    //add page
                    var s = '';
                    s = s + '<li data-collapse="" class="page" pageno="' + pageNo + '">';
                    s = s + '<a href="#"><i class="icon-"></i> ' + interactivity['page'] + " " + pageNo + '</a>';
                    s = s + '<ul class="close"></ul>';
                    s = s + '<i class="icon-exchange transfer" onclick="cInteractivity.openTransferModal($(this));"></i>';
                    s = s + '</li>';
                    $("ul:first", pageContainer).append(s);
                    liPage = $("li[pageno='" + pageNo + "']", pageContainer);
                }

                var liComponent = $("li[componentname='" + componentName + "']", liPage);
                if (liComponent.length == 0) {
                    //add component
                    var s = '';
                    s = s + '<li data-collapse="" class="component" componentname="' + componentName + '">';
                    s = s + '<a href="#" id="tree-' + componentName + '"><i class="icon-"></i> ' + interactivity[componentName + '_name'] + '</a>';
                    s = s + '<ul class="close"></ul>';
                    s = s + '</li>';
                    $("ul:first", liPage).append(s);
                    liComponent = $("li[componentname='" + componentName + "']", liPage);
                }

                //add page component
                $("ul:first", liComponent).append('<li componentid="' + id + '" style="position:relative;"><a href="#" class="selectcomponent" componentid="' + id + '">' + interactivity[componentName + '_componentid'] + id + '</a><i class="icon-exchange transfer" onclick="cInteractivity.openTransferModal($(this));"></i></li>');

                //Collapse init
                $('div.tree').collapse(false, true);
                $('div.tree a.selectcomponent').click(function () {
                    cInteractivity.selectComponent($(this));
                });
            }

            if ($("#tool-" + id).length) {
                $("#page").smoothZoom('attachLandmark', ["tool-" + id]);
            }

            if ($("#tool-" + id + "-trigger").length) {
                $("#page").smoothZoom('attachLandmark', ["tool-" + id + "-trigger"]);
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////
            //SCF
            ///////////////////////////////////////////////////////////////////////////////////////////////
            //Customer select
            $("#prop-" + id + " .js-select").chosen();

            //Custom checkboxes
            //console.log($("#prop-" + id + " .js-checkbox"));
            var checkboxes = new SCF.Checkbox("#prop-" + id + " .js-checkbox");
            checkboxes.init();

            //Custom radios
            var radioGroupIndex = 0;
            $("#prop-" + id + " .radiogroup").each(function () {
                //var selector = "js-radiogroup-" + radioGroupIndex;
                var selector = "js-radiogroup-" + id + '-' + radioGroupIndex;
                $(this).addClass(selector);
                var radioGroup = new SCF.Radio("." + selector);
                radioGroup.init();
                radioGroupIndex = radioGroupIndex + 1;
            });

            //Custom tooltips
            $("#prop-" + id + " .tooltip").tooltip({
                position: {
                    my: "center bottom-20",
                    at: "center top",
                    using: function (position, feedback) {
                        $(this).css(position);
                        $("<div>")
                            .addClass("arrow")
                            .addClass(feedback.vertical)
                            .addClass(feedback.horizontal)
                            .appendTo(this);
                    }
                }
            });
            ///////////////////////////////////////////////////////////////////////////////////////////////
            //sizeChanged
            var toolt = $("#tool-" + id + "-trigger");
            var tool = $("#tool-" + id);
            var prop = $("#prop-" + id);

            if (toolt.length > 0) {
                opt.triggerPositionChanged(toolt, prop, 'tool', opt.left, opt.top);
            }
            else {
                opt.sizeChanged(tool, prop, 'tool', opt.width, opt.height);
            }
            opt.selected(tool, prop);
            if (!tool.attr("componentid") && toolt.attr('componentid') > 0) {
                $(opt.propContainer + " #prop-" + toolt.attr('componentid')).removeClass("hide");
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////
            //modal
            var modalElement = $("#prop-" + id + " [name='comp-" + id + "-modal']");
            if (modalElement.length == 1) {

                modalElement.parents("div:first").click(function () {
                    //var componentID = $(this).parents("div.component:first").attr("componentid");
                    //var toolt = $("#tool-" + componentID + "-trigger");
                    //var tool = $("#tool-" + componentID);
                    //var prop = $("#prop-" + componentID);
                    var checked = $("input[type='hidden']", $(this)).val();
                    if (checked == '1') {
                        //toolt.removeClass("hide");
                        //tool.addClass("hide");
                        //$("div.coordinates", prop).addClass("hide");
                        //$("div.coordinates-trigger", prop).removeClass("hide");
                        $("#comp-" + id + "-videodelay").parent().addClass('hide');
                        $("div.selectfromfile").removeClass("hide");
                        $("div.upload-modalicon").addClass("hide");
                    }
                    else {
                        //toolt.addClass("hide");
                        //tool.removeClass("hide");
                        //$("div.coordinates", prop).removeClass("hide");
                        //$("div.coordinates-trigger", prop).addClass("hide");
                        $("#comp-" + id + "-videodelay").parent().removeClass('hide');
                        $("div.selectfromfile").addClass("hide");
                        $("div.upload-modalicon").removeClass("hide");
                    }
                });

                //assign upload event
                var fileTypeDesc = 'Image Files';
                var fileTypeExt = '*.jpg;*.png;*.gif;*.jpeg';
                var formData = 'uploadimage';

                $("#prop-" + id + " input[type='file']#comp-" + id + "-modalicon").fileupload({
                    url: '/' + currentLanguage + '/' + route["interactivity_upload"],
                    dataType: 'json',
                    sequentialUploads: true,
                    formData: {
                        'type': formData,
                        'element': 'comp-' + id + '-modalicon'
                    },
                    add: function (e, data) {
                        if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name)) {
                            $("#prop-" + id + " div.selectfromfile").addClass("hide");
                            $("#prop-" + id + " div.upload-modalicon").removeClass("hide");
                            $("#prop-" + id + " div.upload-modalicon div.progress").removeClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-modaliconselected").val("1");

                            data.context = $("#prop-" + id + " div.upload-modalicon div.progress");
                            data.context.find('a').click(function (e) {
                                e.preventDefault();
                                var template = $("#prop-" + id + " div.upload-modalicon div.progress");
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

                        $("#prop-" + id + " div.upload-modalicon div.progress label").html(interactivity["video_uploading"] + ' ' + progress.toFixed(0) + '%');
                        $("#prop-" + id + " div.upload-modalicon div.progress div.scale").css('width', progress.toFixed(0) + '%');
                    },
                    done: function (e, data) {
                        if (data.textStatus == 'success') {
                            var fileName = data.result['comp-' + id + '-modalicon'][0].name;

                            $("#prop-" + id + " input#comp-" + id + "-modaliconname").val(fileName);

                            $("#prop-" + id + " div.upload-modalicon div.progress").addClass("hide");
                            $("#prop-" + id + " div.upload-modalicon a.modal-icon")
                                .attr("href", "/files/temp/" + fileName)
                                .html(fileName.length > 17 ? fileName.substring(0, 17) : fileName)
                                .removeClass("hide");

                            $("#prop-" + id + " div.upload-modalicon a.close").removeClass("hide");
                        }
                    },
                    fail: function (e, data) {
                        if (data.textStatus == "abort") {
                            $("#prop-" + id + " div.selectfromfile").removeClass("hide");
                            $("#prop-" + id + " div.upload-modalicon div.progress").addClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-modaliconselected").val("0");
                        }
                        else {
                            $("#prop-" + id + " div.upload-modalicon span.error").removeClass("hide");
                        }
                    }
                });

                //select file
                $("#prop-" + id + " a.uploadmodalicon").click(function () {
                    $("#prop-" + id + " div.selectfromfile input[type='file']").click();
                });

                //delete modal icon
                $("#prop-" + id + " div.upload-modalicon a.close").click(function () {

                    $("#prop-" + id + " div.selectfromfile").removeClass("hide").removeClass("hidden");
                    $("#prop-" + id + " div.selectfromfile a.uploadmodalicon").removeClass("hide");

                    $("#prop-" + id + " div.upload-modalicon a.modal-icon").addClass("hide");
                    $("#prop-" + id + " div.upload-modalicon a.close").addClass("hide");

                    $("#prop-" + id + " input#comp-" + id + "-modaliconselected").val("0");
                    $("#prop-" + id + " input#comp-" + id + "-modaliconname").val("");
                });


                if (componentName == "video" || componentName == "webcontent" || componentName == "slideshow" || componentName == "gal360") {
                    //$("div.coordinates-trigger", prop).addClass("hide");
                    $("#comp-" + id + "-videodelay").parent().removeClass('hide');
                }
                if (modalElement.val() == "1") {
                    //var toolt = $("#tool-" + id + "-trigger");
                    //var tool = $("#tool-" + id);
                    //var prop = $("#prop-" + id);
                    //toolt.removeClass("hide");
                    //tool.addClass("hide");
                    //$("div.coordinates", prop).addClass("hide");
                    //$("div.coordinates-trigger", prop).removeClass("hide");
                    $("#comp-" + id + "-videodelay").parent().addClass('hide');
                }
            }

            //transparent
            var modalTransparent = $("#prop-" + id + " [name='comp-" + id + "-transparent']");
            if (modalTransparent.length == 1) {

                $("#prop-" + id + " [name='comp-" + id + "-transparent']").parent().click(function () {
                    var checked = $("input", $(this)).val();
                    if (checked == '1') {
                        $("[name='comp-" + id + "-bgcolor']").parent().addClass('hide');
                    }
                    else {
                        $("[name='comp-" + id + "-bgcolor']").parent().removeClass('hide');
                    }
                });
            }

            //Color picker
            $("#prop-" + id + " [name='comp-" + id + "-bgcolor']").colorPicker({
                pickerDefault: '151515'
            });

            $("#prop-" + id + " [name='comp-" + id + "-iconcolor']").colorPicker({
                pickerDefault: '151515'
            });

            //remove event (common)
            $("#prop-" + id + " a.remove").click(function () {
                var componentID = $(this).parents("div.component:first").attr("componentid");
                var toolt = $("#tool-" + componentID + "-trigger");
                var tool = $("#tool-" + componentID);
                var prop = $("#prop-" + componentID);

                opt.remove(toolt, tool, prop);
            });

            //video & audio
            if (componentName == "video" || componentName == "audio" || componentName == "animation") {
                //HAKAN
                if (componentName == "animation") {
                    //animation effect
                    var effectElement = $("#comp-" + id + "-effect");

                    if (effectElement.length == 1) {
                        effectElement.on('change', function () {
                            var str = "";
                            str = $("#comp-" + $(this).attr('no') + "-effect option:selected").val();
                            var componentID = $(this).attr('no');
                            if (str == "fade") {
                                $("#comp-" + componentID + "-animefade").removeClass('hide');
                            }
                            else {
                                $("#comp-" + componentID + "-animefade").addClass('hide');
                                $("#comp-" + componentID + "-animefade").removeClass('checked');
                                $("#comp-" + componentID + "-animefade").find("input[type=hidden]").attr('value', 0);
                            }
                        })
                    }

                    var effectOptionControl = "";
                    effectOptionControl = $("#comp-" + id + "-effect option:selected").val();

                    if (effectOptionControl == "fade") {
                        if ($("#comp-" + id + "-animefade").attr('no') == 0) {
                            $("#comp-" + id + "-animefade").removeClass('checked');
                            $("#comp-" + id + "-animefade").find("input[type=hidden]").attr('value', 0);
                        }
                        else {
                            $("#comp-" + id + "-animefade").addClass('checked');
                            $("#comp-" + id + "-animefade").find("input[type=hidden]").attr('value', 1);
                        }
                    }
                }

                $("#prop-" + id + " div.upload div.radiogroup div.js-radio").click(function () {
                    var value = $(this).attr("optionvalue");

                    $("#prop-" + id + " div.upload div.local").addClass("hide");
                    $("#prop-" + id + " div.upload div.web").addClass("hide");

                    if (value == "1") {
                        $("#prop-" + id + " div.upload div.local").removeClass("hide");
                    }
                    else {
                        $("#prop-" + id + " div.upload div.web").removeClass("hide");
                    }
                });

                //assign upload event
                var fileTypeDesc = '';
                var fileTypeExt = '';
                var formData = '';

                if (componentName == "video") {

                    fileTypeDesc = 'Video Files';
                    fileTypeExt = '*.mp4';
                    formData = 'uploadvideofile';
                }
                else if (componentName == "audio") {
                    fileTypeDesc = 'Audio Files';
                    fileTypeExt = '*.mp3';
                    formData = 'uploadaudiofile';
                }
                else {
                    fileTypeDesc = 'Image Files';
                    fileTypeExt = '*.jpg;*.png;*.gif;*.jpeg';
                    formData = 'uploadimage';
                }


                $("#prop-" + id + " div.upload input[type='file']").fileupload({
                    url: '/' + currentLanguage + '/' + route["interactivity_upload"],
                    dataType: 'json',
                    sequentialUploads: true,
                    formData: {
                        'type': formData,
                        'element': 'comp-' + id + '-file'
                    },
                    add: function (e, data) {
                        if (componentName == "video") {
                            if ((/\.(mp4)$/i).test(data.files[0].name)) {
                                $("#prop-" + id + " div.upload div.local").addClass("hide");
                                $("#prop-" + id + " div.upload div.progress").removeClass("hide");
                                $("#prop-" + id + " input#comp-" + id + "-fileselected").val("1");

                                data.context = $("#prop-" + id + " div.upload div.progress");
                                data.context.find('a').click(function (e) {
                                    e.preventDefault();
                                    var template = $("#prop-" + id + " div.upload div.progress");
                                    data = template.data('data') || {};
                                    if (data.jqXHR) {
                                        data.jqXHR.abort();
                                    }
                                });
                                var xhr = data.submit();
                                data.context.data('data', {jqXHR: xhr});
                            }
                        }
                        else if (componentName == "audio") {
                            if ((/\.(mp3)$/i).test(data.files[0].name)) {
                                $("#prop-" + id + " div.upload div.local").addClass("hide");
                                $("#prop-" + id + " div.upload div.progress").removeClass("hide");
                                $("#prop-" + id + " input#comp-" + id + "-fileselected").val("1");

                                data.context = $("#prop-" + id + " div.upload div.progress");
                                data.context.find('a').click(function (e) {
                                    e.preventDefault();
                                    var template = $("#prop-" + id + " div.upload div.progress");
                                    data = template.data('data') || {};
                                    if (data.jqXHR) {
                                        data.jqXHR.abort();
                                    }
                                });
                                var xhr = data.submit();
                                data.context.data('data', {jqXHR: xhr});
                            }
                        }
                        else if (componentName == "animation") {
                            if ((/\.(jpg)$/i).test(data.files[0].name) || (/\.(jpeg)$/i).test(data.files[0].name) || (/\.(gif)$/i).test(data.files[0].name) || (/\.(png)$/i).test(data.files[0].name)) {
                                $("#prop-" + id + " div.upload div.local").addClass("hide");
                                $("#prop-" + id + " div.upload div.progress").removeClass("hide");
                                $("#prop-" + id + " input#comp-" + id + "-fileselected").val("1");

                                data.context = $("#prop-" + id + " div.upload div.progress");
                                data.context.find('a').click(function (e) {
                                    e.preventDefault();
                                    var template = $("#prop-" + id + " div.upload div.progress");
                                    data = template.data('data') || {};
                                    if (data.jqXHR) {
                                        data.jqXHR.abort();
                                    }
                                });
                                var xhr = data.submit();
                                data.context.data('data', {jqXHR: xhr});

                            }
                        }
                    },
                    progressall: function (e, data) {
                        var progress = data.loaded / data.total * 100;

                        $("#prop-" + id + " div.upload div.progress label").html(interactivity["video_uploading"] + ' ' + progress.toFixed(0) + '%');
                        $("#prop-" + id + " div.upload div.progress div.scale").css('width', progress.toFixed(0) + '%');
                        $("#prop-" + id + " div.upload span.error").addClass("hide");
                    },
                    done: function (e, data) {
                        if (data.textStatus == 'success') {
                            var shortenFileName = "";
                            if (data.result['comp-' + id + '-file'][0].name.length > 26) {
                                shortenFileName = data.result['comp-' + id + '-file'][0].name.substring(0, 26) + '...';
                            }
                            else {
                                shortenFileName = data.result['comp-' + id + '-file'][0].name;
                            }
                            $("#prop-" + id + " div.upload").addClass("hide");

                            $("#prop-" + id + " input#comp-" + id + "-filename").val(data.result['comp-' + id + '-file'][0].name);
                            $("#prop-" + id + " div.settings div.properties div.file-header h4").html(shortenFileName);
                            var fileSize = '';
                            if (data.result['comp-' + id + '-file'][0].size > 1024 * 1024) {
                                fileSize = (data.result['comp-' + id + '-file'][0].size / (1024 * 1024)).toFixed(1) + " MB";
                            } else if (data.result['comp-' + id + '-file'][0].size > 1024) {
                                fileSize = (data.result['comp-' + id + '-file'][0].size / 1024 ).toFixed(1) + " KB";
                            } else if (data.result['comp-' + id + '-file'][0].size > 0) {
                                fileSize = data.result['comp-' + id + '-file'][0].size + " Bytes";
                            } else {
                                fileSize = "0 Bytes";
                            }

                            $("#prop-" + id + " div.settings div.properties div.file-header span").html(fileSize);
                            $("#prop-" + id + " div.upload div.progress").addClass("hide");
                            $("#prop-" + id + " div.settings div.properties").removeClass("hide");
                        }
                    },
                    fail: function (e, data) {
                        if (data.textStatus == "abort") {
                            $("#prop-" + id + " div.upload div.local").removeClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-fileselected").val("0");
                        }
                        else {
                            $("#prop-" + id + " div.upload span.error").removeClass("hide");
                            if ((data.files[0].size / 1024) / 1024 > 250) {
                                $("#prop-" + id + " div.upload span.error").addClass("hide");
                                $("#prop-" + id + " div.upload span.error.max-size").removeClass("hide");
                            }
                        }
                        $("#prop-" + id + " div.upload div.progress").addClass("hide");
                    }
                });

                //select file
                $("#prop-" + id + " a.uploadfile").click(function () {

                    $("#prop-" + id + " div.upload input[type='file']").click();
                });

                //check url
                $("#prop-" + id + " div.upload div.web a.btn").click(function () {

                    var url = $('#comp-' + id + '-url').val();
                    var valid = false;

                    if (url.length > 0) {
                        if (componentName == "video") {
                            valid = url.endsWith(".mp4") || url.indexOf("www.youtube.com/embed") > -1 || url.indexOf("www.youtube.com/watch") > -1 || url.indexOf("player.vimeo.com/video") > -1;
                        }
                        else if (componentName == "audio") {
                            valid = url.endsWith(".mp3");
                        }
                        else {
                            valid = url.endsWith(".jpeg") || url.endsWith(".jpg") || url.endsWith(".gif") || url.endsWith(".png");
                        }
                    }

                    $("#prop-" + id + " div.web span.success").addClass("hide");
                    $("#prop-" + id + " div.web span.error").addClass("hide");

                    if (valid) {
                        if (isUrlReachable(url)) {
                            var urlFile = url.split('/');
                            $("#prop-" + id + " div.web span.success").removeClass("hide");
                            $("#prop-" + id + " div.web span.success").fadeOut(2000);
                            $("#prop-" + id + " div.settings div.properties div.file-header h4").html(urlFile[urlFile.length - 1]);
                            $("#prop-" + id + " div.settings div.properties").removeClass("hide");
                        }
                        else {
                            $("#prop-" + id + " div.web span.error").removeClass("hide");
                        }
                    }
                    else {
                        $("#prop-" + id + " div.web span.error").removeClass("hide");
                    }
                });

                //delete file
                $("#prop-" + id + " div.properties a.delete").click(function () {

                    $("#prop-" + id + " div.upload").removeClass("hide");
                    $("#prop-" + id + " div.upload div.radiogroup").removeClass("hide");
                    $("#prop-" + id + " div.upload div.radiogroup div[optionvalue='1']").click();
                    $("#prop-" + id + " div.upload div.local").removeClass("hide");
                    $("#prop-" + id + " div.upload div.web").addClass("hide");
                    $("#prop-" + id + " div.upload div.progress").addClass("hide");
                    $("#prop-" + id + " div.upload div.error").addClass("hide");
                    $("#prop-" + id + " input#comp-" + id + "-fileselected").val("0");
                    $("#prop-" + id + " input#comp-" + id + "-filename").val("");
                    $("#prop-" + id + " input#comp-" + id + "-posterimageselected").val("0");
                    $("#prop-" + id + " input#comp-" + id + "-posterimagename").val("");
                    $("#prop-" + id + " div.settings div.properties").addClass("hide");
                });
                ///////////////////////////////////////////////////////////////////////////////////////////////
                //poster image
                $("#prop-" + id + " div.properties div.radiogroup div.js-radio").click(function () {
                    var value = $(this).attr("optionvalue");

                    $("#prop-" + id + " div.properties div.fromfile").addClass("hide");

                    if (value == "2") {
                        $("#prop-" + id + " div.properties div.fromfile").removeClass("hide");
                        $("#prop-" + id + " div.properties a.poster-image").addClass("hide");
                        $("#prop-" + id + " div.properties a.close").addClass("hide");
                    }
                });

                //assign upload event for poster image

                $("#prop-" + id + " div.properties input[type='file']#comp-" + id + "-posterimage").fileupload({
                    url: '/' + currentLanguage + '/' + route["interactivity_upload"],
                    dataType: 'json',
                    sequentialUploads: true,
                    formData: {
                        'type': 'uploadimage',
                        'element': 'comp-' + id + '-posterimage'
                    },
                    add: function (e, data) {
                        if ((/\.(gif|jpg|jpeg|tiff|png)$/i).test(data.files[0].name)) {
                            $("#prop-" + id + " div.properties div.fromfile").addClass("hide");
                            $("#prop-" + id + " div.properties div.upload-poster div.progress").removeClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-posterimageselected").val("1");

                            data.context = $("#prop-" + id + " div.upload-poster div.progress");
                            data.context.find('a').click(function (e) {
                                e.preventDefault();
                                var template = $("#prop-" + id + " div.upload-poster div.progress");
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

                        $("#prop-" + id + " div.properties div.progress label").html(interactivity["video_uploading"] + ' ' + progress.toFixed(0) + '%');
                        $("#prop-" + id + " div.properties div.progress div.scale").css('width', progress.toFixed(0) + '%');
                    },
                    done: function (e, data) {
                        if (data.textStatus == 'success') {
                            $("#prop-" + id + " input#comp-" + id + "-posterimagename").val(data.result['comp-' + id + '-posterimage'][0].name);

                            $("#prop-" + id + " div.properties div.upload-poster div.progress").addClass("hide");
                            $("#prop-" + id + " div.properties div.upload-poster a.poster-image")
                                .attr("href", "/files/temp/" + data.result['comp-' + id + '-posterimage'][0].name)
                                .html(data.result['comp-' + id + '-posterimage'][0].name)
                                .removeClass("hide");

                            $("#prop-" + id + " div.properties div.upload-poster a.close").removeClass("hide");
                        }
                    },
                    fail: function (e, data) {
                        if (data.textStatus == "abort") {
                            $("#prop-" + id + " div.properties div.fromfile").removeClass("hide");
                            $("#prop-" + id + " div.properties div.progress").addClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-posterimageselected").val("0");
                        }
                        else {
                            $("#prop-" + id + " div.properties span.error").removeClass("hide");
                        }
                    }
                });

                //select poster image
                $("#prop-" + id + " a.uploadposterimage").click(function () {
                    $("#prop-" + id + " div.properties input[type='file']#comp-" + id + "-posterimage").click();
                });

                //delete poster image
                $("#prop-" + id + " div.properties div.upload-poster a.close").click(function () {

                    $("#prop-" + id + " div.properties div.fromfile").removeClass("hide");
                    $("#prop-" + id + " div.properties div.upload-poster a.poster-image").addClass("hide");
                    $("#prop-" + id + " div.properties div.upload-poster a.close").addClass("hide");

                    $("#prop-" + id + " input#comp-" + id + "-posterimageselected").val("0");
                    $("#prop-" + id + " input#comp-" + id + "-posterimagename").val("");
                });
                ///////////////////////////////////////////////////////////////////////////////////////////////
            }
            else if (componentName == "map") {
                //map
                $("#prop-" + id + " a.btn").click(function () {
                    var valid = false;
                    var type = $('#comp-' + id + '-type').val();
                    var url = $('#comp-' + id + '-url').val();

                    if (url.length > 0) {
                        if (type == "1") {
                            valid =
                                url.startsWith("http://goo.gl/maps/") ||
                                url.startsWith("https://goo.gl/maps/") ||
                                url.startsWith("http://maps.google.com/") ||
                                url.startsWith("https://maps.google.com/");
                        }
                        else if (type == "2") {
                            //http://binged.it/16Pf6cm
                            //http://www.bing.com/maps/?v=2&cp=qtwcq6kdm464&lvl=15&dir=0&sty=b&trfc=1&form=LMLTCC
                            valid =
                                url.startsWith("http://binged.it/") ||
                                url.startsWith("https://binged.it/") ||
                                url.startsWith("http://www.bing.com/maps/") ||
                                url.startsWith("https://www.bing.com/maps/");
                        }
                        else if (type == "3") {
                            //http://maps.yandex.com/-/CVVBMZ6F
                            //http://harita.yandex.com.tr/-/CVVeYMzM
                            valid =
                                url.startsWith("http://maps.yandex.com/") ||
                                url.startsWith("https://maps.yandex.com/") ||
                                url.startsWith("http://harita.yandex.com.tr/") ||
                                url.startsWith("https://harita.yandex.com.tr/");
                        }
                    }

                    $("#prop-" + id + " span.success").addClass("hide");
                    $("#prop-" + id + " span.error").addClass("hide");

                    if (valid) {
                        if (isUrlReachable(url)) {
                            $("#prop-" + id + " span.success").removeClass("hide");
                        }
                        else {
                            $("#prop-" + id + " span.error").removeClass("hide");
                        }
                    }
                    else {
                        $("#prop-" + id + " span.error").removeClass("hide");
                    }
                });
            }
            else if (componentName == "link") {
                //link
                $("#prop-" + id + " div.js-radio").click(function () {
                    var value = parseInt($(this).attr("optionvalue"));
                    switch (value) {
                        case 1:
                            $("#prop-" + id + " div.topage").removeClass("hide");
                            $("#prop-" + id + " div.tourl").addClass("hide");
                            $("#prop-" + id + " div.tomail").addClass("hide");
                            break;
                        case 2:
                            $("#prop-" + id + " div.topage").addClass("hide");
                            $("#prop-" + id + " div.tourl").removeClass("hide");
                            $("#prop-" + id + " div.tomail").addClass("hide");
                            break;
                        case 3:
                            $("#prop-" + id + " div.topage").addClass("hide");
                            $("#prop-" + id + " div.tourl").addClass("hide");
                            $("#prop-" + id + " div.tomail").removeClass("hide");
                            break;
                    }
                });

                $("#prop-" + id + " a.to-url").click(function () {
                    var url = $('#comp-' + id + '-url').val();
                    var valid = (url.length > 0);

                    $("#prop-" + id + " span.success.to-url").addClass("hide");
                    $("#prop-" + id + " span.error.to-url").addClass("hide");

                    if (valid) {
                        if (isUrlReachable(url)) {
                            $("#prop-" + id + " span.success.to-url").removeClass("hide");
                        }
                        else {
                            $("#prop-" + id + " span.error.to-url").removeClass("hide");
                        }
                    } else {
                        $("#prop-" + id + " span.error.to-url").removeClass("hide");
                    }
                });

                $("#prop-" + id + " a.to-mail").click(function () {
                    var mail = $('#comp-' + id + '-mail').val();
                    var valid = (mail.length > 0);

                    $("#prop-" + id + " span.success.to-mail").addClass("hide");
                    $("#prop-" + id + " span.error.to-mail").addClass("hide");

                    if (valid) {
                        if (isValidEmailAddress(mail)) {
                            $("#prop-" + id + " span.success.to-mail").removeClass("hide");
                        } else {
                            $("#prop-" + id + " span.error.to-mail").removeClass("hide");
                        }
                    } else {
                        $("#prop-" + id + " span.error.to-mail").removeClass("hide");
                    }
                });

            }
            else if (componentName == "webcontent") {
                //webcontent
                $("#prop-" + id + " a.btn.postfix").click(function () {
                    var url = $('#comp-' + id + '-url').val();
                    var valid = (url.length > 0);

                    $("#prop-" + id + " span.success").addClass("hide");
                    $("#prop-" + id + " span.error").addClass("hide");

                    if (valid) {
                        if (isUrlReachable(url)) {
                            $("#prop-" + id + " span.success").removeClass("hide");
                        }
                        else {
                            $("#prop-" + id + " span.error").removeClass("hide");
                        }
                    }
                    else {
                        $("#prop-" + id + " span.error").removeClass("hide");
                    }
                });
            }
            else if (componentName == "tooltip") {
                //tooltip
                $("#prop-" + id + " a.edit, #tool-" + id + " a.edit").click(function () {
                    // $( "#wrapper" ).fadeOut( 250, function() {
                    var content = $("#comp-" + id + "-content").val();
                    $("#modal-editor textarea").val(content);
                    $("#modal-editor").attr("opener", id);
                    // $("#editor").redactor();
                    // console.log(content);
                    createEditor(currentLanguage);
                });

                $("#prop-" + id + " div.upload div.radiogroup div.js-radio").click(function () {
                    var value = $(this).attr("optionvalue");

                    $("#prop-" + id + " div.icon1").addClass("hide");
                    $("#prop-" + id + " div.icon2").addClass("hide");

                    if (value == "1") {
                        $("#prop-" + id + " div.icon1").addClass("hide");
                        $("#prop-" + id + " div.icon2").addClass("hide");
                        $("#prop-" + id + " div.upload-icon1").addClass("hide");
                        $("#prop-" + id + " div.upload-icon2").addClass("hide");
                    }
                    else {
                        $("#prop-" + id + " div.icon1").removeClass("hide");
                        $("#prop-" + id + " div.icon2").removeClass("hide");
                        $("#prop-" + id + " div.upload-icon1").removeClass("hide");
                        $("#prop-" + id + " div.upload-icon2").removeClass("hide");
                    }
                });

                $("#prop-" + id + " div.upload-icon1 a.close").click(function () {

                    $("#prop-" + id + " div.icon1").removeClass("hide");
                    $("#prop-" + id + " div.icon1 a.uploadfile").removeClass("hide");

                    $("#prop-" + id + " div.upload-icon1 a.tooltip-icon1").addClass("hide");
                    $("#prop-" + id + " div.upload-icon1 a.close").addClass("hide");

                    $("#prop-" + id + " input#comp-" + id + "-fileselected").val("0");
                    $("#prop-" + id + " input#comp-" + id + "-filename").val("");
                });

                //FOR UNFOCUSED TOOLTIP ICON
                //assign upload event
                var fileTypeDesc = 'Image Files';
                var fileTypeExt = '*.jpg;*.png;*.gif;*.jpeg';
                var formData = 'uploadimage';


                $("#prop-" + id + " div.icon1 input[type='file']").fileupload({
                    url: '/' + currentLanguage + '/' + route["interactivity_upload"],
                    dataType: 'json',
                    sequentialUploads: true,
                    formData: {
                        'type': formData,
                        'element': 'comp-' + id + '-file'
                    },
                    add: function (e, data) {
                        if ((/\.(jpg)$/i).test(data.files[0].name) || (/\.(jpeg)$/i).test(data.files[0].name) || (/\.(gif)$/i).test(data.files[0].name) || (/\.(png)$/i).test(data.files[0].name)) {
                            $("#prop-" + id + " div.upload-icon1").removeClass("hide");
                            $("#prop-" + id + " div.upload-icon1 div.progress").removeClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-fileselected").val("1");

                            data.context = $("#prop-" + id + " div.upload-icon1 div.progress");
                            data.context.find('a').click(function (e) {
                                e.preventDefault();
                                var template = $("#prop-" + id + " div.upload-icon1 div.progress");
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

                        $("#prop-" + id + " div.upload-icon1 div.progress label").html(interactivity["video_uploading"] + ' ' + progress.toFixed(0) + '%');
                        $("#prop-" + id + " div.upload-icon1 div.progress div.scale").css('width', progress.toFixed(0) + '%');
                    },
                    done: function (e, data) {
                        if (data.textStatus == 'success') {
                            var fileName = data.result['comp-' + id + '-file'][0].name;
                            $("#prop-" + id + " div.icon1").addClass("hide");
                            $("#prop-" + id + " div.upload-icon1").addClass("hide");

                            $("#prop-" + id + " input#comp-" + id + "-filename").val(data.result['comp-' + id + '-file'][0].name);
                            $("#prop-" + id + " div.settings div.properties div.file-header h4").html(data.result['comp-' + id + '-file'][0].name);
                            $("#prop-" + id + " div.settings div.properties div.file-header span").html((data.result['comp-' + id + '-file'][0].size / (1024 * 1024)).toFixed(1) + " MB");
                            $("#prop-" + id + " div.upload-icon1 div.progress").addClass("hide");
                            $("#prop-" + id + " div.settings div.properties").removeClass("hide");

                            $("#prop-" + id + " div.upload-icon1").removeClass("hide");
                            $("#prop-" + id + " a.tooltip-icon1")
                                .attr("href", "/files/temp/" + fileName)
                                .html(fileName.length > 17 ? fileName.substring(0, 17) : fileName)
                                .removeClass("hide");
                            $("#prop-" + id + " div.upload-icon1 a.close").removeClass("hide");
                        }
                    },
                    fail: function (e, data) {
                        if (data.textStatus == "abort") {
                            $("#prop-" + id + " div.upload-icon1 div.local").removeClass("hide");
                            $("#prop-" + id + " div.upload-icon1 div.progress").addClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-fileselected").val("0");
                        }
                        else {
                            $("#prop-" + id + " div.upload-icon1 span.error").removeClass("hide");
                        }
                    }
                });

                //select file
                $("#prop-" + id + " a.uploadfile").click(function () {
                    $("#prop-" + id + " div.icon1 input[type='file']").click();
                });

                $("#prop-" + id + " div.upload-icon2 a.close").click(function () {

                    $("#prop-" + id + " div.icon2").removeClass("hide");
                    $("#prop-" + id + " div.icon2 a.uploadfile2").removeClass("hide");

                    $("#prop-" + id + " div.upload-icon2 a.tooltip-icon2").addClass("hide");
                    $("#prop-" + id + " div.upload-icon2 a.close").addClass("hide");

                    $("#prop-" + id + " input#comp-" + id + "-fileselected2").val("0");
                    $("#prop-" + id + " input#comp-" + id + "-filename2").val("");
                });


                //FOR ***FOCUSED TOOLTIP ICON
                //assign upload event
                var fileTypeDesc2 = 'Image Files';
                var fileTypeExt2 = '*.jpg;*.png;*.gif;*.jpeg';
                var formData2 = 'uploadimage';


                $("#prop-" + id + " div.icon2 input[type='file']").fileupload({
                    url: '/' + currentLanguage + '/' + route["interactivity_upload"],
                    dataType: 'json',
                    sequentialUploads: true,
                    formData: {
                        'type': formData2,
                        'element': 'comp-' + id + '-file2'
                    },
                    add: function (e, data) {
                        if ((/\.(jpg)$/i).test(data.files[0].name) || (/\.(jpeg)$/i).test(data.files[0].name) || (/\.(gif)$/i).test(data.files[0].name) || (/\.(png)$/i).test(data.files[0].name)) {
                            $("#prop-" + id + " div.upload-icon2").removeClass("hide");
                            $("#prop-" + id + " div.upload-icon2 div.progress").removeClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-fileselected2").val("1");

                            data.context = $("#prop-" + id + " div.upload-icon2 div.progress");
                            data.context.find('a').click(function (e) {
                                e.preventDefault();
                                var template = $("#prop-" + id + " div.upload-icon2 div.progress");
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

                        $("#prop-" + id + " div.upload-icon2 div.progress label").html(interactivity["video_uploading"] + ' ' + progress.toFixed(0) + '%');
                        $("#prop-" + id + " div.upload-icon2 div.progress div.scale").css('width', progress.toFixed(0) + '%');
                    },
                    done: function (e, data) {
                        if (data.textStatus == 'success') {
                            var fileName = data.result['comp-' + id + '-file2'][0].name;
                            $("#prop-" + id + " div.icon2").addClass("hide");
                            $("#prop-" + id + " div.upload-icon2").addClass("hide");

                            $("#prop-" + id + " input#comp-" + id + "-filename2").val(data.result['comp-' + id + '-file2'][0].name);
                            $("#prop-" + id + " div.settings div.properties div.file-header h4").html(data.result['comp-' + id + '-file2'][0].name);
                            $("#prop-" + id + " div.settings div.properties div.file-header span").html((data.result['comp-' + id + '-file2'][0].size / (1024 * 1024)).toFixed(1) + " MB");
                            $("#prop-" + id + " div.upload-icon2 div.progress").addClass("hide");
                            $("#prop-" + id + " div.settings div.properties").removeClass("hide");

                            $("#prop-" + id + " div.upload-icon2").removeClass("hide");
                            $("#prop-" + id + " a.tooltip-icon2")
                                .attr("href", "/files/temp/" + fileName)
                                .html(fileName.length > 17 ? fileName.substring(0, 17) : fileName)
                                .removeClass("hide");
                            $("#prop-" + id + " div.upload-icon2 a.close").removeClass("hide");
                        }
                    },
                    fail: function (e, data) {
                        if (data.textStatus == "abort") {
                            $("#prop-" + id + " div.upload-icon2 div.local").removeClass("hide");
                            $("#prop-" + id + " div.upload-icon2 div.progress").addClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-fileselected2").val("0");
                        }
                        else {
                            $("#prop-" + id + " div.upload-icon2 span.error").removeClass("hide");
                        }
                    }
                });

                //select file
                $("#prop-" + id + " a.uploadfile2").click(function () {
                    $("#prop-" + id + " div.icon2 input[type='file']").click();
                });

            }
            else if (componentName == "scroll") {
                //scroll
                $("#comp-" + id + "-boxcolor").colorPicker();
                $("#prop-" + id + " a.edit").click(function () {
                    // $( "#wrapper" ).fadeOut( 250, function() {
                    var content = $("#comp-" + id + "-content").val();
                    $("#modal-editor textarea").val(content);
                    $("#modal-editor").attr("opener", id);
                    // $("#editor").redactor();
                    // console.log(content);
                    createEditor(currentLanguage);
                    // setTimeout(function(){
                    // 	$('#wrapper').fadeIn(500);
                    // },1000);
                    // });
                });
            }
            else if (componentName == "slideshow" || componentName == "gal360") {
                //slideshow & 360
                $("#prop-" + id + " ul.file-rack").sortable();

                $("#prop-" + id + " ul.file-rack li a.delete").live("click", function () {
                    var li = $(this).parents("li:first");
                    li.addClass("hide");
                    li.children("input").val("");
                });

                //assign upload event for images

                $("#prop-" + id + " div.fromfile input[type='file']#comp-" + id + "-file").fileupload({
                    url: '/' + currentLanguage + '/' + route["interactivity_upload"],
                    dataType: 'json',
                    sequentialUploads: true,
                    formData: {
                        'type': 'uploadimage',
                        'element': 'comp-' + id + '-file'
                    },
                    dropZone: $("#prop-" + id + " div.drop-area"),
                    add: function (e, data) {
                        var passed = true;
                        $.each(data.files, function (index, file) {
                            if (!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(file.name)) {
                                passed = false;
                            }
                        });
                        if (passed) {
                            $("#prop-" + id + " div.fromfile div.progress").removeClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-fileselected").val("1");

                            data.context = $("#prop-" + id + " div.fromfile div.progress");
                            data.context.find('a').click(function (e) {
                                e.preventDefault();
                                var template = $("#prop-" + id + " div.fromfile div.progress");
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

                        $("#prop-" + id + " div.fromfile div.progress label").html(interactivity["video_uploading"] + ' ' + progress.toFixed(0) + '%');
                        $("#prop-" + id + " div.fromfile div.progress div.scale").css('width', progress.toFixed(0) + '%');
                        $("#prop-" + id + " div.fromfile div.progress div.scale").attr('percent', progress.toFixed(0));
                    },
                    done: function (e, data) {
                        if (data.textStatus == 'success') {
                            var progressPercent = parseInt($("#prop-" + id + " div.fromfile div.progress div.scale").attr('percent'));

                            if (progressPercent > 99) {
                                $("#prop-" + id + " div.fromfile div.progress").addClass("hide");
                            }

                            if ($("#prop-" + id + " ul.file-rack").hasClass("ui-sortable")) {
                                $("#prop-" + id + " ul.file-rack").sortable("destroy");
                            }
                            $("#prop-" + id + " ul.file-rack").sortable();

                            $.each(data.result['comp-' + id + '-file'], function (index, file) {
                                var size = $("#prop-" + id + " ul.file-rack li").size() + 1;
                                var li = '<li>' + (size > 9 ? "" + size : "0" + size) + ' - ' + file.name + '<input type="hidden" name="comp-' + id + '-filename[]" class="required" value="' + file.name + '" /><a href="#" class="delete"><i class="icon-remove"></i></a></li>';
                                $("#prop-" + id + " ul.file-rack").append(li);
                            });
                        }
                    },
                    fail: function (e, data) {
                        if (data.textStatus == "abort") {
                            $("#prop-" + id + " div.fromfile div.progress").addClass("hide");
                            $("#prop-" + id + " input#comp-" + id + "-fileselected").val("0");
                        } else {
                            $("#prop-" + id + " span.error").removeClass("hide");
                        }
                    }
                });

                //select poster image
                $("#prop-" + id + " div.drop-area a").click(function () {
                    $("#prop-" + id + " div.fromfile input[type='file']#comp-" + id + "-file").click();
                });
            } else if (componentName == "bookmark") {
                //bookmark
            }
            ///////////////////////////////////////////////////////////////////////////////////////////////
            //coordinates (common)
            $("#prop-" + id + " div.coordinates input[name='comp-" + id + "-x']")
                .val(opt.left)
                .blur(function () {
                    var tool = $("#tool-" + id);
                    var prop = $("#prop-" + id);
                    var left = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-x']").val());
                    var top = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-y']").val());
                    opt.positionChanged(tool, prop, 'prop', left, top);
                })
                .keydown(function (e) {
                    if (e.keyCode == 13) {
                        var tool = $("#tool-" + id);
                        var prop = $("#prop-" + id);
                        var left = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-x']").val());
                        var top = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-y']").val());
                        opt.positionChanged(tool, prop, 'prop', left, top);
                    }
                });
            $("#prop-" + id + " div.coordinates input[name='comp-" + id + "-y']")
                .val(opt.top)
                .blur(function () {
                    var tool = $("#tool-" + id);
                    var prop = $("#prop-" + id);
                    var left = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-x']").val());
                    var top = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-y']").val());
                    opt.positionChanged(tool, prop, 'prop', left, top);
                })
                .keydown(function (e) {
                    if (e.keyCode == 13) {
                        var tool = $("#tool-" + id);
                        var prop = $("#prop-" + id);
                        var left = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-x']").val());
                        var top = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-y']").val());
                        opt.positionChanged(tool, prop, 'prop', left, top);
                    }
                });
            $("#prop-" + id + " div.coordinates input[name='comp-" + id + "-w']")
                .val(opt.width)
                .blur(function () {
                    var tool = $("#tool-" + id);
                    var prop = $("#prop-" + id);
                    var width = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-w']").val());
                    var height = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-h']").val());
                    opt.sizeChanged(tool, prop, 'prop', width, height);
                })
                .keydown(function (e) {
                    if (e.keyCode == 13) {
                        var tool = $("#tool-" + id);
                        var prop = $("#prop-" + id);
                        var width = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-w']").val());
                        var height = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-h']").val());
                        opt.sizeChanged(tool, prop, 'prop', width, height);
                    }
                });
            $("#prop-" + id + " div.coordinates input[name='comp-" + id + "-h']")
                .val(opt.height)
                .blur(function () {
                    var tool = $("#tool-" + id);
                    var prop = $("#prop-" + id);
                    var width = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-w']").val());
                    var height = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-h']").val());
                    opt.sizeChanged(tool, prop, 'prop', width, height);
                })
                .keydown(function (e) {
                    if (e.keyCode == 13) {
                        var tool = $("#tool-" + id);
                        var prop = $("#prop-" + id);
                        var width = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-w']").val());
                        var height = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-h']").val());
                        opt.sizeChanged(tool, prop, 'prop', width, height);
                    }
                });

            //coordinates trigger (common)
            var triggerX = $("#prop-" + id + " div.coordinates input[name='comp-" + id + "-trigger-x']");
            if (parseInt(triggerX.val()) == 0) {
                triggerX.val(opt.left);
            }
            triggerX
                .blur(function () {
                    var tool = $("#tool-" + id + "-trigger");
                    var prop = $("#prop-" + id);
                    var left = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-trigger-x']").val());
                    var top = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-trigger-y']").val());
                    opt.triggerPositionChanged(tool, prop, 'prop', left, top);
                })
                .keydown(function (e) {
                    if (e.keyCode == 13) {
                        var tool = $("#tool-" + id + "-trigger");
                        var prop = $("#prop-" + id);
                        var left = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-trigger-x']").val());
                        var top = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-trigger-y']").val());
                        opt.triggerPositionChanged(tool, prop, 'prop', left, top);
                    }
                });

            var triggerY = $("#prop-" + id + " div.coordinates input[name='comp-" + id + "-trigger-y']");
            if (parseInt(triggerY.val()) == 0) {
                triggerY.val(opt.top)
            }
            triggerY
                .blur(function () {
                    var tool = $("#tool-" + id + "-trigger");
                    var prop = $("#prop-" + id);
                    var left = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-trigger-x']").val());
                    var top = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-trigger-y']").val());
                    opt.triggerPositionChanged(tool, prop, 'prop', left, top);
                })
                .keydown(function (e) {
                    if (e.keyCode == 13) {
                        var tool = $("#tool-" + id + "-trigger");
                        var prop = $("#prop-" + id);
                        var left = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-trigger-x']").val());
                        var top = parseFloat($("#prop-" + id + " div.coordinates input[name='comp-" + id + "-trigger-y']").val());
                        opt.triggerPositionChanged(tool, prop, 'prop', left, top);
                    }
                });

            //coordinates - expandable action
            $("#prop-" + id + " div.coordinates a").click(function () {
                $(this).removeClass("expand");
                $(this).removeClass("collapse");

                if ($(this).next().hasClass("hide")) {
                    $(this).addClass("expand");
                    $(this).next().removeClass("hide");
                }
                else {
                    $(this).addClass("collapse");
                    $(this).next().addClass("hide");
                }
            });
            ///////////////////////////////////////////////////////////////////////////////////////////////


            /*
             $(this).addClass("gselectable");

             $(this).click(function(){

             if(!$(this).hasClass("selected"))
             {
             //trigger beforeSelected event
             if (opt.beforeSelected !== undefined)
             {
             opt.beforeSelected($(this));
             }

             //add selected class
             $(this).addClass("selected");

             //trigger selected event
             if (opt.selected !== undefined)
             {
             opt.selected($(this));
             }
             }
             });
             */

        });
    };
})(jQuery);