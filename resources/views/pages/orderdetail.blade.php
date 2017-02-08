@extends('layouts.master')

@section('content')

    <?php

    $OrderID = 0;
    $ApplicationID = 0;
    $OrderNo = '';
    $Name = '';
    $Description = '';
    $Keywords = '';
    $Product = '';
    $Qty = '';
    $Website = '';
    $Email = '';
    $Facebook = '';
    $Twitter = '';
    $Image1024x1024 = '';
    $Image640x960 = '';
    $Image640x1136 = '';
    $Image1536x2048 = '';
    $Image2048x1536 = '';
    $Pdf = '';

    if (isset($row)) {
        $OrderID = (int)$row->OrderID;
        $ApplicationID = (int)$row->ApplicationID;
        $OrderNo = $row->OrderNo;
        $Name = $row->Name;
        $Description = $row->Description;
        $Keywords = $row->Keywords;
        $Product = $row->Product;
        $Qty = $row->Qty;
        $Website = $row->Website;
        $Email = $row->Email;
        $Facebook = $row->Facebook;
        $Twitter = $row->Twitter;
        $Image1024x1024 = $row->Image1024x1024;
        $Image640x960 = $row->Image640x960;
        $Image640x1136 = $row->Image640x1136;
        $Image1536x2048 = $row->Image1536x2048;
        $Image2048x1536 = $row->Image2048x1536;
        $Pdf = $row->Pdf;
    }

    $applications = DB::table('Application')
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('Name', 'ASC')
            ->get();
    ?>
    <div class="col-md-8">
        <div class="block block-drop-shadow">
            <div class="header">
                <h2>{{ __('common.detailpage_caption') }}</h2>
            </div>
            <div class="content controls">
                {{ Form::open(__('route.orders_save'), 'POST') }}
                {{ Form::token() }}
                <div class="form-row">
                    <input type="hidden" name="OrderID" id="OrderID" value="{{ $OrderID }}"/>

                    <div class="col-md-3">{{ __('common.orders_application') }}</div>
                    <div class="col-md-9">
                        <select class="form-control select2" style="width: 100%;" tabindex="-1" id="ApplicationID"
                                name="ApplicationID">
                            <option value=""{{ ($ApplicationID == 0 ? ' selected="selected"' : '') }}></option>
                            @foreach ($applications as $application)
                                <option value="{{ $application->ApplicationID }}"{{ ($ApplicationID == $application->ApplicationID ? ' selected="selected"' : '') }}>{{ $application->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.orders_list_column1') }}<span class="error">*</span></div>
                    {{ $errors->first('OrderNo', '<p class="error">:message</p>') }}
                    <div class="col-md-9">
                        <input type="text" name="OrderNo" id="OrderNo" class="form-control textbox required"
                               value="{{ $OrderNo }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.orders_name') }}<span class="error">*</span></div>
                    {{ $errors->first('Name', '<p class="error">:message</p>') }}
                    <div class="col-md-9">
                        <input type="text" name="Name" id="Name" class="form-control textbox required"
                               value="{{ $Name }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.orders_description') }}<span class="error">*</span></div>
                    {{ $errors->first('Description', '<p class="error">:message</p>') }}
                    <div class="col-md-9">
                        <textarea name="Description" id="Description" class="form-control required" rows="2"
                                  cols="20">{{ $Description }}</textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.orders_keywords') }}<span class="error">*</span></div>
                    {{ $errors->first('Keywords', '<p class="error">:message</p>') }}
                    <div class="col-md-9">
                        <textarea name="Keywords" id="Keywords" class="form-control required" rows="2"
                                  cols="20">{{ $Keywords }}</textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.orders_product') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="Product" id="Product" class="form-control textbox"
                               value="{{ $Product }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.orders_qty') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="Qty" id="Qty" class="form-control textbox" value="{{ $Qty }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.orders_website') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="Website" id="Website" class="form-control textbox"
                               value="{{ $Website }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.orders_email') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="Email" id="Email" class="form-control textbox" value="{{ $Email }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.orders_facebook') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="Facebook" id="Facebook" class="form-control textbox"
                               value="{{ $Facebook }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.orders_twitter') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="Twitter" id="Twitter" class="form-control textbox"
                               value="{{ $Twitter }}"/>
                    </div>
                </div>
                <?php /*
					<div class="form-row">
						<div class="col-md-3">{{ __('common.orders_startdate') }}<span class="error">*</span></div>
            {{ $errors->first('StartDate', '<p class="error">:message</p>') }}
            <div class="col-md-9">
                <input type="text" name="StartDate" id="StartDate" class="form-control textbox date required"
                       disable="disable" value="{{ Common::dateRead($StartDate, 'd.m.Y') }}"/>
            </div>
        </div>
        */ ?>
        <div class="form-row">
            <div class="col-md-3">{{ __('common.orders_Pdf') }}<span class="error">*</span></div>
            {{ $errors->first('Pdf', '<p class="error">:message</p>') }}
            <div class="col-md-9">
                <div class="fileupload_container">
                    @if(strlen($Pdf) > 0)
                        <a href="/files/orders/order_{{ $OrderNo }}/{{ $Pdf }}" target="_blank"
                           class="uploadedfile">{{ __('common.contents_filelink') }}</a><br/>
                    @endif
                    <input type="file" name="Pdf" id="Pdf" class="hidden"/>

                    <div id="PdfButton" class="uploadify hide" style="height: 30px; width: 120px; opacity: 1;">
                        <div id="File-button" class="uploadify-button "
                             style="height: 30px; line-height: 30px; width: 120px;">
                            <span class="uploadify-button-text">{{ __('common.orders_file_select') }}</span>
                        </div>
                    </div>

                    <div for="Pdf" class="myProgress hide">
                        <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
                        <label for="scale"></label>

                        <div class="scrollbox dot">
                            <div class="scale" style="width: 0%"></div>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="hdnPdfSelected" id="hdnPdfSelected" value="0"/>
                <input type="hidden" name="hdnPdfName" id="hdnPdfName" value="{{ $Pdf }}"/>
                <script type="text/javascript">
                    $(function () {

                        $("#Pdf").fileupload({
                            url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                            dataType: 'json',
                            sequentialUploads: true,
                            formData: {
                                'element': 'Pdf',
                                'type': 'uploadpdf'
                            },
                            add: function (e, data) {
                                if (/\.(pdf)$/i.test(data.files[0].name)) {
                                    $('#hdnPdfSelected').val("1");
                                    $("[for='Pdf']").removeClass("hide");

                                    data.context = $("[for='Pdf']");
                                    data.context.find('a').click(function (e) {
                                        e.preventDefault();
                                        var template = $("[for='Pdf']");
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

                                $("[for='Pdf'] label").html(progress.toFixed(0) + '%');
                                $("[for='Pdf'] div.scale").css('width', progress.toFixed(0) + '%');
                            },
                            done: function (e, data) {
                                if (data.textStatus == 'success') {
                                    $('#hdnPdfName').val(data.result.fileName);
                                    $("[for='Pdf']").addClass("hide");
                                }
                            },
                            fail: function (e, data) {
                                $('#hdnPdfSelected').val("0");
                                $('#hdnPdfName').val("");
                                $("[for='Pdf']").addClass("hide");
                            }
                        });

                        //select file
                        $("#PdfButton").removeClass("hide").click(function () {

                            $("#Pdf").click();
                        });

                    });
                </script>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-3">{{ __('common.orders_Image1024x1024') }}<span class="error">*</span></div>
            {{ $errors->first('Image1024x1024', '<p class="error">:message</p>') }}
            <div class="col-md-9">
                <div class="fileupload_container">
                    @if(strlen($Image1024x1024) > 0)
                        <a href="/files/orders/order_{{ $OrderNo }}/{{ $Image1024x1024 }}" target="_blank"
                           class="uploadedfile">{{ __('common.contents_filelink') }}</a><br/>
                    @endif
                    <input type="file" name="Image1024x1024" id="Image1024x1024" class="hidden"/>

                    <div id="Image1024x1024Button" class="uploadify hide"
                         style="height: 30px; width: 120px; opacity: 1;">
                        <div id="File-button" class="uploadify-button "
                             style="height: 30px; line-height: 30px; width: 120px;">
                            <span class="uploadify-button-text">{{ __('common.orders_file_select') }}</span>
                        </div>
                    </div>

                    <div for="Image1024x1024" class="myProgress hide">
                        <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
                        <label for="scale"></label>

                        <div class="scrollbox dot">
                            <div class="scale" style="width: 0%"></div>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="hdnImage1024x1024Selected" id="hdnImage1024x1024Selected" value="0"/>
                <input type="hidden" name="hdnImage1024x1024Name" id="hdnImage1024x1024Name"
                       value="{{ $Image1024x1024 }}"/>
                <script type="text/javascript">
                    $(function () {

                        $("#Image1024x1024").fileupload({
                            url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                            dataType: 'json',
                            sequentialUploads: true,
                            formData: {
                                'element': 'Image1024x1024',
                                'type': 'uploadpng1024x1024'
                            },
                            add: function (e, data) {
                                if (/\.(png)$/i.test(data.files[0].name)) {
                                    $('#hdnImage1024x1024Selected').val("1");
                                    $("[for='Image1024x1024']").removeClass("hide");

                                    data.context = $("[for='Image1024x1024']");
                                    data.context.find('a').click(function (e) {
                                        e.preventDefault();
                                        var template = $("[for='Image1024x1024']");
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

                                $("[for='Image1024x1024'] label").html(progress.toFixed(0) + '%');
                                $("[for='Image1024x1024'] div.scale").css('width', progress.toFixed(0) + '%');
                            },
                            done: function (e, data) {
                                if (data.textStatus == 'success') {
                                    $('#hdnImage1024x1024Name').val(data.result.fileName);
                                    $("[for='Image1024x1024']").addClass("hide");
                                }
                            },
                            fail: function (e, data) {
                                $('#hdnImage1024x1024Selected').val("0");
                                $('#hdnImage1024x1024Name').val("");
                                $("[for='Image1024x1024']").addClass("hide");
                            }
                        });

                        //select file
                        $("#Image1024x1024Button").removeClass("hide").click(function () {

                            $("#Image1024x1024").click();
                        });

                    });
                </script>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-3">{{ __('common.orders_Image640x960') }}</div>
            <div class="col-md-9">
                <div class="fileupload_container">
                    @if(strlen($Image640x960) > 0)
                        <a href="/files/orders/order_{{ $OrderNo }}/{{ $Image640x960 }}" target="_blank"
                           class="uploadedfile">{{ __('common.contents_filelink') }}</a><br/>
                    @endif
                    <input type="file" name="Image640x960" id="Image640x960" class="hidden"/>

                    <div id="Image640x960Button" class="uploadify hide" style="height: 30px; width: 120px; opacity: 1;">
                        <div id="File-button" class="uploadify-button "
                             style="height: 30px; line-height: 30px; width: 120px;">
                            <span class="uploadify-button-text">{{ __('common.orders_file_select') }}</span>
                        </div>
                    </div>

                    <div for="Image640x960" class="myProgress hide">
                        <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
                        <label for="scale"></label>

                        <div class="scrollbox dot">
                            <div class="scale" style="width: 0%"></div>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="hdnImage640x960Selected" id="hdnImage640x960Selected" value="0"/>
                <input type="hidden" name="hdnImage640x960Name" id="hdnImage640x960Name" value="{{ $Image640x960 }}"/>
                <script type="text/javascript">
                    $(function () {

                        $("#Image640x960").fileupload({
                            url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                            dataType: 'json',
                            sequentialUploads: true,
                            formData: {
                                'element': 'Image640x960',
                                'type': 'uploadpng640x960'
                            },
                            add: function (e, data) {
                                if (/\.(png)$/i.test(data.files[0].name)) {
                                    $('#hdnImage640x960Selected').val("1");
                                    $("[for='Image640x960']").removeClass("hide");

                                    data.context = $("[for='Image640x960']");
                                    data.context.find('a').click(function (e) {
                                        e.preventDefault();
                                        var template = $("[for='Image640x960']");
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

                                $("[for='Image640x960'] label").html(progress.toFixed(0) + '%');
                                $("[for='Image640x960'] div.scale").css('width', progress.toFixed(0) + '%');
                            },
                            done: function (e, data) {
                                if (data.textStatus == 'success') {
                                    $('#hdnImage640x960Name').val(data.result.fileName);
                                    $("[for='Image640x960']").addClass("hide");
                                }
                            },
                            fail: function (e, data) {
                                $('#hdnImage640x960Selected').val("0");
                                $('#hdnImage640x960Name').val("");
                                $("[for='Image640x960']").addClass("hide");
                            }
                        });

                        //select file
                        $("#Image640x960Button").removeClass("hide").click(function () {

                            $("#Image640x960").click();
                        });

                    });
                </script>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-3">{{ __('common.orders_Image640x1136') }}</div>
            <div class="col-md-9">
                <div class="fileupload_container">
                    @if(strlen($Image640x1136) > 0)
                        <a href="/files/orders/order_{{ $OrderNo }}/{{ $Image640x1136 }}" target="_blank"
                           class="uploadedfile">{{ __('common.contents_filelink') }}</a><br/>
                    @endif
                    <input type="file" name="Image640x1136" id="Image640x1136" class="hidden"/>

                    <div id="Image640x1136Button" class="uploadify hide"
                         style="height: 30px; width: 120px; opacity: 1;">
                        <div id="File-button" class="uploadify-button "
                             style="height: 30px; line-height: 30px; width: 120px;">
                            <span class="uploadify-button-text">{{ __('common.orders_file_select') }}</span>
                        </div>
                    </div>

                    <div for="Image640x1136" class="myProgress hide">
                        <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
                        <label for="scale"></label>

                        <div class="scrollbox dot">
                            <div class="scale" style="width: 0%"></div>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="hdnImage640x1136Selected" id="hdnImage640x1136Selected" value="0"/>
                <input type="hidden" name="hdnImage640x1136Name" id="hdnImage640x1136Name"
                       value="{{ $Image640x1136 }}"/>
                <script type="text/javascript">
                    $(function () {

                        $("#Image640x1136").fileupload({
                            url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                            dataType: 'json',
                            sequentialUploads: true,
                            formData: {
                                'element': 'Image640x1136',
                                'type': 'uploadpng640x1136'
                            },
                            add: function (e, data) {
                                if (/\.(png)$/i.test(data.files[0].name)) {
                                    $('#hdnImage640x1136Selected').val("1");
                                    $("[for='Image640x1136']").removeClass("hide");

                                    data.context = $("[for='Image640x1136']");
                                    data.context.find('a').click(function (e) {
                                        e.preventDefault();
                                        var template = $("[for='Image640x1136']");
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

                                $("[for='Image640x1136'] label").html(progress.toFixed(0) + '%');
                                $("[for='Image640x1136'] div.scale").css('width', progress.toFixed(0) + '%');
                            },
                            done: function (e, data) {
                                if (data.textStatus == 'success') {
                                    $('#hdnImage640x1136Name').val(data.result.fileName);
                                    $("[for='Image640x1136']").addClass("hide");
                                }
                            },
                            fail: function (e, data) {
                                $('#hdnImage640x1136Selected').val("0");
                                $('#hdnImage640x1136Name').val("");
                                $("[for='Image640x1136']").addClass("hide");
                            }
                        });

                        //select file
                        $("#Image640x1136Button").removeClass("hide").click(function () {

                            $("#Image640x1136").click();
                        });

                    });
                </script>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-3">{{ __('common.orders_Image1536x2048') }}</div>
            <div class="col-md-9">
                <div class="fileupload_container">
                    @if(strlen($Image1536x2048) > 0)
                        <a href="/files/orders/order_{{ $OrderNo }}/{{ $Image1536x2048 }}" target="_blank"
                           class="uploadedfile">{{ __('common.contents_filelink') }}</a><br/>
                    @endif
                    <input type="file" name="Image1536x2048" id="Image1536x2048" class="hidden"/>

                    <div id="Image1536x2048Button" class="uploadify hide"
                         style="height: 30px; width: 120px; opacity: 1;">
                        <div id="File-button" class="uploadify-button "
                             style="height: 30px; line-height: 30px; width: 120px;">
                            <span class="uploadify-button-text">{{ __('common.orders_file_select') }}</span>
                        </div>
                    </div>

                    <div for="Image1536x2048" class="myProgress hide">
                        <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
                        <label for="scale"></label>

                        <div class="scrollbox dot">
                            <div class="scale" style="width: 0%"></div>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="hdnImage1536x2048Selected" id="hdnImage1536x2048Selected" value="0"/>
                <input type="hidden" name="hdnImage1536x2048Name" id="hdnImage1536x2048Name"
                       value="{{ $Image1536x2048 }}"/>
                <script type="text/javascript">
                    $(function () {

                        $("#Image1536x2048").fileupload({
                            url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                            dataType: 'json',
                            sequentialUploads: true,
                            formData: {
                                'element': 'Image1536x2048',
                                'type': 'uploadpng1536x2048'
                            },
                            add: function (e, data) {
                                if (/\.(png)$/i.test(data.files[0].name)) {
                                    $('#hdnImage1536x2048Selected').val("1");
                                    $("[for='Image1536x2048']").removeClass("hide");

                                    data.context = $("[for='Image1536x2048']");
                                    data.context.find('a').click(function (e) {
                                        e.preventDefault();
                                        var template = $("[for='Image1536x2048']");
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

                                $("[for='Image1536x2048'] label").html(progress.toFixed(0) + '%');
                                $("[for='Image1536x2048'] div.scale").css('width', progress.toFixed(0) + '%');
                            },
                            done: function (e, data) {
                                if (data.textStatus == 'success') {
                                    $('#hdnImage1536x2048Name').val(data.result.fileName);
                                    $("[for='Image1536x2048']").addClass("hide");
                                }
                            },
                            fail: function (e, data) {
                                $('#hdnImage1536x2048Selected').val("0");
                                $('#hdnImage1536x2048Name').val("");
                                $("[for='Image1536x2048']").addClass("hide");
                            }
                        });

                        //select file
                        $("#Image1536x2048Button").removeClass("hide").click(function () {

                            $("#Image1536x2048").click();
                        });

                    });
                </script>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-3">{{ __('common.orders_Image2048x1536') }}</div>
            <div class="col-md-9">
                <div class="fileupload_container">
                    @if(strlen($Image2048x1536) > 0)
                        <a href="/files/orders/order_{{ $OrderNo }}/{{ $Image2048x1536 }}" target="_blank"
                           class="uploadedfile">{{ __('common.contents_filelink') }}</a><br/>
                    @endif
                    <input type="file" name="Image2048x1536" id="Image2048x1536" class="hidden"/>

                    <div id="Image2048x1536Button" class="uploadify hide"
                         style="height: 30px; width: 120px; opacity: 1;">
                        <div id="File-button" class="uploadify-button "
                             style="height: 30px; line-height: 30px; width: 120px;">
                            <span class="uploadify-button-text">{{ __('common.orders_file_select') }}</span>
                        </div>
                    </div>

                    <div for="Image2048x1536" class="myProgress hide">
                        <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
                        <label for="scale"></label>

                        <div class="scrollbox dot">
                            <div class="scale" style="width: 0%"></div>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="hdnImage2048x1536Selected" id="hdnImage2048x1536Selected" value="0"/>
                <input type="hidden" name="hdnImage2048x1536Name" id="hdnImage2048x1536Name"
                       value="{{ $Image2048x1536 }}"/>
                <script type="text/javascript">
                    $(function () {

                        $("#Image2048x1536").fileupload({
                            url: '/' + currentLanguage + '/' + route["orders_uploadfile"],
                            dataType: 'json',
                            sequentialUploads: true,
                            formData: {
                                'element': 'Image2048x1536',
                                'type': 'uploadpng2048x1536'
                            },
                            add: function (e, data) {
                                if (/\.(png)$/i.test(data.files[0].name)) {
                                    $('#hdnImage2048x1536Selected').val("1");
                                    $("[for='Image2048x1536']").removeClass("hide");

                                    data.context = $("[for='Image2048x1536']");
                                    data.context.find('a').click(function (e) {
                                        e.preventDefault();
                                        $('#hdnImage2048x1536Selected').val("0");
                                        $('#hdnImage2048x1536Name').val("");
                                        $("[for='Image2048x1536']").addClass("hide");
                                        var template = $("[for='Image2048x1536']");
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

                                $("[for='Image2048x1536'] label").html(progress.toFixed(0) + '%');
                                $("[for='Image2048x1536'] div.scale").css('width', progress.toFixed(0) + '%');
                            },
                            done: function (e, data) {
                                if (data.textStatus == 'success') {
                                    $('#hdnImage2048x1536Name').val(data.result.fileName);
                                    $("[for='Image2048x1536']").addClass("hide");
                                }
                            },
                            fail: function (e, data) {
                                $('#hdnImage2048x1536Selected').val("0");
                                $('#hdnImage2048x1536Name').val("");
                                $("[for='Image2048x1536']").addClass("hide");
                            }
                        });

                        //select file
                        $("#Image2048x1536Button").removeClass("hide").click(function () {

                            $("#Image2048x1536").click();
                        });

                    });
                </script>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-8"></div>
            @if($OrderID == 0)
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    <input type="button" class="btn my-btn-success" name="save"
                           value="{{ __('common.detailpage_save') }}" onclick="cOrder.save();"/>
                </div>
            @else
                <div class="col-md-2">
                    <a href="#modal_default_10" data-toggle="modal"><input type="button"
                                                                           value="{{ __('common.detailpage_delete') }}"
                                                                           name="delete"
                                                                           class="btn delete expand remove"/></a>
                </div>
                <div class="col-md-2">
                    <input type="button" class="btn my-btn-success" name="save"
                           value="{{ __('common.detailpage_update') }}" onclick="cOrder.save();"/>
                </div>
            @endif
        </div>
        {{ Form::close() }}
    </div>
    </div>
    </div>
    <div class="modal modal-info" id="modal_default_10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Silmek istediğinize emin misiniz?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-clean" data-dismiss="modal"
                            onclick="cOrder.erase();"
                            style="background:#9d0000;">{{ __('common.detailpage_delete') }}</button>
                    <button type="button" class="btn btn-default btn-clean"
                            data-dismiss="modal">{{ __('common.contents_category_button_giveup') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection