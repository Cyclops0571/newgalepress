<!-- VIDEO -->
<?php
$option = 1;
$filename = '';
$fileSelected = 0;
$fileSize = '';
$url = '';
$videoinit = '';
$showcontrols = 1;
$restartwhenfinished = 0;
$mute = 0;
$posteroption = 1;
$posterimagename = '';
$posterImageSelected = 0;
$videodelay = 0;
if(isset($Properties))
{
	foreach($Properties as $prop)
	{
		if($prop->Name == 'option') $option = (int)$prop->Value;
		if($prop->Name == 'filename')
		{
			$filename = public_path($prop->Value);
			if(File::exists($filename) && is_file($filename)) {
				$fileSelected = 1;
				$fileSize = round((File::size($filename) / (1024 * 1024)), 1).' MB';
				$fname = File::name($filename);
				$fext = File::extension($filename);
				$filename = $fname.'.'.$fext;
			}
			else {
				$filename = '';
			}
		}
		if($prop->Name == 'url') $url = $prop->Value;
		if($prop->Name == 'videoinit') $videoinit = $prop->Value;
		if($prop->Name == 'showcontrols') $showcontrols = (int)$prop->Value;
		if($prop->Name == 'restartwhenfinished') $restartwhenfinished = (int)$prop->Value;
		if($prop->Name == 'mute') $mute = (int)$prop->Value;
		if($prop->Name == 'posteroption') $posteroption = (int)$prop->Value;
		if($prop->Name == 'posterimagename')
		{
			$posterimagename = public_path($prop->Value);
			if(File::exists($posterimagename) && is_file($posterimagename)) {
				$posterImageSelected = 1;
				$fname = File::name($posterimagename);
				$fext = File::extension($posterimagename);
				$posterimagename = $fname.'.'.$fext;
			}
			else {
				$posterimagename = '';
			}
		}
        if($prop->Name == 'videodelay') $videodelay = (int)$prop->Value;
	}
}
?>
<div id="prop-{id}" class="component video hide" componentid="{id}">
	<input type="hidden" name="compid[]" value="{id}" />
    <input type="hidden" name="comp-{id}-id" value="{{ $ComponentID }}" />
    <input type="hidden" name="comp-{id}-pcid" value="{{ $PageComponentID }}" />
    <input type="hidden" name="comp-{id}-process" value="{{ $Process }}" />
    <div class="component-header">
        <h3><span></span>{{ __('interactivity.video_name') }}<small> - {{ __('interactivity.video_componentid') }}{id}</small></h3>
        <a href="#" class="delete remove" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
    </div>
    
    <div class="upload{{ ($fileSelected != 0 ? ' hide' : '') }}">
    
        <div class="radiogroup">
            <div class="radio {{ ($option == 1 ? 'checked ' : '') }}js-radio" optionvalue="1">{{ __('interactivity.video_upload_option1') }}</div>
            <div class="radio {{ ($option == 2 ? 'checked ' : '') }}js-radio" optionvalue="2">{{ __('interactivity.video_upload_option2') }}</div>
            <input type="hidden" name="comp-{id}-option" id="comp-{id}-option" value="{{ $option }}" />
        </div>
        <!-- end radiogroup-->
        
        <div class="local{{ ($option == 2 ? ' hide' : '') }}">
        	<input type="file" name="comp-{id}-file" id="comp-{id}-file" class="hiddenFileHeight hidden" />
            <input type="hidden" name="comp-{id}-fileselected" id="comp-{id}-fileselected" value="{{ $fileSelected }}" />
			<input type="hidden" name="comp-{id}-filename" id="comp-{id}-filename" class="required" value="{{ $filename }}" />
	        <a class="btn expand uploadfile">{{ __('interactivity.video_upload_text') }} <i class="icon-upload"></i></a>
        </div>
        
    	<div class="web{{ ($option == 1 ? ' hide' : '') }}">
            <div class="text dark inline-primary">
                <input type="text" name="comp-{id}-url" id="comp-{id}-url" placeholder="Youtube link, embed or .mp4 extensions" class="prefix" value="{{ $url }}">
            </div>
            <div class="inline-secondary">
                <a href="#" class="btn btn-primary postfix"><i class="icon-upload-alt"></i></a>
            </div>
            <span class="success hide"><i class="icon-ok-sign"></i>{{ __('interactivity.video_url_success') }}</span>
            <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.video_url_fail') }}</span>
        </div>
        
        <div class="progress hide">
        	<a href="#">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
            <label for="scale"></label>
            <div class="scrollbox dot">
                <div class="scale" style="width: 0%"></div>
            </div>
        </div>
        <!-- end progress --> 
        
        <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.video_upload_error') }}</span>
        <span class="error max-size hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.file_upload_error_max_size') }}</span>
    </div>
    <!-- end upload -->
    
    <div class="settings">
    
        <div class="properties component-panel{{ ($fileSelected == 0 ? ' hide' : '') }}">
            <div class="file-header">
                <h4>{{ Str::limit($filename, 26) }}</h4>
                <span>{{ $fileSize }}</span>
                <a href="#" class="delete" title="{{ __('interactivity.delete') }}"><i class="icon-remove"></i></a>
            </div>
            <select class="select js-select" name="comp-{id}-videoinit" id="comp-{id}-videoinit">
                <option value="onstart"{{ ($videoinit == 'onstart' ? ' selected="selected"' : '') }}>{{ __('interactivity.video_select1') }}</option>
                <option value="onload"{{ ($videoinit == 'onload' ? ' selected="selected"' : '') }}>{{ __('interactivity.video_select2') }}</option>
            </select>
            <h5 title="{{ __('interactivity.video_playerpreferences_tooltip') }}" class="tooltip">{{ __('interactivity.video_playerpreferences') }} <i class="icon-info-sign"></i></h5>
            <div class="checkbox js-checkbox{{ ($showcontrols == 1 ? ' checked' : '') }}">{{ __('interactivity.video_showcontrols') }}<input type="hidden" name="comp-{id}-showcontrols" value="{{ $showcontrols }}" /></div>
            <div class="checkbox js-checkbox{{ ($restartwhenfinished == 1 ? ' checked' : '') }}">{{ __('interactivity.video_restartwhenfinished') }}<input type="hidden" name="comp-{id}-restartwhenfinished" value="{{ $restartwhenfinished }}" /></div>
            <div class="checkbox js-checkbox{{ ($mute == 1 ? ' checked' : '') }}">{{ __('interactivity.video_mute') }}<input type="hidden" name="comp-{id}-mute" value="{{ $mute }}" /></div>
            @include('interactivity.components.import')
            @include('interactivity.components.modal')
            <h5 title="{{ __('interactivity.video_poster_tooltip') }}" class="tooltip">{{ __('interactivity.video_poster') }} <i class="icon-info-sign"></i></h5>
            <div class="radiogroup">
                <div class="radio {{ ($posteroption == 1 ? 'checked ' : '') }}js-radio" optionvalue="1">{{ __('interactivity.video_poster_option1') }}</div>
                <div class="radio {{ ($posteroption == 2 ? 'checked ' : '') }}js-radio" optionvalue="2">{{ __('interactivity.video_poster_option2') }}</div>
                <input type="hidden" name="comp-{id}-posteroption" id="comp-{id}-posteroption" value="{{ $posteroption }}" />
            </div>
            <div class="fromfile{{ ($posteroption == 1 ? ' hide' : '') }}">
                <input type="file" name="comp-{id}-posterimage" id="comp-{id}-posterimage" class="hiddenFileHeight hidden" />
                <input type="hidden" name="comp-{id}-posterimageselected" id="comp-{id}-posterimageselected" value="{{ $posterImageSelected }}" />
                <input type="hidden" name="comp-{id}-posterimagename" id="comp-{id}-posterimagename" value="{{ $posterimagename }}" />
                <a class="btn expand uploadposterimage{{ ($posterImageSelected != 0 ? ' hide' : '') }}">{{ __('interactivity.video_poster_text') }} <i class="icon-upload"></i></a>
            </div>
            <div class="upload-poster">
                <div class="progress hide">
                	<a href="#">{{ __('interactivity.cancel') }} <i class="icon-remove"></i></a>
                    <label for="scale"></label>
                    <div class="scrollbox dot">
                        <div class="scale" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- end progress -->
                <a {{ (Str::length($posterimagename) > 0 ? 'href="'.$posterimagename.'" ' : '') }}target="_blank" class="poster-image modal-img{{ ($posterImageSelected == 0 ? ' hide' : '') }}">{{ Str::limit($posterimagename, 17) }}</a>
                <a class="close{{ ($posterImageSelected == 0 ? ' hide' : '') }}"><i class="icon-remove"></i></a>
                
                <span class="error hide"><i class="icon-exclamation-sign"></i>{{ __('interactivity.video_poster_error') }}</span>
            </div>
            <!-- end upload-poster --> 

            <div class="text dark" style="margin-top:10px;">
                <label for="comp-{id}-videodelay">{{ __('interactivity.animation_delay') }}</label>
                <input name="comp-{id}-videodelay" id="comp-{id}-videodelay" type="text" value="{{ $videodelay }}">
            </div>

        </div>
        <!-- end component-panel -->
        @include('interactivity.components.coordinates')
    </div>
    <!-- end settings -->
    <a href="#" class="btn delete expand remove">{{ __('interactivity.remove') }} <i class="icon-trash"></i></a>
</div>
<!-- end video --> 