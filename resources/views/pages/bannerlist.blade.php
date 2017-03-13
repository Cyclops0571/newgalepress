@extends('layouts.master')

@section('content')
<?php
/** @var App\Models\Banner[] $rows */;
/** @var App\Models\Application $application */
/** @var array $fields */
?>

        <!--<form id="list">-->
<div class="col-md-11">
    <form id="bannerForm">
        {{csrf_field()}}
        <input type="hidden" name="applicationID" value="<?php echo $application->ApplicationID; ?>"/>

        <div class="block block-drop-shadow">
            <div class="header">
                <h2>{{ __('common.application_settings_caption_banner') }}</h2>
            </div>
            <div class="content controls" id="bannerSettings">
                <div class="form-row">
                    <div class="col-md-3"><label class="label-grey"
                                                 for="BannerActive">{{__('common.contents_status')}}</label></div>
                    <div class="col-md-8 toggle_div">
                        <input type="checkbox"
                               <?php echo $application->BannerActive ? 'checked' : ''; ?>
                               data-toggle="toggle" data-size="mini"
                               id="BannerActive" name="BannerActive"
                               data-style="ios"
                               data-onstyle="info"
                               data-offstyle="danger"
                               data-on="<?php echo __('common.active'); ?>"
                               data-off="<?php echo __('common.passive'); ?>"
                               data-width="60"
                        />
                    </div>
                    <div class="col-md-1">
                        <a class="tipr" title="{{ __('common.banners_info_banner_active') }}"><span
                                    class="icon-info-sign"></span></a></div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <label class="label-grey" for="BannerAutoplay">{{__('common.banners_autoplay')}}</label>
                    </div>
                    <div class="col-md-8 toggle_div">
                        <input type="checkbox"
                               <?php echo $application->BannerAutoplay ? 'checked' : ''; ?>
                               data-toggle="toggle" data-size="mini"
                               id="BannerAutoplay" name="BannerAutoplay"
                               data-style="ios"
                               data-onstyle="info"
                               data-offstyle="danger"
                               data-on="<?php echo __('common.active'); ?>"
                               data-off="<?php echo __('common.passive'); ?>"
                               data-width="60"
                        />
                    </div>
                    <div class="col-md-1">
                        <a class="tipr" title="{{ __('common.banners_info_autoplay') }}"><span
                                    class="icon-info-sign"></span></a>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <label class="label-grey" for="BannerAutoplay">{{__('common.banners_random')}}</label>
                    </div>
                    <div class="col-md-8 toggle_div">
                        <input type="checkbox"
                               <?php echo $application->BannerRandom ? 'checked' : ''; ?>
                               data-toggle="toggle" data-size="mini"
                               id="BannerRandom" name="BannerRandom"
                               data-style="ios"
                               data-onstyle="info"
                               data-offstyle="danger"
                               data-on="<?php echo __('common.active'); ?>"
                               data-off="<?php echo __('common.passive'); ?>"
                               data-width="60"
                        />
                    </div>
                    <div class="col-md-1">
                        <a class="tipr" title="{{ __('common.banners_info_random') }}"><span
                                    class="icon-info-sign"></span></a>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3"><label class="label-grey"
                                                 for="BannerIntervalTime">{{__('common.banners_autoplay_interval')}}</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="BannerIntervalTime" id="BannerIntervalTime"
                               value="<?php echo $application->BannerIntervalTime; ?>"/>
                    </div>
                    <div class="col-md-1">
                        <a class="tipr" title="{{ __('common.banners_info_interval') }}">
                            <span class="icon-info-sign"></span>
                        </a>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <label class="label-grey" for="BannerTransitionRate">
                            {{__('common.banners_autoplay_speed')}}
                        </label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" name="BannerTransitionRate" id="BannerTransitionRate"
                               value="<?php echo $application->BannerTransitionRate; ?>"/>
                    </div>
                    <div class="col-md-1">
                        <a class="tipr" title="{{ __('common.banners_info_speed') }}">
                            <span class="icon-info-sign"></span>
                        </a>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        {{__('common.banners_pager_color')}}
                    </div>
                    <div class="col-md-8">
                        <div class="input-group BannerColor">
                            <input type="text" name="BannerColor"
                                   value="<?php echo $application->getBannerColor()?>"
                                   class="form-control"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        {{__('common.banners_slide_effect')}}
                    </div>
                    <div class="col-md-8">
                        <select name="BannerSlideAnimation" class="form-control select2">
                            <?php foreach (Banner::$slideAnimations as $slideAnimation): ?>
                            <option value="{{$slideAnimation}}" {{ ($application->BannerSlideAnimation == $slideAnimation ? ' selected="selected"' : '') }}>
                                {{__('common.banners_slide_animation_' . $slideAnimation)}}
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-1"></div>
                </div>

            </div>
            <div class="content controls">
                <div class="form-row row-save">
                    <div class="col-md-3 col-md-offset-8">
                        <input type="button" class="btn my-btn-success" name="save"
                               value="{{ __('common.detailpage_update') }}" onclick="cBanner.settingSave();"/>
                    </div>
                </div>
            </div>
        </div>


        <!-- IMAGE UPLOAD START -->
        <input type="file" name="ImageFile" id="ImageFile" class="hidden"/>

        <div for="ImageFile" class="myProgress hide">
            <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
            <label for="scale"></label>

            <div class="scrollbox dot">
                <div class="scale" style="width: 0"></div>
            </div>
        </div>
        <!-- IMAGE UPLOAD END -->

        <div class="block block-drop-shadow">
            <div class="col-md-12">
                <table id="DataTables_Table_1" cellpadding="0" cellspacing="0" width="100%"
                       class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <?php if ((int)Auth::user()->UserTypeID == eUserTypes::Customer): ?>
                        <th>
                            <div class="input-group commands">
                                <a href="#"
                                   onclick="cBanner.createNewBanner(<?php echo $application->ApplicationID; ?>);"
                                   class="widget-icon widget-icon-circle">
                                    <span class="icon-plus"></span>
                                </a>
                            </div>
                        </th>
                        <?php endif; ?>
                        <?php foreach ($fields as $field): ?>
                        <th scope="col"><?php echo $field; ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rows as $row): ?>

                    <tr id="bannerIDSet_<?php echo $row->BannerID ?>" class="{{ Common::htmlOddEven($page) }}">
                        <?php if ((int)Auth::user()->UserTypeID == eUserTypes::Manager): ?>
                        <td><?php echo $row->CustomerName; ?></td>
                        <td><?php echo $row->ApplicationName; ?></td>
                        <?php else: ?>
                        <td style="cursor:pointer;"><span class="icon-resize-vertical list-draggable-icon"></span></td>
                        <?php endif; ?>
                        <td>
                            <!--onclickde yeni image uploader popupi acilmali ??? -->
                            <img id="bannerImage_<?php echo $row->BannerID; ?>" src="<?php echo $row->getImagePath() ?>"
                                 width="60px" height="30px" style="cursor: pointer" onclick="fileUpload(this)"/>

                            <div id="uploadProgress_<?php echo $row->BannerID; ?>" class="myProgress hide">
                                <a href="javascript:void(0);">{{ __('interactivity.cancel') }} <i
                                            class="icon-remove"></i></a>
                                <label for="scale"></label>

                                <div class="scrollbox dot">
                                    <div class="scale" style="width: 0"></div>
                                </div>
                            </div>

                        </td>
                        <td>
                            <a href="#" id="<?php echo $row->BannerID; ?>"
                               data-name="TargetUrl"
                               data-type="text"
                               data-pk="<?php echo $row->BannerID; ?>"
                               data-title="<?php echo __("common.banner_form_target_url"); ?>">
                                <?php echo $row->TargetUrl; ?>
                            </a>
                        </td>
                            <td>
                                <a href="#" id="description_<?php echo $row->BannerID; ?>"
                                   data-name="Description"
                                   data-type="text"
                                   data-pk="<?php echo $row->BannerID; ?>"
                                   data-title="<?php echo __("common.banner_description"); ?>">
                                    <?php echo $row->Description; ?>
                                </a>
                            </td>
                        <td>
                            <div class="toggle_div">
                                <input type="checkbox" title="BannerStatus" class='toggleCheckbox'
                                       <?php echo $row->Status == eStatus::Active ? 'checked' : ''; ?> id="BannerStatus_<?php echo $row->BannerID; ?>"/>
                            </div>
                        <td><?php echo $row->BannerID; ?></td>
                        <td style="alignment-adjust: middle">
                            <div style="padding-top: 8px;">
                                <span style=" cursor: pointer; font-size: 30px;" class="icon-remove-sign"
                                      onclick="cBanner.delete(<?php echo $row->BannerID; ?>);"></span>
                            </div>
                        </td>
                    </tr>

                    <?php endforeach; ?>
                    <?php if (empty($rows)): ?>
                    <tr>
                        <td class="select">&nbsp;</td>
                        <td colspan="{{ count ($fields) - 1 }}">{{ __('common.list_norecord') }}</td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
<!--</form>-->
<script type="text/javascript">
    var appID = parseInt(<?php echo $application->ApplicationID ?>);
    var currentBannerID = 0;
    var ActiveText = "{{ __('common.active') }}";
    var PassiveText = "{{ __('common.passive') }}";
    function fileUpload(obj) {
        currentBannerID = $(obj).attr("id").split("_")[1];
        $("#ImageFile").click();
    }
    $(function () {
        $('.BannerColor').colorpicker();
        $('.toggleCheckbox').bootstrapToggle({
            size: 'mini',
            on: ActiveText,
            off: PassiveText,
            offstyle: 'danger',
            onstyle: 'info',
            style: 'ios'

        });

        $(document).on('change', '.toggleCheckbox', function () {
            var editBannerID = $(this).attr('id').split("_")[1];
            var additionalData = '&pk=' + editBannerID + '&applicationID=' + appID + '&Status=' + ($(this).is(':checked') + 0);
            cCommon.save('banners', undefined, undefined, additionalData, true);
        });

        cApplication.BannerActive();

//	$.fn.editable.defaults.mode = 'inline';
        var datatable = $('#DataTables_Table_1');
        datatable.find('tbody a').editable({
            emptytext: '. . . . .',
            url: route['banners_save'],
            params: {'applicationID': appID, '_token': '{{csrf_token()}}'},
            ajaxOptions: {
                beforeSend: function () {
                    cNotification.loader();
                }
            },
            success: function () {
                cNotification.success();
                setTimeout(function () {
                    cNotification.hide();
                }, 1000);
            }
        });

        datatable.find('tbody').sortable({
            delay: 150,
            axis: 'y',
            update: function () {
                var data = $(this).sortable('serialize') + '&_token={!! csrf_token() !!}';
                console.log(data);
                $.ajax({
                    data: data,
                    type: 'POST',
                    url: '{!! route('banners_order', $application->ApplicationID) !!}',
                    success: function () {
                        cNotification.success();
                        setTimeout(function () {
                            cNotification.hide();
                        }, 1000);
                    }

                });

            }
        });

        $('#ImageFile').fileupload({
            url: '{!! route('banners_imageupload') !!}',
            dataType: 'json',
            add: function (e, data) {
                console.log(data);
                if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(data.files[0].name)) {

                    $("#uploadProgress_" + currentBannerID).removeClass("hide").click(function (e) {
                        e.preventDefault();
                        data = $("#uploadProgress_" + currentBannerID).data('data') || {};
                        if (data.jqXHR) {
                            data.jqXHR.abort();
                        }
                    });
                    $("#bannerImage_" + currentBannerID).addClass("hide");
                    data.submit();
                }
            },
            done: function (e, data) {
                if (data.textStatus === 'success') {
                    $("#bannerImage_" + currentBannerID).attr("src", data.result.fileName + "?v=" + Math.random()).removeClass("hide");
                    $("#uploadProgress_" + currentBannerID).addClass("hide");
                }
            }
        }).bind('fileuploadsubmit', function (e, data) {
            data.formData = {'element': 'ImageFile', 'bannerID': currentBannerID};
        });
    });

</script>
@endsection