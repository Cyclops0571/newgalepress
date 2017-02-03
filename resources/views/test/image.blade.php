<?php
if (FALSE) {
	$cropSet = new Crop();
}
?>
{{ HTML::style('css/mystyles.css?v=' . APP_VER); }}
{{ HTML::style('css/bootstrap.min.css?v=' . APP_VER); }}
{{ HTML::style('js/jcrop/jquery.Jcrop.css?v=' . APP_VER); }}

{{ HTML::script('js/jquery-2.1.4.min.js?v=' . APP_VER); }}
{{ HTML::script('js/jquery-ui-1.10.4.custom.min.js?v=' . APP_VER); }}
{{ HTML::script('js/bootstrap.min.js?v=' . APP_VER); }}
{{ HTML::script('js/jcrop/jquery.Jcrop.min.js?v=' . APP_VER); }}
<div class="col-md-12">
	<script type="text/javascript" language="Javascript">
        var api, current_id;
        var wantedWidth;

        window.onload = function () {
            api = $.Jcrop('#cropbox', {
                setSelect: [0, 0, 2000, 2000],
                onSelect: updateCoords,
                allowSelect: false
            });
        };

        $(function () {
            $(".jqueryImageShowBigger").tooltip({
                delay: 0,
                showURL: false,
                bodyHandler: function () {
                    return $("<img/>").attr("src", this.src);
                }
            });
        });

        function setSelection(arr, cropID, id, wantedWidth2) {
            current_id = id;
            wantedWidth = wantedWidth2;
            $("#cropIDSet" + id).val(cropID);
            $("button").removeClass("active");
            $("#button" + id).addClass("active");
            $("#button" + id).removeClass("btn-info");
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
            if (wantedWidth != 1) {
                if (c.w >= wantedWidth * 0.9) {
                    //kesilen resim yeterince kaliteli.
                    $("#quality" + current_id).attr('class', 'qualitySufficient');
                }
                else {
                    //kesilen resim yeterli kalitede değil.
                    $("#quality" + current_id).attr('class', 'qualityInsufficient');
                }
            }
            $("#xCoordinateSet" + current_id).val(c.x);
            $("#yCoordinateSet" + current_id).val(c.y);
            $("#widthSet" + current_id).val(c.w);
            $("#heightSet" + current_id).val(c.h);
        }
        ;

        function reload_page() {
            if (confirm("Seçimleri sıfırlamak istediğinizden emin misiniz?"))
                window.location.reload();
        }
	</script>
	<?php
	$imagePath = "images/bg_home.jpg";
	if (!$imageInfo->isValid()) {
		//TODO: think for more respectfull way
		echo 'Resme ulaşılamıyor. Yüklediğiniz Resim Imaj Serverlara gönderilememiş.';
		exit;
	}
	$imageRatio = $imageInfo->width / $imageInfo->height;
	$displayedWidth = 500;
	$displayedHeight = $imageInfo->height * $displayedWidth / $imageInfo->width;
	?>
	<form onsubmit="return false" action="" method="post">
		<?php //burada resmin sınırlarının dışına hiç çıkılamasın....   ?>
		<div class="col-md-4" style="min-width: 500px;">
			<div class="row">
				<img width="<?php echo $displayedWidth ?>" src="<?php echo $imageInfo->webUrl; ?>" id="cropbox" alt="" />
			</div>
			<div class="row">
				<div class="col-md-2">
					<div class="qualityInsufficient"></div>
				</div>
				<div class="col-md-10">
					Resim Kalitesi Yetersiz.
				</div>
			</div>
			<div class="row">
				<div class="col-md-2">
					<div class="qualitySufficient"></div>
				</div>
				<div class="col-md-10">
					Resim Kalitesi Uygun.
				</div>
			</div>
		</div>
		<div class="col-md-2 ">
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

						$childListArr = array();
						foreach ($cropSet as $childCrop) {
							if ($crop->CropID == $childCrop->ParentID) {
								$childListArr[] = $childCrop->Description;
							}
						}
						$childList = implode(",<br />", $childListArr);
						?>
						<?php $i++; ?>
						<input type="hidden" id="cropIDSet<?php echo $i ?>" name="cropIDSet[]" />
						<input type="hidden" id="xCoordinateSet<?php echo $i ?>" name="xCoordinateSet[]" />
						<input type="hidden" id="yCoordinateSet<?php echo $i ?>" name="yCoordinateSet[]" />
						<input type="hidden" id="widthSet<?php echo $i ?>" name="widthSet[]" />
						<input type="hidden" id="heightSet<?php echo $i ?>" name="heightSet[]" />
						<div class="col-md-6">
							<button class="btn btn-info btn-block" id="button<?php echo $i ?>"
									title="<?php echo empty($childList) ? "" : $childList . "<br />Resim(ler)i de Bu Seçenekten Kesilir." ?>" 
									onclick="setSelection([0, 0, '<?php echo $cropImageWidth ?>',
		                                        '<?php echo $cropImageHeight ?>'], '<?php echo $crop->CropID ?>',
		                                            '<?php echo $i ?>', '<?php echo $crop->Width ?>');
		                                    this.blur();" 
									>
										<?php echo $crop->Description; ?>
							</button>
						</div>
						<div class="col-md-2">
							<div id="quality<?php echo $i ?>" class=""></div>
						</div>
						<?php
//							$croppedImageLocal = imageFolder() . IMAGE_CROPPED_PATH . PROJECT_ID . '/' . $image->imgType() . '/' . $image->dateFolder();
//							$croppedImageLocal .= PermittedUriChars($image->ownerName()) . "-" . $crop->crp_width . 'x' . $crop->crp_height . $crop->crp_type;
//							$croppedImageURI = imageRelativeFolder() . IMAGE_CROPPED_PATH . PROJECT_ID . '/' . $image->imgType() . '/' . $image->dateFolder();
//							$croppedImageURI .= PermittedUriChars($image->ownerName()) . "-" . $crop->crp_width . 'x' . $crop->crp_height . $crop->crp_type . '?v=' . time();
						$croppedImageLocal = "";
						$croppedImageURI = "";
						?>
						<?php if (@fopen($croppedImageLocal, "r")): ?>
							<div class="col-md-4" >
								<img height="50px;" src="<?php echo $croppedImageURI; ?>" class="jqueryImageShowBigger" />
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
			<div class="row">
				<div class="col-md-6">
					<input class="btn btn-info btn- btn-block" type="submit" onclick="this.form.submit()" value="Kaydet" class="imageCropSaveButton" />
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<input class="btn btn-info btn-block" type="reset" onclick="reload_page()" value="Seçimleri Sıfırla" class="imageCropOtherButton" />
				</div>
			</div>
		</div>

	</form>
</div>