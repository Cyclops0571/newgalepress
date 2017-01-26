@extends('layouts.html')

@section('head')
    @parent
@endsection

@section('body')
    <?php $displayedWidth = ImageClass::CropPageWidth; ?>
    <style type="text/css">
        body {
            border-left: 7px solid #2D2D2D;
            border-right: 7px solid #2D2D2D;

            -webkit-box-shadow: inset 0px 0px 17px 0px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: inset 0px 0px 17px 0px rgba(0, 0, 0, 0.75);
            box-shadow: inset 0px 0px 17px 0px rgba(0, 0, 0, 0.75);
        }

        .rightPanel .btn-clean {
            margin: 0;
        }

        .jcrop-holder {
            background-color: black;
            background-image: repeating-linear-gradient(41deg, rgba(102, 102, 102, 1), rgba(102, 102, 102, 1) 6px, rgba(42, 42, 42, 1) 10px, rgba(42, 42, 42, 1) 10px);
        }

        .jcrop-vline {
            opacity: 1 !important;
        }

        .jcrop-hline {
            opacity: 1 !important;
        }

        .jcrop-handle {
            border: 1px #1681bf solid !important;
        }

        img[width="<?php echo $displayedWidth; ?>"] {
            -webkit-box-shadow: 0px 0px 50 0px rgba(2, 81, 130, 1);
            -moz-box-shadow: 0px 0px 50 0px rgba(2, 81, 130, 1);
            box-shadow: 0px 0px 50px 0px rgba(2, 81, 130, 1);
        }
    </style>
    <body class="bg-img-num1">
    <div class="container content-list" style="width:<?php echo $displayedWidth;?>px;">
        <div class="row">
            <?php

            /** @var imageInfoEx $imageInfo */
            if (!$imageInfo->isValid() || count($cropSet) == 0) {
                //TODO: think for more respectfull way
                echo '{{ __("common.crop_coverimage_error") }}';
                exit;
            }
            $imageRatio = $imageInfo->width / $imageInfo->height;
            $displayedHeight = $imageInfo->height * $displayedWidth / $imageInfo->width;
            /** @var Crop $crop */
            $crop = $cropSet[0];
            //seçimde gösterilecek width ve heighti ayarlayalım...
            $wantedRatio = $crop->Width / $crop->Height;
            $cropImageWidth = $displayedWidth;
            $cropImageHeight = $displayedHeight;

            if ($wantedRatio > $imageRatio) {
                //wanted width is bigger than uploaded image width so width will be the max value and the shownImageHeight will be calculated respectively.
                $cropImageHeight = $cropImageWidth / $wantedRatio;
            } else {
                $cropImageWidth = $cropImageHeight * $wantedRatio;
            }
            $i = 1;
            ?>

            {{ HTML::style('js/jcrop/jquery.Jcrop.css?v=' . APP_VER); }}
            {{ HTML::script('js/jcrop/jquery.Jcrop.min.js?v=' . APP_VER); }}

            <script type="text/javascript" language="Javascript">
                var api, current_id;
                var wantedWidth;

                window.onload = function () {
                    api = $.Jcrop('#cropbox', {
                        setSelect: [0, 0, 2000, 2000],
                        onSelect: updateCoords,
                        allowSelect: false
                    });
                    setSelection([0, 0, '<?php echo $cropImageWidth ?>', '<?php echo $cropImageHeight ?>'], '<?php echo $crop->CropID ?>', '<?php echo $i ?>', '<?php echo $crop->Width ?>');
                    $("#saveBtn").removeClass('noTouch');
                };

                function setSelection(arr, cropID, id, wantedWidth2) {
                    current_id = id;
                    wantedWidth = wantedWidth2;
                    $("#cropIDSet" + id).val(cropID);
                    $("button").removeClass("active");
                    $("#button" + id).addClass("active");
                    $("#button" + id).removeClass("my-btn-success");
                    $("#button" + id).addClass("btn-success");
                    api.setOptions({
                        keepRatio: true,
                        aspectRatio: arr[2] / arr[3]
                        //minSize: [arr[2], arr[3]]
                    });
                    api.setSelect(arr);
                    c = api.tellSelect();
                    updateCoords(c);
                }

                function updateCoords(c) {
                    $("#xCoordinateSet" + current_id).val(c.x);
                    $("#yCoordinateSet" + current_id).val(c.y);
                    $("#widthSet" + current_id).val(c.w);
                    $("#heightSet" + current_id).val(c.h);
                }
                ;

                function reload_page() {
                    if (confirm("{{ __('common.undo_alert') }}"))
                        window.location.reload();
                }

                function dissmiss_iframe(form) {

                    $('body', window.parent.document).removeClass('modal-open').addClass('noTouch');
                    $('#dialog-cover-image', window.parent.document).addClass('hide');
                    $('.modal-backdrop', window.parent.document).remove();
                    form.submit();
                    // parent.location.reload();
                }
                $(document).ready(function () {
                    $.urlParam = function (name) {
                        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                        if (results == null) {
                            return null;
                        }
                        else {
                            return results[1] || 0;
                        }
                    }
                    if (window.location.hash === "#saved") {
                        parent.location = '/' + currentLanguage + '/' + route["contents"] + '/' + $.urlParam('contentID');
                    }
                });
            </script>
            <?php

            ?>
            <form onsubmit="return false" action="" method="post">
                <div class="row">
                    <div class="col-md-12 text-center" style="margin:0;">
                        <div class="btn-group">
                            <button type="button" class="btn my-btn-send"
                                    onclick="reload_page()">{{ __('common.undo') }}</button>
                            <!-- <button type="button" class="btn my-btn-info" onclick="dissmiss_iframe()">Kapat</button> -->
                            <button type="button" class="btn my-btn-success noTouch" id="saveBtn" type="submit"
                                    onclick="dissmiss_iframe(this.form)">{{ __('common.detailpage_save') }}</button>
                        </div>
                    </div>

                </div>
                <?php //burada resmin sınırlarının dışına hiç çıkılamasın....    ?>
                <div class="row" style="margin-top: 10px;">
                    <img width="<?php echo $displayedWidth ?>" src="<?php echo $imageInfo->webUrl . "?" . time(); ?>"
                         id="cropbox" alt="" style="opacity:0.4 !important;"/>
                </div>
                <?php if (count($cropSet) == 1): ?>
                <input type="hidden" id="cropIDSet<?php echo $i ?>" name="cropIDSet[]"/>
                <input type="hidden" id="xCoordinateSet<?php echo $i ?>" name="xCoordinateSet[]"/>
                <input type="hidden" id="yCoordinateSet<?php echo $i ?>" name="yCoordinateSet[]"/>
                <input type="hidden" id="widthSet<?php echo $i ?>" name="widthSet[]"/>
                <input type="hidden" id="heightSet<?php echo $i ?>" name="heightSet[]"/>

                <?php else: ?>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center" id="rightPanel"
                     style="padding:0;background:rgba(0,0,0,0.5);width:118px;height:<?php echo $displayedHeight.'px'; ?>">

                    <?php $i = 0; ?>
                    <?php foreach ($cropSet as $crop): ?>
                    <?php if ($crop->ParentID == 0): ?>
                    <div class="row">
                        <?php
                        //seçimde gösterilecek width ve heighti ayarlayalım...
                        $wantedRatio = $crop->Width / $crop->Height;
                        $cropImageWidth = $displayedWidth;
                        $cropImageHeight = $displayedHeight;

                        if ($wantedRatio > $imageRatio) {
                        //wanted width is bigger than uploaded image width so width will be the max value and the shownImageHeight will be calculated respectively.
                        $cropImageHeight = $cropImageWidth / $wantedRatio;
                        } else {
                        $cropImageWidth = $cropImageHeight * $wantedRatio;
                        }
                        ?>
                        <?php $i++; ?>
                        <input type="hidden" id="cropIDSet<?php echo $i ?>" name="cropIDSet[]"/>
                        <input type="hidden" id="xCoordinateSet<?php echo $i ?>" name="xCoordinateSet[]"/>
                        <input type="hidden" id="yCoordinateSet<?php echo $i ?>" name="yCoordinateSet[]"/>
                        <input type="hidden" id="widthSet<?php echo $i ?>" name="widthSet[]"/>
                        <input type="hidden" id="heightSet<?php echo $i ?>" name="heightSet[]"/>
                        <div class="col-md-6">
                            <button class="btn bmy-btn-success btn-block" id="button<?php echo $i ?>"
                                    onclick="setSelection([0, 0, '<?php echo $cropImageWidth ?>',
                                            '<?php echo $cropImageHeight ?>'], '<?php echo $crop->CropID ?>',
                                            '<?php echo $i ?>', '<?php echo $crop->Width ?>');
                                            this.blur();">
                                <?php echo $crop->Description; ?>
                            </button>
                        </div>
                        <div class="col-md-2">
                            <div id="quality<?php echo $i ?>" class=""></div>
                        </div>

                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <?php endif; ?>
            </form>
        </div>
    </div>
    </body>
@endsection