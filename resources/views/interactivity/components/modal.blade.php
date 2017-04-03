<!-- VIDEO -->
<?php
$modal = 0;
$modaliconname = '';
$modalIconSelected = 0;

if(isset($Properties))
{
    foreach($Properties as $prop)
    {
        if($prop->Name == 'modal') $modal = (int)$prop->Value;
        if($prop->Name == 'modaliconname')
        {
            $modaliconname = public_path($prop->Value);
            if(File::exists($modaliconname) && is_file($modaliconname)) {
                $modalIconSelected = 1;
                $fname = File::name($modaliconname);
                $fext = File::extension($modaliconname);
                $modaliconname = $fname.'.'.$fext;
            }
            else {
                $modaliconname = '';
            }
        }
    }
}
?>
<div class="checkbox js-checkbox{{ ($modal == 1 ? ' checked' : '') }}">{{ __('interactivity.video_modal') }}<input type="hidden" name="comp-{id}-modal" value="{{ $modal }}" /></div>
<div class="selectfromfile{{ ($modal == 1 && $modalIconSelected == 1 ? ' hide' : '') }}">
    <input type="file" name="comp-{id}-modalicon" id="comp-{id}-modalicon" class="hiddenFileHeight hidden" />
    <input type="hidden" name="comp-{id}-modaliconselected" id="comp-{id}-modaliconselected" value="{{ $modalIconSelected }}" />
    <input type="hidden" name="comp-{id}-modaliconname" id="comp-{id}-modaliconname" value="{{ $modaliconname }}" />
    <a class="btn expand uploadmodalicon{{ ($modalIconSelected != 0 ? ' hide' : '') }}">{{ __('interactivity.video_modal_icon_text') }} <i class="icon-upload"></i></a>
</div>
<div class="upload-modalicon{{ ($modal == 1 && $modalIconSelected == 0 ? ' hide' : '') }}">
    <div class="progress hide">
        <a href="#">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
        <label for="scale"></label>
        <div class="scrollbox dot">
            <div class="scale" style="width: 0%"></div>
        </div>
    </div>
    <!-- end progress -->
    <a {{ (mb_strlen($modaliconname) > 0 ? 'href="'.$modaliconname.'" ' : '') }} target="_blank" class="modal-icon modal-img{{ ($modalIconSelected == 0 ? ' hide' : '') }}">{{ str_limit($modaliconname, 17) }}</a>
    <a class="close{{ ($modalIconSelected == 0 ? ' hide' : '') }}"><i class="icon-remove"></i></a>
    
   <!--  <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.video_poster_error') }}</span> -->
</div>
<!-- end upload-modal-icon -->