@extends('layouts.master')

@section('content')
    <?php
    /** @var $app Application */
    ?>
    <div class="col-md-8">
    {{ Form::open(__('route.applications_save'), 'POST') }}
    {{ Form::token() }}
    <!-- APPLICATION INFO START -->
        <div class="block block-drop-shadow">
            <div class="header">
                <h2>{{ __('common.detailpage_caption') }}</h2>
            </div>
            <div class="content controls">
                <input type="hidden" name="ApplicationID" id="ApplicationID"
                       value="<?php echo (int)$app->ApplicationID ?>"/>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_customer') }} <span class="error">*</span></div>
                    {{ $errors->first('CustomerID', '<p class="error">:message</p>') }}
                    <div class="col-md-9">
                        <select class="form-control select2 required" name="CustomerID">
                            <option value=""<?php echo($app->CustomerID ? '' : ' selected="selected"'); ?>></option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->CustomerID }}"{{ ($app->CustomerID == $customer->CustomerID ? ' selected="selected"' : '') }}>
                                    {{ $customer->CustomerName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_applicationname') }}<span class="error">*</span>
                    </div>
                    {{ $errors->first('Name', '<p class="error">:message</p>') }}
                    <div class="col-md-9">
                        <input type="text" name="Name" id="Name" class="form-control textbox required"
                               value="<?php echo $app->Name ?>"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_startdate') }}<span class="error">*</span></div>
                    {{ $errors->first('StartDate', '<p class="error">:message</p>') }}
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" name="StartDate" id="StartDate"
                                   class="form-control textbox date required"
                                   disable="disable" value="{{ Common::dateRead($app->StartDate, 'd.m.Y') }}"/>
                            <span class="input-group-addon"><?php echo __('common.applications_dateformat'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_expirationdate') }}<span class="error">*</span>
                    </div>
                    {{ $errors->first('ExpirationDate', '<p class="error">:message</p>') }}
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" name="ExpirationDate" id="ExpirationDate"
                                   class="form-control textbox date required" disable="disable"
                                   value="{{ Common::dateRead($app->ExpirationDate, 'd.m.Y') }}"/>
                            <span class="input-group-addon"><?php echo __('common.applications_dateformat'); ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.application_language') }}<span class="error">*</span></div>
                    <div class="col-md-9">
                        <select class="form-control select2 required" name="ApplicationLanguage">
                            <option value="" <?php echo($app->ApplicationLanguage ? '' : ' selected="selected"'); ?>></option>
                            <?php foreach (Laravel\Config::get('application.languages') as $lang): ?>
                            <option value="<?php echo $lang; ?>" <?php echo $lang == $app->ApplicationLanguage ? ' selected="selected"' : ''; ?>>
                                <?php echo $lang; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_detail') }}</div>
                    <div class="col-md-9">
                        <textarea name="Detail" id="Detail" class="form-control" rows="2"
                                  cols="20"><?php echo $app->Detail; ?></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3">
                        <label class="label-grey"
                               for="topicIds">{{ __('applicationlang.application_category') }}</label>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" name="topicStatus"
                                   <?php echo $app->TopicStatus ? 'checked="checked"' : ''?>
                                   id="topicStatus">
                          </span>
                            <select id="topicIds" name="topicIds[]" multiple="multiple"
                                    class="chosen-container" required>
                                <?php
                                /** @var Topic[] $topics */
                                foreach ($topics as $topic): ?>
                                <?php
                                $selected = '';
                                foreach ($app->ApplicationTopics as $applicationTopic) {
                                    if ($applicationTopic->TopicID == $topic->TopicID) {
                                        $selected = ' selected="selected"';
                                    }
                                }
                                ?>
                                <option value="<?php echo $topic->TopicID ?>" <?php echo $selected ?>>
                                    <?php echo $topic->Name; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_file') }}</div>
                    <div class="col-md-9">
                        <div class="fileupload_container">
                            <?php if($app->CkPem): ?>
                            <a href="<?php echo $app->getCkPemPath() ?>" target="_blank" class="uploadedfile">
                                {{ __('common.contents_filelink') }}
                            </a>
                            <br/>
                            <?php endif; ?>

                            <input type="file" name="CkPem" id="CkPem" class="hidden"/>
                            <div id="CkPemButton" class="uploadify hide"
                                 style="height: 30px; width: 120px; opacity: 1;">
                                <div id="File-button" class="uploadify-button "
                                     style="height: 30px; line-height: 30px; width: 120px;">
                                    <span class="uploadify-button-text">{{ __('common.applications_file_select') }}</span>
                                </div>
                            </div>

                            <div for="CkPem" class="myProgress hide">
                                <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i
                                            class="icon-remove"></i></a>
                                <label for="scale"></label>

                                <div class="scrollbox dot">
                                    <div class="scale" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="hdnCkPemSelected" id="hdnCkPemSelected" value="0"/>
                        <input type="hidden" name="hdnCkPemName" id="hdnCkPemName" value="{{ $app->CkPem }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_package') }}</div>
                    <div class="col-md-9">
                        <select class="form-control select2 required" name="PackageID">
                            <option value=""{{ ((int)$app->PackageID == 0 ? ' selected="selected"' : '') }}></option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->PackageID }}"{{ ((int)$app->PackageID == $package->PackageID ? ' selected="selected"' : '') }}>{{ $package->Name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_blocked') }}</div>
                    <div class="col-md-9">
                        <div class="checkbox-inline">
                            <input type="checkbox" name="Blocked" id="Blocked"
                                   value="1"{{ ((int)(int)$app->Blocked == 1 ? ' checked="checked"' : '') }} />
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_status') }}</div>
                    <div class="col-md-9">
                        <div class="checkbox-inline">
                            <input type="checkbox" name="Status" id="Status"
                                   value="1"{{ ((int)$app->Status == 1 ? ' checked="checked"' : '') }} />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- APPLICATION PRICE START -->
        <div class="block block-drop-shadow">
            <div class="header">
                <h2>{{ __('common.applications_price') }}</h2>
            </div>
            <div class="content controls">
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_price') }}</div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" name="Price" id="Price" class="form-control textbox"
                                   placeholder="{{__('common.applications_placeholder_price')}}"
                                   value="<?php echo number_format((float)$app->Price, 2); ?>"/>
                            <span class="input-group-addon">{{__('website.currency')}}</span>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <?php echo __('applicationlang.installment_count') ?>
                    </div>
                    <div class="col-md-9">
                        <select class="form-control select2" name="Installment">
                            <?php for($i = Application::InstallmentCount; $i > 0; $i--): ?>
                            <option value="<?php echo $i ?>" <?php echo $app->Installment == $i ? ' selected="selected"' : "" ?>>
                                <?php echo $i; ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- APPLICATION OPTIONAL SETTINGS -->
        <div class="block block-drop-shadow">
            <div class="header">
                <h2>{{ __('applicationlang.other_options') }}</h2>
            </div>
            <div class="content controls">
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_in_app_purchase_active') }}</div>
                    <div class="col-md-9">
                        <input type="checkbox" name="InAppPurchaseActive" id="InAppPurchaseActive"
                               value="1"{{ (int)$app->InAppPurchaseActive ? ' checked="checked"' : '' }} />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_flipboard_active') }}</div>
                    <div class="col-md-9">
                        <input type="checkbox" name="FlipboardActive" id="FlipboardActive"
                               value="1"{{ $app->FlipboardActive ? ' checked="checked"' : '' }} />
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_bundle') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="BundleText" id="BundleText" class="form-control textbox"
                               value="<?php echo $app->BundleText; ?>"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_notificationtext') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="NotificationText" id="NotificationText" class="form-control textbox"
                               value="{{ $app->NotificationText }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_applicationstatus') }}</div>
                    <div class="col-md-9">
                        <select class="form-control select2" name="ApplicationStatusID">
                            <option value=""{{ ((int)$app->ApplicationStatusID == 0 ? ' selected="selected"' : '') }}></option>
                            @foreach ($groupcodes as $groupcode)
                                <option value="{{ $groupcode->GroupCodeID }}"{{ ((int)$app->ApplicationStatusID == $groupcode->GroupCodeID ? ' selected="selected"' : '') }}>{{ $groupcode->DisplayName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_iosversion') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="IOSVersion" id="IOSVersion" class="form-control textbox"
                               value="{{ (int)$app->IOSVersion }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_ioslink') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="IOSLink" id="IOSLink" class="form-control textbox"
                               value="{{ $app->IOSLink }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_androidversion') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="AndroidVersion" id="AndroidVersion" class="form-control textbox"
                               value="{{ (int)$app->AndroidVersion }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">{{ __('common.applications_androidlink') }}</div>
                    <div class="col-md-9">
                        <input type="text" name="AndroidLink" id="AndroidLink" class="form-control textbox"
                               value="{{ $app->AndroidLink }}"/>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3"><?php echo __('applicationlang.application_type') ?></div>
                    <div class="col-md-9">
                        <select class="form-control select2 required" name="Trail">
                            <option value="2"{{ ((int)$app->Trail == 2 ? ' selected="selected"' : '') }}>Müşterimiz
                            </option>
                            <option value="1"{{ ((int)$app->Trail == 1 ? ' selected="selected"' : '') }}>Deneme Sürümü
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8"></div>
                    <div class="col-md-2">
                        <?php if($app->ApplicationID): ?>
                        <a href="#modal_default_10" data-toggle="modal"><input type="button"
                                                                               value="{{ __('common.detailpage_delete') }}"
                                                                               name="delete"
                                                                               class="btn delete expand remove"/></a>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2">
                        <input type="button" class="btn my-btn-success" name="save"
                               value="{{ __('common.detailpage_update') }}" onclick="cApplication.save();"/>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
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
                            onclick="cApplication.erase();"
                            style="background:#9d0000;">{{ __('common.detailpage_delete') }}</button>
                    <button type="button" class="btn btn-default btn-clean"
                            data-dismiss="modal">{{ __('common.contents_category_button_giveup') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!--suppress JSJQueryEfficiency -->
    <script type="text/javascript">
        $(function () {
            var topicIds = $("#topicIds");
            topicIds.chosen({
                placeholder_text_single: javascriptLang['select'],
                placeholder_text_multiple: javascriptLang['select'],
                no_results_text: javascriptLang['no_results'],
            });
            $('#topicIds').prop('disabled', !$('#topicStatus').is(':checked')).trigger('chosen:updated');
            $('#topicStatus').on('click', function () {
                $('#topicIds').prop('disabled', !$('#topicStatus').is(':checked')).trigger('chosen:updated');
            });
            var inputGroup = $('.input-group');
            inputGroup.find('.chosen-container').css({"height": "100%"});
            inputGroup.find('.chosen-choices').css({"border": "1px solid rgba(0, 0, 0, 0)", "border-radius": "3px"});
            inputGroup.find('.search-field').css("margin", "3px 0 1px 3px");

            $("#CkPem").fileupload({
                url: '/' + currentLanguage + '/' + route["applications_uploadfile"],
                dataType: 'json',
                sequentialUploads: true,
                formData: {
                    'element': 'CkPem'
                },
                add: function (e, data) {
                    if (/\.(pem)$/i.test(data.files[0].name)) {
                        $('#hdnCkPemSelected').val("1");
                        var ckPem = $("[for='CkPem']");
                        ckPem.removeClass("hide");

                        data.context = ckPem;
                        data.context.find('a').click(function (e) {
                            e.preventDefault();
                            data = ckPem.data('data') || {};
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
                    var ckPem = $("[for='CkPem']");

                    ckPem.find('label').html(progress.toFixed(0) + '%');
                    ckPem.find('div.scale').css('width', progress.toFixed(0) + '%');
                },
                done: function (e, data) {
                    if (data.textStatus == 'success') {
                        var fileName = data.result['CkPem'][0].name;

                        $('#hdnCkPemName').val(fileName);
                        $("[for='CkPem']").addClass("hide");
                    }
                },
                fail: function (e, data) {
                    $("[for='CkPem']").addClass("hide");
                }
            });

            //select file
            $("#CkPemButton").removeClass("hide").click(function () {

                $("#CkPem").click();
            });

        });
    </script>

@endsection